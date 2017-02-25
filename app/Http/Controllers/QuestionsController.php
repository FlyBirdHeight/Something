<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionsController extends Controller
{
    protected $questionRepository;
    public function __construct(QuestionRepository $questionRepository)
    {
        $this->middleware('auth')->except(['index','show']);
        $this->questionRepository = $questionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('question.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $topics = $this->questionRepository->normalizeTopic($request->get('topics'));
        $rules = [
            'title'=> 'required|between:6,196',
            'content' => 'required|min:26'
        ];
        $message = [
            'title.required' => '标题不能为空！',
            'title.between' =>'标题在6-196个字符之间！',
            'content.required'=>'问题内容不能为空',
            'content.min' => '问题内容要大于26个字符'
        ];
        $this->validate($request,$rules,$message);
        $data = [
            'title'=>$request->get('title'),
            'body'=> $request->get('content'),
            'user_id'=>Auth::id(),
        ];
        $question = $this->questionRepository->createQuestion($data);
        //进行多对多关系关联（可以直接对数组进行操作）
        $question->topics()->attach($topics);
        return redirect()->route('question.show',[$question->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = $this->questionRepository->byIdWithTopics($id);
        //dd(json_encode($question));
        return view('question.show',compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = $this->questionRepository->byId($id);
        if(Auth::user()->owns($question)){
            return view('question.update',compact('question'));
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreQuestionRequest $request, $id)
    {
        $question = $this->questionRepository->byId($id);
        $question->update([
            'title'=>$request->get('title'),
            'body'=>$request->get('content')
        ]);
        $topics = $this->questionRepository->normalizeTopic($request->get('topics'));
        //sync是同步功能
        $question->topics()->sync($topics);
        return redirect()->route('question.show',[$question->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
