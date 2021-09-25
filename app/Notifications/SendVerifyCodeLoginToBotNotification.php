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

class SendVerifyCodeLoginToBotNotification extends Notification
{
    use Queueable;
    public $code;
    public $title;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title, $code)
    {
        $this->code = $code;
        $this->title = $title;
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
        $title = $this->title;
        return (new SlackMessage)
                    ->success()
                    ->content($this->$title)
                    ->attachment(function ($attachment) use($title) {
                        $attachment->title($title)
                                ->fields($this->code);
                    });
    }

    public function toTelegram($notifiable)
    {
        $code = $this->code;
        $title = $this->title;
        $html = view('shared.telegram-verify-code', compact('code', 'title'))->render();
        return new TelegramMessage([
            'parse_mode' => 'HTML',
            'text' => $html,
        ]);
    }
}
