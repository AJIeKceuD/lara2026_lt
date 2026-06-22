<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Post extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    // Поля, которые можно массово заполнять
    protected $fillable = [
        'title',
        'slug',
        'content',
        'preview_image',
        'published_at',
        'reading_time',
    ];

    // Поля, которые будут переводиться
    public array $translatable = [
        'title',
        'slug',
        'content',
    ];

    // Преобразование типов
    protected $casts = [
        'published_at' => 'datetime',
        'reading_time' => 'integer',
    ];

    // Автоматическая генерация slug при создании
    protected static function booted(): void {
        static::creating(function ($post) {
            $locales = ['en', 'zh']; // Языки из вашего конфига
            
            foreach ($locales as $locale) {
                if (empty($post->getTranslation('slug', $locale, false))) {
                    $title = $post->getTranslation('title', $locale, false);
                    $post->setTranslation('slug', $locale, \Illuminate\Support\Str::slug($title));
                }
            }
        });
        
        // Автоматический подсчёт времени чтения (опционально)
        static::saving(function ($post) {
            if ($post->isDirty('content') && !$post->reading_time) {
                $post->calculateReadingTime();
            }

            $locales = ['en', 'zh']; // Языки из вашего конфига
            
            foreach ($locales as $locale) {
                if (empty($post->getTranslation('slug', $locale, false))) {
                    $title = $post->getTranslation('title', $locale, false);
                    $post->setTranslation('slug', $locale, \Illuminate\Support\Str::slug($title));
                }
            }
        });
    }

    // Метод для подсчёта времени чтения (примерно 200 слов в минуту)
    public function calculateReadingTime(): void {
        $totalWords = 0;
        $locales = ['en', 'zh'];
        
        foreach ($locales as $locale) {
            $content = $this->getTranslation('content', $locale);
            if ($content) {
                $totalWords += str_word_count(strip_tags($content));
            }
        }
        
        $avgWordsPerMinute = 200;
        $this->reading_time = max(1, ceil($totalWords / $avgWordsPerMinute));
    }

    // Scope для публикации (только опубликованные)
    public function scopePublished($query) {
        return $query->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    // Проверка, опубликована ли статья
    public function isPublished(): bool {
        return !is_null($this->published_at) && $this->published_at <= now();
    }

    // Выбираем посты у которых есть не пустой заголовок нужной локали
    public function scopeWhereTitleExists($query, string $locale)
    {
        return $query->whereNotNull("title->{$locale}")
                    ->where("title->{$locale}", '!=', '')
                    ->whereRaw("JSON_EXTRACT(title, '$.\"{$locale}\"') IS NOT NULL")
                    ->whereRaw("JSON_EXTRACT(title, '$.\"{$locale}\"') != ''");
    }

    // Получить URL статьи (для ЧПУ)
    public function getUrlAttribute(): string {
        return route('posts.show', $this->slug);
    }
}
