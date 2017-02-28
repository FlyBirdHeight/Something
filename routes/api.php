<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->get('/topics',function (Request $request){
   $topics = \App\Topic::select(['id','name'])
       ->where('name','like','%'.$request->query('q').'%')
       ->get();
   return $topics;
});

Route::middleware('auth:api')->post('/question/follower', function (Request $request) {
    //这玩意能够防止有心的用户恶意的多次请求，通过登陆进来的用的api来获取用户的资料！
    $user = \Illuminate\Support\Facades\Auth::guard('api')->user();
    $follow = !! $user->followed($request->get('question'));
    if($follow){
        return response()->json(['followed' => true]);
    }
    return response()->json(['followed' => false]);
});

Route::middleware('auth:api')->post('/question/follow', function (Request $request) {
    $user = \Illuminate\Support\Facades\Auth::guard('api')->user();
    $question = \App\Question::find($request->get('question'));
    $follow = \App\Follow::where('question_id',$request->get('question'))
        ->where('user_id',$user->id)
        ->first();
    if($follow !== null){
        $follow->delete();
        $question->decrement('follower_count');
        return response()->json(['followed' => false]);
    }
    $user->followThis($request->get('question'));
    $question->increment('follower_count');
    return response()->json(['followed' => true]);
});