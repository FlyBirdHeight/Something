<?php
/**
 * Created by PhpStorm.
 * User: jj
 * Date: 2017/3/6
 * Time: 20:51
 */

namespace App\Mailer;


use App\User;
use Illuminate\Support\Facades\Auth;
use Naux\Mail\SendCloudTemplate;
use Mail;

class UserMailer extends Mailer
{
    public function followNotifyEmail($email){
        $data = ['url' => 'http://127.0.0.1:8000/notifications','name'=> Auth::guard('api')->user()->name];
        $this->sendTo("zhihu_app_new_user_follow",$email,$data);
    }

    public function passwordReset($token,$email){
        $data = ['url' => route('password.reset', $token)];
        $this->sendTo("welcome",$email,$data);
    }

    public function welcome(User $user){
        $data = ['url' => route('email.verify',['token'=>$user->confirmation_token]),
            'name'=>$user->name
        ];
        $this->sendTo('welcome',$user->email,$data);
    }
}