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

class ReportWhenChangeBalanceNotification extends Notification
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

    public function via($notifiable)
    {
        if (env('BOT_PROVIDER', 'TELEGRAM') == 'TELEGRAM') {
            return [TelegramChannel::class];
        }
        return ['slack'];
    }

    public function toSlack($notifiable)
    {
        $title = '$$ Báo cáo thay đổi số dư mới nhất ' . date('d-m-Y H:i') . ' :';
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
        // $title = '$$ Báo cáo thay đổi số dư mới nhất ' . date('d-m-Y H:i') . ' :';
        return (new TelegramMessage())
                ->text(json_encode($this->arrayData));
    }
}
