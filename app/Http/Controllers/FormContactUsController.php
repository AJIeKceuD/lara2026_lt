<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormContactUs;
use App\Mail\FormContactUsMail;
use App\Services\TelegramService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class FormContactUsController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $form = FormContactUs::create([
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'is_read' => false,
                'meta' => [
                    'notifications' => [
                        'email' => ['sent' => false, 'sent_at' => null, 'error' => null],
                        'telegram' => ['sent' => false, 'sent_at' => null, 'error' => null],
                    ],
                ],
            ]);

            $this->sendEmailNotification($form);
            $this->sendTelegramNotification($form);

            return response()->json([
                'success' => true,
                'message' => 'Your message has been sent!',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred. Please try again.',
            ], 500);
        }
    }

    private function sendEmailNotification(FormContactUs $form): void
    {
        $emails = explode(',', env('CONTACT_EMAILS', ''));
        $emails = array_map('trim', $emails);
        $emails = array_filter($emails);

        if (empty($emails)) {
            $form->markNotificationFailed('email', 'No recipients configured');
            return;
        }

        try {
            Mail::to($emails)->send(new FormContactUsMail($form));
            $form->markNotificationSent('email');
        } catch (\Exception $e) {
            $form->markNotificationFailed('email', $e->getMessage());
        }
    }

    private function sendTelegramNotification(FormContactUs $form): void
    {
        $telegram = new TelegramService();

        try {
            $sent = $telegram->sendContactNotification($form->toArray());

            if ($sent) {
                $form->markNotificationSent('telegram');
            } else {
                $form->markNotificationFailed('telegram', 'Telegram API returned false');
            }
        } catch (\Exception $e) {
            // Маскируем токен в сообщении ошибки
            $errorMessage = $e->getMessage();
            $maskedError = $telegram->maskTelegramToken($errorMessage);

            $form->markNotificationFailed('telegram', $maskedError);
        }
    }
}
