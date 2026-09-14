<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class ProjectImage extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    protected $table = 'projects_images';

    protected $fillable = [
        'image_path',
        'title',
        'comment',
        'published_at',
    ];

    public array $translatable = ['title', 'comment'];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // Только опубликованные (не отложенные)
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
                     ->where('published_at', '<=', now())
                     ->orderBy('published_at', 'desc');
    }

    // Проверка, опубликовано ли
    public function isPublished(): bool
    {
        return $this->published_at && $this->published_at <= now();
    }

    public function scopeWhereTitleExists($query, ?string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return $query
            ->whereNotNull("title->{$locale}")
            ->where("title->{$locale}", '!=', '')
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(title, '$.\"{$locale}\"')) != ''");
    }

    public function scopeWithTitleLocale($query, ?string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return $query->whereNotNull("title->{$locale}")
                    ->where("title->{$locale}", '!=', '');
    }
}
