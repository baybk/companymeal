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

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['slack'];
    }

    public function toSlack($notifiable)
    {
        $title = '$$ Báo cáo thay đổi số dư mới nhất ' . date('d-m-Y H:i') . ' :';
        $users = User::where('name', '!=', 'fakeUser1')->get();
        $arrayData = [];
        $i = 1;
        foreach ($users as $user) {
            $arrayData[$i . '. ' . $user->name] = number_format($user->balance) . ' VND';
            $i++;
        }
        return (new SlackMessage)
                    ->success()
                    ->content('REPORT')
                    ->attachment(function ($attachment) use($title, $arrayData) {
                        $attachment->title($title)
                                ->fields($arrayData);
                    });
    }
}
