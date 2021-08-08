<?php

declare(strict_types=1);

namespace Domains\Users\Notifications;

use Domains\Users\DataTransferObjects\UserData;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

final class PasswordSendNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected UserData $userData;

    public function __construct(UserData $userData)
    {
        $this->userData = $userData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('Благодарим за регистрацию в личном кабинете Kindergo')
            ->line('Зайти в личный кабинет вы можете по ссылке')
            ->action('Зайти в личный кабинет', url('/'))
            ->line('Доступы в личный кабинет сопровождающего:')
            ->line('Имя пользователя: ' . $this->userData->email)
            ->line('Пароль: ' . $this->userData->password?->getOriginal());
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
