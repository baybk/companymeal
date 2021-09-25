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

class SendOrderDataToBotNotification extends Notification
{
    use Queueable;
    public $orderData;
    public $title;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title, $orderData)
    {
        $this->orderData = $orderData;
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
        $title = 'Mã đăng nhập ' . date('d-m-Y H:i') . ' :';
        return (new SlackMessage)
                    ->success()
                    ->content('MA DANG NHAP')
                    ->attachment(function ($attachment) use($title) {
                        $attachment->title($title)
                                ->fields($this->orderData);
                    });
    }

    public function toTelegram($notifiable)
    {
        $orderData = $this->orderData;
        $excludeKeys = [
            'team_id',
            'delivery_status',
            'payment_status',
        ];
        Log::info($orderData);
        foreach($excludeKeys as $item) {
            if (isset($orderData[$item])) {
                unset($orderData[$item]);
            }
        }
        $title = $this->title;
        $html = view('shared.telegram-order-data', compact('orderData', 'title'))->render();
        return new TelegramMessage([
            'parse_mode' => 'HTML',
            'text' => $html,
        ]);
    }
}
