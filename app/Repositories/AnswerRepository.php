<?php
/**
 * Created by PhpStorm.
 * User: jj
 * Date: 2017/2/26
 * Time: 20:49
 */

namespace App\Repositories;


use App\Answer;

class AnswerRepository
{
    public function create(array $attributes){
        return Answer::create($attributes);
    }

    public function byId($id){
        return Answer::find($id);
    }
}