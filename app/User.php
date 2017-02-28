<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Naux\Mail\SendCloudTemplate;
use Mail;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar','confirmation_token','api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function owns(Model $model){
        return $this->id == $model->user_id;
    }

    public function sendPasswordResetNotification($token){
        $data = ['url' => route('password.reset', $token)];
        $template = new SendCloudTemplate('welcome', $data);

        Mail::raw($template, function ($message){
            $message->from('adsionli@foxmail.com', 'Laravel');

            $message->to($this->email);
        });
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function follows(){
        return $this->belongsToMany(Question::class,'user_question')->withTimestamps();
    }

    public function followThis($question){
        //去绑定相关数据（填入中间表），数据库中不用有就创建，否则就删除,一般用在多对多中
        return $this->follows()->toggle($question);
    }

    public function followed($question){
        return !! $this->follows()->where('question_id',$question)->count();
    }
}
