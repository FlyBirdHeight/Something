@extends('layouts.app')
<style>
    .panel-body img{
        width: 100%;
    }
    .topic{
        background: #eff6fa;
        padding: 1px 10px 0;
        border-radius: 30px;
        text-decoration: none;
        margin: 0 5px 5px 0;
        display: inline-block;
        vertical-align: top;
        white-space: nowrap;
        cursor: pointer;
    }
    .topic:hover{
        background: #259;
        color: #fff;
        text-decoration: none;
    }
    .action{
        display: flex;
        padding: 10px 20px;
    }
    .is-naked{
        background: 0 0;
        border: none;
        border-radius: 0;
        padding: 0;
        height: auto;
    }
</style>
@section('content')
    @include('vendor.ueditor.assets')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{$question->title}}
                        @foreach($question->topics as $topic)
                            <a class="topic" href="/topic/{{$topic->id}}">{{$topic->name}}</a>
                        @endforeach
                    </div>
                    <div class="panel-body">
                        {!! $question->body !!}
                    </div>
                    <div class="action">
                        @if(Auth::check()&&Auth::user()->owns($question))
                            <span class="edit"> <a href="/questions/{{$question->id}}/edit">编辑</a></span>
                            <form action="/questions/{{$question->id}}" method="post" style="margin-left: 18px">
                                {{method_field('DELETE')}}
                                {{csrf_field()}}
                                <button class="btn is-naked">删除</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2>{{$question->followers_count}}</h2>
                        <span>关注者</span>
                    </div>
                    <div class="panel-body">
                        <a href="/questions/{{$question->id}}/follow" class="btn btn-default">
                            关注该问题
                        </a>
                        <a href="#editor" class="btn btn-success">撰写答案</a>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{$question->answers_count}}个答案
                    </div>
                    <div class="panel-body">
                        @foreach($question->answers as $answer)
                            <div class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <img src="{{$answer->user->avatar}}" alt="{{$answer->user->name}}" style="width: 36px">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="/user/{{$answer->user->id}}">
                                            {{$answer->user->name}}
                                        </a>
                                    </h4>
                                    {!! $answer->body !!}
                                </div>
                            </div>
                        @endforeach
                        @if(\Illuminate\Support\Facades\Auth::check())
                            <form method="post" action="/questions/{{$question->id}}/answer">
                            {!! csrf_field() !!}
                            <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                                <script id="editor" style="height:120px" name="content" type="text/plain">
                                    {!! old('content') !!}
                                </script>
                                @if ($errors->has('content'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('content') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button class="btn btn-success pull-right" type="submit" style="margin-top: 20px">
                                提交答案
                            </button>
                        </form>
                        @else
                            <a href="/login" class="btn btn-info pull-right">前往登陆</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('js')
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('editor', {
            toolbars: [
                ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft','justifycenter', 'justifyright',  'link', 'insertimage', 'fullscreen']
            ],
            elementPathEnabled: false,
            enableContextMenu: false,
            autoClearEmptyNode:true,
            wordCount:false,
            imagePopup:false,
            autotypeset:{ indent: true,imageBlockLine: 'center' }
        });
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{csrf_token()}}'); // 设置 CSRF token.
        });
    </script>
@endsection
@endsection

