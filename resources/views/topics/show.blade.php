@extends('layouts.app')

@section('title', $topic->title)
@section('description', $topic->excerpt)

@section('content')

<div class="row">

    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs author-info">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="text-center">
                    作者：{{ $topic->user->name }}
                </div>
                <hr>
                <div class="media">
                    <div align="center">
                        <a href="{{ route('users.show', $topic->user->id) }}">
                            <img class="thumbnail img-responsive" src="{{ $topic->user->avatar }}" width="300px" height="300px">
                        </a>
                        @include('users._stats',['user' => $topic->user]) 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 topic-content">
        <div class="panel panel-default">
            <div class="panel-body">
                <h1 class="text-center">
                    {{ $topic->title }}
                </h1>

                <div class="article-meta text-center">
                    {{ $topic->created_at->diffForHumans() }}
                    ⋅
                    <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
                    {{ $topic->reply_count }}
                </div>

                <div class="topic-body">
                    {!! $topic->body !!}
                </div>

                @can('update', $topic)
                <div class="operate">
                    <hr>
                    <a href="{{ route('topics.edit', $topic->id) }}" class="btn btn-default btn-xs pull-left" role="button">
                        <i class="glyphicon glyphicon-edit"></i> 编辑
                    </a>

                    <form action="{{ route('topics.destroy', $topic->id) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-default btn-xs pull-left" style="margin-left: 6px" onclick="return confirm('确定要删除么?')">
                            <i class="glyphicon glyphicon-trash"></i>
                            删除
                        </button>
                    </form>
                </div>
                @endcan

            </div>
        </div>
        {{-- 用户回复列表 --}}
        <div class="panel panel-default topic-reply">
            <div class="panel-body">
                @includeWhen(Auth::check(), 'topics._reply_box', ['topic' => $topic])
                @include('topics._reply_list')
            </div>
        </div>
    </div>
</div>
@stop
@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/jquery.atwho.css')}}" >
@endsection
@section('scripts')
<script type="text/javascript"  src="{{ asset('js/jquery.caret.js') }}"></script>
<script type="text/javascript"  src="{{ asset('js/jquery.atwho.js') }}"></script>

<script>
                            $('#reply-textarea').atwho({
                                at: "@",
                                callbacks: {
                                    remoteFilter: function (query, callback) {
                                        $.getJSON("/usersjson", {key: query}, function (data) {
                                            callback(data)
                                        });
                                    }
                                }
                            })
</script>
@endsection