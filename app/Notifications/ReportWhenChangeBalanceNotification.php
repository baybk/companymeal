<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

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
}
