<?php

namespace App\Http\Controllers;

use App\Notifications\NewUserFollowNotification;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowersController extends Controller
{
    protected $user;
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function index($id){
        //问题的题主
        $user = $this->user->byId($id);
        //pluck方法能够将指定字段全部获取
        $followers = $user->followersUser()->pluck('follower_id')->toArray();
        //in_array(参数，数组),能够判断在该数组中是否存在，存在返回true
        if(in_array(Auth::guard('api')->user()->id,$followers)){
            return response()->json(['followed'=>true]);
        }

        return response()->json(['followed'=>false]);
    }

    public function follow(Request $request){
        $userToFollow = $this->user->byId($request->get('user'));
        $followed = Auth::guard('api')->user()->followThisUser($userToFollow->id);
        if(count($followed['detached'])>0){
            $userToFollow->decrement('followers_count');
            return response()->json(['followed'=>false]);
        }
        //触发到监听的数据
        $userToFollow->notify(new NewUserFollowNotification());
        $userToFollow->increment('followers_count');
        return response()->json(['followed'=>true]);
    }
}
