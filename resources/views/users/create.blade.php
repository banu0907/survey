@extends('layouts.default')
@section('title','注册')
    
@section('content')

    <div class="container">
        <div class="col-md-offset-2 col-md-8">
            
            <div class="panel panel-default">
                  <div class="panel-heading">
                        <h3 class="panel-title">注册</h3>
                  </div>
                  <div class="panel-body">
                    @include('shared.errors')

                       <form action="{{ route('users.store') }}" method="POST" role="form">
                       {{ csrf_field() }}
                           <div class="form-group">
                               <label for="name">名称：</label>
                               <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}">
                           </div>
                       
                           
                           <div class="form-group">
                               <label for="email">邮箱：</label>
                               <input type="text" name="email" class="form-control" id="email" value="{{ old('email') }}">
                           </div>
                       
                       
                           <div class="form-group">
                               <label for="password">密码：</label>
                               <input type="password" name="password" class="form-control" id="password" value="{{ old('password') }}">
                           </div>
                       

                           <div class="form-group">
                               <label for="password_confirmation">确认密码：</label>
                               <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" value="{{ old('password_confirmation') }}">
                           </div>
                       
                           <button type="submit" class="btn btn-primary">注册</button>
                       </form>
                       
                  </div>
            </div>
            
        </div>
    </div>
    
@endsection