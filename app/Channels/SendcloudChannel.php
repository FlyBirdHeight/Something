<?php
/**
 * Created by PhpStorm.
 * User: jj
 * Date: 2017/3/2
 * Time: 21:16
 */

namespace App\Channels;


use Illuminate\Notifications\Notification;

class SendcloudChannel
{
    public function send($notifiable,Notification $notification){
        $message = $notification->toSendcloud($notifiable);
    }
}