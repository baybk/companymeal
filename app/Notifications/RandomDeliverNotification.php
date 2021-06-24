<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class RandomDeliverNotification extends Notification
{
    use Queueable;
    public $userId;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if (env('BOT_PROVIDER', 'TELEGRAM') == 'TELEGRAM') {
            return [TelegramChannel::class];
        }
        return ['slack'];
    }

    public function toSlack($notifiable)
    {
        return (new SlackMessage)
                    ->success()
                    ->content('RANDOM')
                    ->attachment(function ($attachment) {
                        $attachment
                                ->fields([
                                    'ID người được chọn là: ' => $this->userId
                                ]);
                    });
    }
}
