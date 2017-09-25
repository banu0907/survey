@extends('layouts.default')
@section('title','首页')
@section('head_file')
    <link type="text/css" rel="stylesheet" href="css/base.css">
@endsection
@section('content')
    
    <div id="home_banner" class="jumbotron">
        <!-- <img id="home_banner_img" src="./images/chart_home01.jpg" alt=""> -->
        <div class="container">
            <h1>制定明智的决策</h1>
            <p>Contents ...</p>
            <div>
                <a class="btn btn-warning btn-lg">专业用户注册</a>
                <a class="btn btn-default btn-lg" href="{{ route('signup') }}">免费注册</a>

            </div>
        </div>
    </div>



    <div class="container">
        <div class="col-md-3 text-center">
            <a type="button" class="btn btn-info super-icon">
                <i class="fa fa-cogs"></i>
            </a>
            <h2>完全用户定制</h2>
        </div>
        <div class="col-md-3 text-center">
            <a type="button" class="btn btn-info super-icon">
            <i class="fa fa-wpexplorer"></i>
            </a>
            <h2>详尽样本筛选</h2>
        </div>
        <div class="col-md-3 text-center">
            <a type="button" class="btn btn-info super-icon">
            <i class="fa fa-cubes"></i>
            </a>
            <h2>全行业模板</h2>
        </div>
        <div class="col-md-3 text-center">
            <a type="button" class="btn btn-info super-icon">
            <i class="fa fa-line-chart"></i>
            </a>
            <h2>统计图表丰富</h2>
        </div>
    </div>

@endsection