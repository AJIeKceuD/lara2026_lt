<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

class TopImage extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    protected $table = 'top_images';

    protected $fillable = [
        'alt_text',
        'image_path',
        'original_name',
        'file_size',
        'languages',
        'published_at',
    ];

    // Поля для перевода
    public array $translatable = ['alt_text'];

    protected $casts = [
        'published_at' => 'datetime',
        'languages' => 'array', // Автоматически преобразуем JSON в массив
        'file_size' => 'integer',
    ];

    // Аксессор для форматирования размера файла
    public function getFormattedFileSizeAttribute(): string
    {
        if (!$this->file_size) return '—';
        
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    // Проверка, опубликовано ли изображение
    public function isPublished(): bool
    {
        return $this->published_at && 
               $this->published_at <= now();
    }

    // Проверка, показывать ли на определённом языке
    public function shouldShowOnLocale(string $locale): bool
    {
        if (empty($this->languages)) {
            return true; // Если не указано — показываем везде
        }
        
        return in_array($locale, $this->languages);
    }

    // Scope для получения опубликованных изображений
    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', now())
                     ->orderBy('published_at', 'desc');
    }

    // Scope для фильтрации по языку
    public function scopeForLocale($query, string $locale)
    {
        return $query->where(function ($q) use ($locale) {
            $q->whereNull('languages')
              ->orWhereRaw('JSON_LENGTH(languages) = 0')
            //   ->orWhere('languages', '[]')
              ->orWhereJsonContains('languages', $locale);
        });
    }

    // Удаление файла при полном удалении модели
    protected static function booted(): void
    {
        static::saving(function ($topImage) {
            // Если загружено новое изображение
            if ($topImage->isDirty('image_path') && $topImage->image_path) {
                $path = storage_path('app/public/' . $topImage->image_path);
                if (file_exists($path)) {
                    $topImage->file_size = filesize($path);
                    $topImage->original_name = basename($path);
                }
            }
        });
        static::forceDeleted(function ($topImage) {
            if ($topImage->image_path && Storage::disk('public')->exists($topImage->image_path)) {
                Storage::disk('public')->delete($topImage->image_path);
            }
        });
    }
}