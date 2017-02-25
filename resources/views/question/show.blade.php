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
        white-space: nowrap;
        cursor: pointer;
    }

    .topic:hover{
        background: #259;
        color: #fff;
        text-decoration: none;
    }

</style>
@section('content')
    @include('vendor.ueditor.assets')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>{{$question->title}}</h3></br>
                        @foreach($question->topics as $topic)
                            <a class="topic" href="/topic/{{$topic->id}}">{{$topic->name}}</a>
                        @endforeach
                    </div>
                    <div class="panel-body">
                        {!! $question->body !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

