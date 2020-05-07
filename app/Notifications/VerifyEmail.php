<?php
namespace App\Notifications;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;

class VerifyEmail extends VerifyEmailBase
{
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable);
        }
        return (new MailMessage)
            ->subject('Подтвердите свою почту')
            ->line('Пожалуйста, нажмите на кнопку, чтобы подтвердить свою почту')
            ->action(('Подвердить почту'),
                $this->verificationUrl($notifiable)
            )
            ->line('Если вы не создавали никакой аккаунт, то... ой, всё');
    }
}
