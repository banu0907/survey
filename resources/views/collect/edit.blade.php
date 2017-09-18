@extends('layouts.default')
@section('title','数据采集与发布')
@section('head_file')
   <script type="text/javascript" src="{{ url('/') }}/js/survey_collect.js"></script> 
@endsection

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
          多次回覆：
        </a>
      </h4>
    </div>
    <div id="collapse-1" class="panel-collapse collapse in">
      <div class="panel-body">
        <p><label for=""><input type="radio" name="" id="">开启，允许多次。</label></p>
        <p><label for=""><input type="radio" name="" id="" checked="checked">关闭，仅允许进行一次。</label></p>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-toggle="collapse" data-parent="#accordion" href="#collapse-2">
          回复编辑：
        </a>
      </h4>
    </div>
    <div id="collapse-2" class="panel-collapse collapse">
      <div class="panel-body">
        <p><label for=""><input type="radio" name="" id="" checked="checked">开启，受访者可以任何调查问卷页面中变更答案，直到完成调查问卷</label></p>
        <p><label for=""><input type="radio" name="" id="">开启，受访者可以完成调查问卷之后变更答案。</label></p>
        <p><label for=""><input type="radio" name="" id="">关闭，受访者在离开调查问卷页面之后无法变更答案。</label></p>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-toggle="collapse" data-parent="#accordion" href="#collapse-3">
          匿名回复：
        </a>
      </h4>
    </div>
    <div id="collapse-3" class="panel-collapse collapse">
      <div class="panel-body">
        <p><label for=""><input type="radio" name="" id="">开启，你的受访者均为匿名</label></p>
        <p><label for=""><input type="radio" name="" id="" checked="checked">关闭，在您调查问卷结果中加入受访者的IP地址</label></p>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-toggle="collapse" data-parent="#accordion" href="#collapse-4">
          即时结果：
        </a>
      </h4>
    </div>
    <div id="collapse-4" class="panel-collapse collapse">
      <div class="panel-body">
        <p><label for=""><input type="radio" name="" id="">开启，向受访者显示结果。</label></p>
        <p><label for=""><input type="radio" name="" id="" checked="checked">关闭，不向受访者显示结果。</label></p>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-toggle="collapse" data-parent="#accordion" href="#collapse-5">
          截止日期与时间：
        </a>
      </h4>
    </div>
    <div id="collapse-5" class="panel-collapse collapse">
      <div class="panel-body">
        <p>
          <label for=""><input type="radio" name="" id="">开启，在指定日期与时间关闭。</label>
          <div>
            <input type="text" name="" id="">
          </div>
        </p>
        <p><label for=""><input type="radio" name="" id="" checked="checked">关闭，接受回覆，直到你手动关闭为止。</label></p>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-toggle="collapse" data-parent="#accordion" href="#collapse-6">
          设定可接受的回覆数量上限
        </a>
      </h4>
    </div>
    <div id="collapse-6" class="panel-collapse collapse">
      <div class="panel-body">
        <p>
          <label for=""><input type="radio" name="" id="">开启，在收集到指定的回覆数量之后关闭。</label>
          <div>
            输入最大回覆数字<input type="text" name="" id="">
          </div>
        </p>
        <p><label for=""><input type="radio" name="" id="" checked="checked">关闭，接受回覆，直到你手动关闭为止。</label></p>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-toggle="collapse" data-parent="#accordion" href="#collapse-7">
          IP 限制：
        </a>
      </h4>
    </div>
    <div id="collapse-7" class="panel-collapse collapse">
      <div class="panel-body">
        <p>
          <label for=""><input type="radio" name="" id="">开启，封锁指定 IP 地址的电脑，使其无法回复你的调查问卷</label>
          <div>
            <textarea name="" id="" cols="60" rows="5"></textarea>
          </div>
        </p>
        <p>
          <label for=""><input type="radio" name="" id="">开启，允许指定 IP 地址的电脑回复您的问卷。</label>
          <div>
            <textarea name="" id="" cols="60" rows="5"></textarea>
          </div>
        </p>
        <p>
          <label for=""><input type="radio" name="" id="" checked="checked">关闭，不限制任何 IP 地址回覆调查问卷。</label>
        </p>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-toggle="collapse" data-parent="#accordion" href="#collapse-8">
          Collapsible Group Item #3
        </a>
      </h4>
    </div>
    <div id="collapse-8" class="panel-collapse collapse">
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