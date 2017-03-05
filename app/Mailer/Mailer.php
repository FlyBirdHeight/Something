<?php
/**
 * Created by PhpStorm.
 * User: jj
 * Date: 2017/3/4
 * Time: 12:56
 */

namespace App\Mailer;
use Illuminate\Support\Facades\Auth;
use Mail;
use Naux\Mail\SendCloudTemplate;

class Mailer
{
    public function sendTo($template,array $data,$email){
        $data = ['url' => route('password.reset'), 'name'=>Auth::guard('api')->user()->name];
        $template = new SendCloudTemplate($template, $data);

        Mail::raw($template, function ($message) use ($email){
            $message->from('adsionli@foxmail.com', 'Laravel');

            $message->to($email);
        });
    }
}