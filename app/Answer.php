<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['user_id','question_id','body','votes_count',
        'comments_count','is_hidden','close_comment'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function question(){
        return $this->belongsTo(Question::class);
    }
    public function scopePublished($query)
    {
        return $query->where('is_hidden','F');
    }
    public function scopeClosedComment($query){
        return $query->where('close_comment','F');
    }
}
