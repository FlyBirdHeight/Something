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

Route::middleware('api')->post('/question/follower', function (Request $request) {
    $follow = !! \App\Follow::where('question_id',$request->get('question'))
                            ->where('user_id',$request->get('user'))
                            ->count();
    if($follow){
        return response()->json(['followed' => true]);
    }
    return response()->json(['followed' => false]);
});

Route::middleware('api')->post('/question/follow', function (Request $request) {
    $follow = \App\Follow::where('question_id',$request->get('question'))
        ->where('user_id',$request->get('user'))
        ->first();
    if($follow !== null){
        $follow->delete();
        return response()->json(['followed' => false]);
    }
//    \Illuminate\Support\Facades\Auth::user()->followThis($request->get('question'));
    \App\Follow::create([
        'user_id' => $request->get('user'),
        'question_id' => $request->get('question')
    ]);
    return response()->json(['followed' => true]);
//    return response()->json(['question' => request('question')]);
});