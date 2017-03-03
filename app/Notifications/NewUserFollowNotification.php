<?php

namespace App\Notifications;

use App\Channels\SendcloudChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Naux\Mail\SendCloudTemplate;

class NewUserFollowNotification extends Notification
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

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
//        ,SendcloudChannel::class
    }


//    public function toSendcloud($notifiable){
//        $data = ['url' => 'http://127.0.0.1:8000/notifications','name'=> Auth::guard('api')->user()->name];
//        $template = new SendCloudTemplate('zhihu_app_new_user_follow', $data);
//
//        Mail::raw($template, function ($message) use ($notifiable){
//            $message->from('adsionli@foxmail.com', 'Laravel');
//
//            $message->to($notifiable->email);
//        });
//    }

    public function toDatabase($notifiable){
        return [
            'name'=> Auth::guard('api')->user()->name
        ];
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
