@extends('layouts.default')
@section('title','更新个人资料')
@section('content')
    
    <div class="container">
        <div class="col-md-offset-2 com-md-8">
            
            <div class="panel panel-default">
                  <div class="panel-heading">
                        <h3 class="panel-title">更新个人资料</h3>
                  </div>
                  <div class="panel-body">
                  
                        @include('shared.errors')

                        <div class="gravatar_edit">
                            <a href="http://gravatar.com/emails" target="_blank">
                                <img src="{{ $user->gravatar('200') }}" alt="{{ $user->name }}" class="gravatar">
                            </a>
                        </div>

                        <form action="{{ route('users.update',$user->id) }}" method="post">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}

                            <div class="fomr-group">
                                <label for="name">名称：</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}">
                            </div>

                            <div class="fomr-group">
                                <label for="email">邮箱：</label>
                                <input type="text" name="email" id="email" class="form-control" value="{{ $user->email }}" disabled="disabled">
                            </div>

                            <div class="fomr-group">
                                <label for="password">密码：</label>
                                <input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}">
                            </div>

                            <div class="fomr-group">
                                <label for="password_confirmation">确认密码：</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}">
                            </div>

                            
                            <button type="submit" class="btn btn-primary">更新</button>
                            
                        </form>

                  </div>
            </div>
            
        </div>
    </div>
    
@endsection