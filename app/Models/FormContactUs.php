<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormContactUs extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'form_contact_us';

    protected $fillable = [
        'name',
        'email',
        'message',
        'meta',
        'ip_address',
        'user_agent',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'meta' => 'array',
    ];

    // Проверка, было ли отправлено уведомление
    public function notificationSent(string $channel): bool
    {
        return $this->meta['notifications'][$channel]['sent'] ?? false;
    }

    // Получить ошибку уведомления
    public function notificationError(string $channel): ?string
    {
        return $this->meta['notifications'][$channel]['error'] ?? null;
    }

    // Получить время отправки уведомления
    public function notificationSentAt(string $channel): ?string
    {
        return $this->meta['notifications'][$channel]['sent_at'] ?? null;
    }

    // Отметить уведомление как отправленное
    public function markNotificationSent(string $channel): void
    {
        $meta = $this->meta ?? [];
        $meta['notifications'][$channel] = [
            'sent' => true,
            'sent_at' => now()->toISOString(),
            'error' => null,
        ];
        $this->update(['meta' => $meta]);
    }

    // Отметить уведомление как неотправленное с ошибкой
    public function markNotificationFailed(string $channel, string $error): void
    {
        $meta = $this->meta ?? [];
        $meta['notifications'][$channel] = [
            'sent' => false,
            'sent_at' => null,
            'error' => $error,
        ];
        $this->update(['meta' => $meta]);
    }

    // Получить все уведомления
    public function getNotificationsAttribute(): array
    {
        return $this->meta['notifications'] ?? [];
    }
}
