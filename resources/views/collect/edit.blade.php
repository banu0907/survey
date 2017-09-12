@extends('layouts.default')
@section('title','数据采集与发布')

@section('content')
<div class="container">
    <div class="survey_title row">
        <h2>{{ $survey->survey }}</h2>
    </div>
    <div class="row">
        <ul class="nav nav-tabs">
            <li><a href="survey_summary.html">摘要</a></li>
            <li><a href="{{ route('create',[$survey]) }}">设计调查问卷</a></li>
            <li class="active"><a href="#">收集回复</a></li>
            <li><a href="survey_analyze.html">分析结果</a></li>
        </ul>
    </div>
    <div class="row">
	    <h1>
		<i class="fa fa-link"></i>
    	{{ url('/') }}
    	</h1>
    </div>

	<div class="row">
		<div class="col-sm-8">
			主栏内容
<div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-toggle="collapse" data-parent="#accordion" href="#collapse-1">
          Collapsible Group Item #1
        </a>
      </h4>
    </div>
    <div id="collapse-1" class="panel-collapse collapse in">
      <div class="panel-body">
        Anim 
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-toggle="collapse" data-parent="#accordion" href="#collapse-2">
          Collapsible Group Item #2
        </a>
      </h4>
    </div>
    <div id="collapse-2" class="panel-collapse collapse">
      <div class="panel-body">
        Anim pariatur 
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-toggle="collapse" data-parent="#accordion" href="#collapse-3">
          Collapsible Group Item #3
        </a>
      </h4>
    </div>
    <div id="collapse-3" class="panel-collapse collapse">
      <div class="panel-body">
        Anim 4
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-toggle="collapse" data-parent="#accordion" href="#collapse-4">
          Collapsible Group Item #3
        </a>
      </h4>
    </div>
    <div id="collapse-4" class="panel-collapse collapse">
      <div class="panel-body">
        Anim 4
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-toggle="collapse" data-parent="#accordion" href="#collapse-5">
          Collapsible Group Item #3
        </a>
      </h4>
    </div>
    <div id="collapse-5" class="panel-collapse collapse">
      <div class="panel-body">
        Anim 4
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-toggle="collapse" data-parent="#accordion" href="#collapse-6">
          Collapsible Group Item #3
        </a>
      </h4>
    </div>
    <div id="collapse-6" class="panel-collapse collapse">
      <div class="panel-body">
        Anim 4
      </div>
    </div>
  </div>

</div>
		</div>
		<div class="col-sm-4">
			侧栏内容
		</div>
	</div>
</div>
@endsection