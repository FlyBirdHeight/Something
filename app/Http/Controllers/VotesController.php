<?php

namespace App\Http\Controllers;

use App\Repositories\AnswerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VotesController extends Controller
{

    protected $answer;
    public function __construct(AnswerRepository $answer)
    {
        $this->answer = $answer;
    }

    public function index($id){
//        $answer = $this->answer->byId($id);
        $user = Auth::guard('api')->user();
        if($user->hasVotedFor($id)){
            return response()->json(['voted'=>true]);
        }
        return response()->json(['voted'=>false]);
    }

    public function vote(){

    }
}
