<?php
/**
 * Created by PhpStorm.
 * User: jj
 * Date: 2017/2/25
 * Time: 16:04
 */

namespace App\Repositories;


use App\Question;
use App\Topic;

class QuestionRepository
{
    public function byIdWithTopics($id){
        //with可以获取到多对多关联的数据放置在$question中！
        return Question::where('id',$id)->with('topics')->first();
    }

    public function createQuestion(array $data){
        return Question::create($data);
    }

    public function normalizeTopic(array $topics){
        return collect($topics)->map(function ($topic){
            if(is_numeric($topic)){
                Topic::find($topic)->increment('questions_count');
                return (int)$topic;
            }
            $newTopic = Topic::create(['name'=>$topic,'questions_count'=>1]);
            return $newTopic->id;
        })->toArray();
    }

    public function byId($id){
        return Question::find($id);
    }

    public function getAllQuestions(){
        return Question::published()->latest('updated_at')->with('user')->get();
    }
}