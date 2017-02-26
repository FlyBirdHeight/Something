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
            <div class="col-md-8 col-md-offset-2">
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
                            <form action="/questions/{{$question->id}}" method="post">
                                {{method_field('DELETE')}}
                                {{csrf_field()}}
                                <button class="btn is-naked">删除</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

