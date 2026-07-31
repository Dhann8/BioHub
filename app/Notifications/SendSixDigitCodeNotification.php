<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendSixDigitCodeNotification extends Notification
{
    use Queueable;

    public string $code;

    public function __construct(string $code)
    {
        $this->code = $code; // 6 digit angka
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Kode Reset Password Anda')
            ->greeting('Halo!')
            ->line('Berikut adalah kode 6 digit untuk mereset kata sandi Anda:')
            ->line('**' . $this->code . '**') // Menampilkan kode 6 digit
            ->line('Kode ini berlaku selama 15 menit.')
            ->line('Jika Anda tidak meminta reset password, abaikan email ini.');
    }
}