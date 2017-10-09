@extends('layouts.default')
@section('title',$user->name)
@section('content')
    {{ $user->name }} - {{ $user->email }}

<div class="container">
    <div class="col-md-2">
        <section class="user_info">
            @include('shared.user_info',['user'=>$user])
            <div><a href="{{ route('users.edit',Auth::user()->id) }}">编辑个人资料</a></div>
        </section>
    </div>
    <div class="col-md-10">
        <ul class="list-group">
            <li class="list-group-item"><a href="#">我填写的问卷</a></li>
            <li class="list-group-item"><a href="{{ route('surveys.index') }}">我发布的问卷</a></li>
        </ul>

    </div>
</div>
@endsection