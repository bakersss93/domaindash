<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    public function createNotification(User $user, string $type, array $details = []): Notification
    {
        return Notification::create([
            'user_id' => $user->id,
            'notification_type' => $type,
            'details' => $details,
            'is_read' => false,
        ]);
    }

    public function sendEmail(User $user, string $type, array $data = []): void
    {
        $template = EmailTemplate::where('template_type', $type)->first();
        if (!$template) {
            return;
        }

        $placeholders = array_merge([
            'customer_name' => $user->first_name ?? $user->name,
        ], $data);

        $subject = $this->replacePlaceholders($template->subject, $placeholders);
        $body = $this->replacePlaceholders($template->body, $placeholders);

        Mail::html($body, function ($message) use ($user, $subject) {
            $message->to($user->email)->subject($subject);
        });
    }

    private function replacePlaceholders(string $text, array $data): string
    {
        foreach ($data as $key => $value) {
            $text = str_replace('{{ '.$key.' }}', $value, $text);
        }
        return $text;
    }

    public function notify(User $user, string $type, array $details = [], array $emailData = []): void
    {
        $this->createNotification($user, $type, $details);
        $this->sendEmail($user, $type, $emailData);
    }
}
