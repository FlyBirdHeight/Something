<?php

namespace App\Http\Controllers;

use App\Repositories\AnswerRepository;
use Illuminate\Http\Request;

class VotesController extends Controller
{

    protected $answer;
    public function __construct(AnswerRepository $answer)
    {
        $this->answer = $answer;
    }

    public function index($id){
        $answer = $this->answer->byId($id);
    }

    public function vote(){

    }
}
