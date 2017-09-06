@extends('layouts.default')
@section('title','登录')

@section('content')
<div class="container">
    <div class="col-md-offset-2 col-md-8">
        
        <div class="panel panel-default">
              <div class="panel-heading">
                    <h3 class="panel-title">登陆</h3>
              </div>
              <div class="panel-body">
                    @include('shared.errors')

                    <form method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="email">邮箱：</label>
                            <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}">
                        </div>

                        <div class="form-group">
                            <label for="password">密码：</label>
                            <input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}">
                        </div>

                        <div class="checkbox">
                            <label><input type="checkbox" name="remember" checked="checked">记住我</label>
                        </div> 

                        <button type="submit" class="btn btn-primary">登录</button>

                    </form>

                    <hr>

                    <p>还没账号？<a href="{{ route('signup') }}">现在注册！</a></p>
              </div>
        </div>
        
    </div>
</div>
@endsection