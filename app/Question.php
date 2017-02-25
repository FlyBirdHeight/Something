<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'title', 'body', 'user_id','comments_count','follower_count',
        'answers_count','close_comment','is_hidden'
    ];

    public function isHidden(){
        return $this->is_hidden === 'T'; //$question->isHidden()
    }
    public function topics()
    {
        return $this->belongsToMany(Topic::class)->withTimestamps();
        //如果表明不是question_topic则return $this->belongsToMany(Topic::class,'your table name')->withTimestamps();
    }

}
