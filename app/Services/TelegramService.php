<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TelegramService
{
    protected string $token;
    protected string $chatId;

    public function __construct()
    {
        $this->token = env('TELEGRAM_BOT_TOKEN');
        $this->chatId = env('TELEGRAM_CHAT_ID');
    }

    public function sendMessage(string $message): bool
    {
        if (empty($this->token) || empty($this->chatId)) {
            return false;
        }

        $url = "https://api.telegram.org/bot{$this->token}/sendMessage";

        $response = Http::timeout(3)->post($url, [
            'chat_id' => $this->chatId,
            'text' => $message,
            'parse_mode' => 'HTML',
        ]);

        return $response->successful();
    }

    public function sendContactNotification(array $data): bool
    {
        $message = "<b>📩 New Contact Message</b>\n\n"
            . "<b>Name:</b> {$data['name']}\n"
            . "<b>Email:</b> {$data['email']}\n"
            . "<b>Message:</b>\n{$data['message']}\n\n"
            . "🕐 Sent: " . now()->format('d.m.Y H:i');

        return $this->sendMessage($message);
    }

    /**
     * Маскирует токен в строке с URL
     */
    public function maskTelegramToken(string $message): string
    {
        // Ищем шаблон: bot123456:ABCdef... в URL
        return preg_replace(
            '/bot[a-zA-Z0-9_\-:]+/',
            'bot***MASKED***',
            $message
        );
    }
}
