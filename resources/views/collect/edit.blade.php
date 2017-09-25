@extends('layouts.default')
@section('title','数据采集与发布')
@section('head_file')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ url('/') }}/css/ecalendar.css">
<style type="text/css">
  #collect_up_info {
     position: fixed;
     z-index: 2200;
     top: 5em;
     right: 2em;
     display: none;
  }
  .hide-input {
    display: none;
  }
</style>
  <script type="text/javascript" src="{{ url('/') }}/js/Ecalendar.jquery.min.js"></script>
  <script type="text/javascript">
    var app_url   = "{{ url('/') }}";
    var survey_id = {{ $survey->id }};
  </script>
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
		<!--	主栏内容  -->
<div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-toggle="collapse" data-parent="#accordion" href="#collapse-1">
          多次回复：
        </a>
      </h4>
    </div>
    <div id="collapse-1" class="panel-collapse collapse in">
      <div class="panel-body">
        <p>
          <label>
            <input type="radio" name="allow_multiple_responses" id="" value="true">
         开启，允许多次。
         </label>
       </p>
        <p>
          <label>
            <input type="radio" name="allow_multiple_responses" id="" checked="checked" value="false">
          关闭，仅允许进行一次。
          </label>
        </p>
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
        <p>
          <label>
            <input type="radio" name="edit-responses" id="" checked="checked" value="until_complete">开启，受访者可以任何调查问卷页面中变更答案，直到完成调查问卷
          </label>
        </p>
        <p>
          <label>
            <input type="radio" name="edit-responses" id="" value="always">
          开启，受访者可以完成调查问卷之后变更答案。
        </label>
      </p>
        <p>
          <label>
            <input type="radio" name="edit-responses" id="" value="never">
          关闭，受访者在离开调查问卷页面之后无法变更答案。
        </label>
      </p>
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
        <p>
          <label>
            <input type="radio" name="make-anonymous" id="" value="fully_anonymous">
          开启，你的受访者均为匿名
        </label>
      </p>
        <p>
          <label>
            <input type="radio" name="make-anonymous" id="" checked="checked" value="not_anonymous">
          关闭，在您调查问卷结果中加入受访者的IP地址
        </label>
      </p>
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
        <p>
          <label>
            <input type="radio" name="instant-results" id="" value="true">
          开启，向受访者显示结果。
         </label>
        </p>
        <p>
          <label>
            <input type="radio" name="instant-results" id="" checked="checked" value="false">
          关闭，不向受访者显示结果。
         </label>
        </p>
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
          <label>
            <input type="radio" name="cutoff-date" id="" value="true">
          开启，在指定日期与时间关闭。
          </label>
          <div id="cutoff-input" class="hide-input">
            <input type="text" name="cutoff_datepicker" id="cutoff_datepicker" class="date">
          </div>
        </p>
        <p>
          <label>
            <input type="radio" name="cutoff-date" id="" checked="checked" value="false">
            关闭，接受回复，直到你手动关闭为止。
          </label>
        </p>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-toggle="collapse" data-parent="#accordion" href="#collapse-6">
          设定可接受的回复数量上限
        </a>
      </h4>
    </div>
    <div id="collapse-6" class="panel-collapse collapse">
      <div class="panel-body">
        <p>
          <label>
            <input type="radio" name="max-responses" id="" value="true">
            开启，在收集到指定的回复数量之后关闭。
          </label>
          <div id="max-responses-input" class="hide-input">
            输入最大回复数字
            <input type="text" name="max-response-count" id="max-response-count">
          </div>
        </p>
        <p>
          <label>
            <input type="radio" name="max-responses" id="" checked="checked" value="false">
          关闭，接受回复，直到你手动关闭为止。
          </label>
        </p>
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
          <label>
            <input type="radio" name="ipaccess" id="" value="blacklist">
            开启，封锁指定 IP 地址的电脑，使其无法回复你的调查问卷
          </label>
          <div id="ip-b" class="hide-input">
            <textarea name="blacklist" id="ip-blacklist" cols="60" rows="5" class="ip-list"></textarea>
          </div>
        </p>
        <p>
          <label>
            <input type="radio" name="ipaccess" id="" value="whitelist">
          开启，允许指定 IP 地址的电脑回复您的问卷。
          </label>
          <div id="ip-w" class="hide-input">
            <textarea name="whitelist" id="ip-whitelist" cols="60" rows="5" class="ip-list"></textarea>
          </div>
        </p>
        <p>
          <label>
            <input type="radio" name="ipaccess" id="" checked="checked" value="off">
          关闭，不限制任何 IP 地址回复调查问卷。
          </label>
        </p>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-toggle="collapse" data-parent="#accordion" href="#collapse-8">
          疗程调查式回复：
        </a>
      </h4>
    </div>
    <div id="collapse-8" class="panel-collapse collapse">
      <div class="panel-body">
        <p>
          <label>
            <input type="radio" name="course" id="" value="false" checked="checked">
            不使用疗程式回复
          </label>
        </p>
        <p>
          <label>
            <input type="radio" name="course" id="" value="true">
            开启疗程式回复
          </label>
        </p>

        <blockquote id="treatment" class="hide-input">
            <p>
              周期总时间长度
              <input type="text" name="total_days" id="total_days" value="0">
              天
            </p>
            <p>
              回复频率
              <input type="text" name="frequency" id="frequency" value="0">
              天
            </p>
            <p>
              <label>
                <input type="radio" name="initial" id="" value="first" checked="checked">
              疗程记录开始时间以第一次答卷开始算起
              </label>
            </p>
            <p>
              <label>
                <input type="radio" name="initial" id="" value="custom">
                疗程记录开始时间由受访者自定
              </label>
              <div id="custom_time" class="hide-input">
                <input type="text" name="start_time" id="start_time" class="date">
              </div>
            </p>
          </blockquote>

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

<div class="alert alert-success" id="collect_up_info">
 ✅ &nbsp;  <strong>调研问卷更新发布设置成功。</strong>
</div>

@endsection