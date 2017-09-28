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
      <a href="{{ route('r',$survey) }}" class="popwindow">
  		<i class="fa fa-link">&nbsp;</i>
      </a>
      {{ route('r',$survey) }}
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
            <input type="radio" name="allow_multiple_responses" value="true"{!! $survey->multiple_responses == "true" ? " checked=\"checked\"" : "" !!}>
         开启，允许多次。
         </label>
       </p>
        <p>
          <label>
            <input type="radio" name="allow_multiple_responses" value="false"{!! $survey->multiple_responses != "true" ? " checked=\"checked\"" : "" !!}>
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
            <input type="radio" name="edit-responses" value="until_complete"{!! $survey->edit_responses == "until_complete" ? " checked=\"checked\"" : "" !!}>
            开启，受访者可以任何调查问卷页面中变更答案，直到完成调查问卷
          </label>
        </p>
        <p>
          <label>
            <input type="radio" name="edit-responses" value="always"{!! $survey->edit_responses == "always" ? " checked=\"checked\"" : "" !!}>
          开启，受访者可以完成调查问卷之后变更答案。
        </label>
      </p>
        <p>
          <label>
            <input type="radio" name="edit-responses" value="never"{!! $survey->edit_responses == "never" ? " checked=\"checked\"" : "" !!}>
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
            <input type="radio" name="make-anonymous" value="fully_anonymous"{!! $survey->make_anonymous == "fully_anonymous" ? " checked=\"checked\"" : "" !!}>
          开启，你的受访者均为匿名
        </label>
      </p>
        <p>
          <label>
            <input type="radio" name="make-anonymous" value="not_anonymous"{!! $survey->make_anonymous != "fully_anonymous" ? " checked=\"checked\"" : "" !!}>
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
            <input type="radio" name="instant-results" value="true"{!! $survey->instant_results == "true" ? " checked=\"checked\"" : "" !!}>
          开启，向受访者显示结果。
         </label>
        </p>
        <p>
          <label>
            <input type="radio" name="instant-results" value="false"{!! $survey->instant_results != "true" ? " checked=\"checked\"" : "" !!}>
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
            <input type="radio" name="cutoff-date" value="true"{!! $survey->end_time ? " checked=\"checked\"" : "" !!}>
          开启，在指定日期与时间关闭。
          </label>
          <div id="cutoff-input"{!! $survey->end_time ? "" : " class=\"hide-input\"" !!}>
            <input type="text" name="cutoff_datepicker" id="cutoff_datepicker" class="date" value="{{ $survey->end_time }}">
          </div>
        </p>
        <p>
          <label>
            <input type="radio" name="cutoff-date" value="false"{!! empty($survey->end_time) ? " checked=\"checked\"" : "" !!}>
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
            <input type="radio" name="max-responses" value="true"{!! $survey->max_responses ? " checked=\"checked\"" : "" !!}>
            开启，在收集到指定的回复数量之后关闭。
          </label>
          <div id="max-responses-input"{!! $survey->max_responses ? "" : " class=\"hide-input\"" !!}>
            输入最大回复数字
            <input type="text" name="max-response-count" id="max-response-count" value="{{ $survey->max_responses }}">
          </div>
        </p>
        <p>
          <label>
            <input type="radio" name="max-responses" value="false"{!! empty($survey->max_responses) ? " checked=\"checked\"" : "" !!}>
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
            <input type="radio" name="ipaccess" value="blacklist"{!! $survey->ipaccess == "blacklist" ? " checked=\"checked\"" : "" !!}>
            开启，封锁指定 IP 地址的电脑，使其无法回复你的调查问卷
          </label>
          <div id="ip-b"{!! $survey->ipaccess == "blacklist" ? "" : " class=\"hide-input\"" !!}>
            <textarea name="blacklist" id="ip-blacklist" cols="60" rows="5" class="ip-list">{{ $survey->ip_list }}</textarea>
          </div>
        </p>
        <p>
          <label>
            <input type="radio" name="ipaccess" value="whitelist"{!! $survey->ipaccess == "whitelist" ? " checked=\"checked\"" : "" !!}>
          开启，允许指定 IP 地址的电脑回复您的问卷。
          </label>
          <div id="ip-w"{!! $survey->ipaccess == "whitelist" ? "" : " class=\"hide-input\"" !!}>
            <textarea name="whitelist" id="ip-whitelist" cols="60" rows="5" class="ip-list">{{ $survey->ip_list }}</textarea>
          </div>
        </p>
        <p>
          <label>
            <input type="radio" name="ipaccess" value="off"{!! $survey->ipaccess == "off" ? " checked=\"checked\"" : "" !!}>
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
            <input type="radio" name="course" value="false"{!! $survey->course_days ? "" : " checked=\"checked\"" !!}>
            不使用疗程式回复
          </label>
        </p>
        <p>
          <label>
            <input type="radio" name="course" value="true"{!! $survey->course_days ? " checked=\"checked\"" : "" !!}>
            开启疗程式回复
          </label>
        </p>

        <blockquote id="treatment"{!! $survey->course_days ? "" : " class=\"hide-input\"" !!}>
            <p>
              周期总时间长度
              <input type="text" name="total_days" id="total_days" value="{{ $survey->course_days }}">
              天
            </p>
            <p>
              回复频率
              <input type="text" name="frequency" id="frequency" value="{{ $survey->course_frequency }}">
              天
            </p>
            <p>
              <label>
                <input type="radio" name="initial" value="first"{!! $survey->course_start_time ? "" : " checked=\"checked\"" !!}>
              疗程记录开始时间以第一次答卷开始算起
              </label>
            </p>
            <p>
              <label>
                <input type="radio" name="initial" value="custom"{!! $survey->course_start_time ? " checked=\"checked\"" : "" !!}>
                疗程记录开始时间由受访者自定
              </label>
              <div id="custom_time"{!! $survey->course_start_time ? "" : " class=\"hide-input\"" !!}>
                <input type="text" name="start_time" id="start_time" class="date" value="{{ $survey->course_start_time }}">
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