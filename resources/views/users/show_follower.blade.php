@extends('layouts.app')
@section('title', $title)

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="col-md-offset-2 col-md-8">
            <section class="user_info">
                @include('users._user_info', ['user' => $user])
            </section>
            <section class="stats">
                @include('users._stats', ['user' => $user])
            </section>
        </div>
    </div>
    <div class="col-md-offset-2 col-md-8">
        @if (Auth::check())
        @include('users._follow_form')
        @endif
        <h3 class='center'>{{ $title }}</h3>
        <ul class="users">
            @if(count($users))
            @foreach ($users as $user)
            <li>
                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="gravatar"/>
                <a href="{{ route('users.show', $user->id )}}" class="username">{{ $user->name }}</a>
            </li>
            @endforeach
        </ul>
                
        {!! $users->render() !!}
           @else
           <h5>没有数据呦~o(╯□╰)o!</h5>
           @endif
    </div>
</div>
@endsection

