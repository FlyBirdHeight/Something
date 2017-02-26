<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'title', 'body', 'user_id','comments_count','follower_count',
        'answers_count','close_comment','is_hidden'
    ];

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class)->withTimestamps();
        //如果表明不是question_topic则return $this->belongsToMany(Topic::class,'your table name')->withTimestamps();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    //能够取到我们需要取到的东西,用法见QuestionRepository
    public function scopePublished($query)
    {
        return $query->where('is_hidden','F');
    }
}
