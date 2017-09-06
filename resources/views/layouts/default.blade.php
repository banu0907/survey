<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link type="text/css" rel="stylesheet" href="{{ url('/') }}/css/app.css">
    <link type="text/css" rel="stylesheet" href="{{ url('/') }}/css/font-awesome.min.css">
    <script type="text/javascript" src="{{ url('/') }}/js/app.js"></script>
    @yield('head_file')
    <title>@yield('title','爱果调查') - 爱果调查</title>
</head>

<body>

    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ route('home') }}">
                 <img src="{{ url('/') }}/images/logo.png" alt="" height="30">
                </a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="#">样本服务</a>
                    </li>
                    <li><a href="#">调研分享</a></li>
                    <li><a href="#">问卷横板</a></li>
                    <li><a href="#">调研发布</a></li>
                </ul>

                <form action="#" class="navbar-form navbar-left">
                    <div class="form-group">
                        <label for="search" class="sr-only">搜索</label>
                        <input type="text" class="form-control" id="search" placeholder="关键词">
                    </div>
                    <button type="submit" class="btn btn-primary">搜索</button>
                </form>

            @if(Auth::check())
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            {{ Auth::user()->name }} <span class="caret"></span> </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('users.show',Auth::user()->id) }}">我的帐户</a></li>
                            <li><a href="#">资源库</a></li>
                            <li><a href="#">联系人</a></li>
                            <li><a href="{{ route('help') }}">帮助中心</a></li>
                            <li>
                            <a id="logout" href="#">
                                <form action="{{ route('logout') }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-block btn-danger" name="button">登出</button>
                                </form>
                            </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="nav navbar-nav navbar-right">
                    <a href="" class="btn btn-warning navbar-btn">升级</a>
                    <a href="{{ route('surveys.create') }}" class="btn btn-default navbar-btn">建立调查问卷</a>
                </div>
            @else
                <div class="nav navbar-nav navbar-right">
                    <a href="{{ route('login') }}" class="btn btn-success navbar-btn">登入</a>
                </div>
            @endif

            </div>

        </div>
    </nav>
@include('shared.messages')
@yield('content')

    <div id="footer">
        <div class="container">
        <p>&nbsp;</p>
            <p>版权©：北京爱果科技有限公司</p>
            {{ url('/')}}
        </div>
    </div>

</body>

</html>