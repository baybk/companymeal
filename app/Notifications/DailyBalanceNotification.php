<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use TelegramNotifications\Messages\TelegramMessage;
use TelegramNotifications\TelegramChannel;

class DailyBalanceNotification extends Notification
{
    use Queueable;
    public $arrayData;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($arrayData)
    {
        $this->arrayData = $arrayData;
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
        $title = '$$ Báo cáo số dư sau ngày ' . date('d-m-Y') . ' :';
        return (new SlackMessage)
                    ->success()
                    ->content('REPORT')
                    ->attachment(function ($attachment) use($title) {
                        $attachment->title($title)
                                ->fields($this->arrayData);
                    });
    }

    public function toTelegram($notifiable)
    {
        $title = '$$ Báo cáo số dư sau ngày ' . date('d-m-Y') . ' :';
        return (new TelegramMessage())
                ->text(json_encode($this->arrayData));
    }
}
