<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerRequest;
use App\Repositories\AnswerRepository;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller
{
    protected $answer;
    protected $questions;
    public function __construct(AnswerRepository $answer,QuestionRepository $questions)
    {
        $this->answer = $answer;
        $this->questions = $questions;
    }

    public function store(StoreAnswerRequest $request,$question)
    {
//        dd($request);
        if(Auth::check()){
            $answer = $this->answer->create([
                'question_id' => $question,
                'user_id' => Auth::id(),
                'body' => $request->get('content')
            ]);
            $answer->question()->increment('answers_count');
            return back();
        }
        return redirect()->route('login');
    }
}
