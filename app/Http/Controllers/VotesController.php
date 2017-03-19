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
        $user = Auth::guard('api')->user();
        if($user->hasVotedFor($id)){
            return response()->json(['voted'=>true]);
        }
        return response()->json(['voted'=>false]);
    }

    public function vote(Request $request){
        $userToVote = $this->answer->byId($request->get('answer'));
        $user = Auth::guard('api')->user();
        $userVote = $user->voteThis($userToVote->id);
        if(count($userVote['detached'])!=0){
            $userToVote->decrement('votes_count');
            return response()->json(['voted'=>false,'count'=>$userToVote->votes_count]);
        }
        $userToVote->increment('votes_count');
        return response()->json(['voted'=>true,'count'=>$userToVote->votes_count]);
    }
}
