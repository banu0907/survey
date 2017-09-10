@extends('layouts.default')
@section('title','问卷设计')
@section('head_file')
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <link type="text/css" rel="stylesheet" href="{{ url('/') }}/css/jquery.webui-popover.min.css">
    <link type="text/css" rel="stylesheet" href="{{ url('/') }}/css/survey_create.css">
    <script type="text/javascript">
    	var app_url = "{{ url('/') }}";
        var survey_id = {{ $survey->id }};
    </script>
    <script type="text/javascript" src="{{ url('/') }}/js/jquery.webui-popover.min.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/js/survey_create.js"></script>
@endsection
@section('content')

    <div class="container">
        <div class="survey_title row">
            <h2>{{ $survey->survey }}</h2>
        </div>
        <div class="row">
            <ul class="nav nav-tabs">
                <li><a href="survey_summary.html">摘要</a></li>
                <li class="active"><a href="#">设计调查问卷</a></li>
                <li><a href="survey_collect.html">收集回复</a></li>
                <li><a href="survey_analyze.html">分析结果</a></li>
            </ul>
        </div>
    </div>
    <div id="head_toolbar">
        <div class="container">
            <div class="row">
                <div class="survey_title col-xs-6">
                    <h2>问卷总标题</h2>
                </div>
                <div class="col-xs-6">
                    <div class="well-sm text-right">
                        <button id="previewButton" class="btn btn-default btn-sm">
                        <i class="fa fa-external-link"></i>
                            预览和测试
                        </button>
                        <button id="printSurvey" class="btn btn-default btn-sm">
                        <i class="fa fa-print"></i>
                            打印
                        </button>
                        <button id="sendSurvey" class="btn btn-primary btn-sm">
                            下一页
                            <i class="fa fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div id="survey_create_body" class="row">
            <div class="col-xs-3">
                <!-- ************  设计工具区 ****************  -->
				@include('survey_design.toolbar', ['some' => 'data'])
            </div>
            <!-- ***************       主工作区     **************** -->
            <div id="survey_workspace" class="col-xs-9">
            @foreach ($subpages as $surveypage)
				 @include('survey_design.page')
            @endforeach
            </div>
        </div>
    </div>


    <!-- #######################################  end  ##################################### -->
    <!-- 🎈 拖放工具鼠标提示框内容  -->
    <div id="q_drag_icon">
        <span class="glyphicon glyphicon-file"></span> 拖放工具信息
    </div>
    <!-- 🎠 Ajax状态提示 -->
    <div id="action-status-info">
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="fa fa-spinner fa-pulse fa-2x"></i>
            <span id="action-status">Ajax状态信息 ...</span>
        </div>
    </div>
    <!-- 🎃 页面逻辑面板  -->
    <div id="pageLogicContainer">
        <div role="tabpanel">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#pageSkipPanel" aria-controls="pageSkipPanel" role="tab" data-toggle="tab">跳页逻辑</a>
                </li>
                <li role="presentation">
                    <a href="#questionRandomPanel" aria-controls="questionRandomPanel" role="tab" data-toggle="tab">问题随机出现</a>
                </li>
                <li role="presentation">
                    <a href="#pageRandomPanel" aria-controls="pageRandomPanel" role="tab" data-toggle="tab">页面随机出现</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="pageSkipPanel">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h6 class="panel-title">完成目前页面后，直接跳到此页面...
                                <i class="fa fa-question-circle"></i>
                                <div class="webui-popover-content">
                                    提示内容<br>提示内容
                                </div>
                            </h6>
                        </div>
                        <div class="panel-body">
                            <select name="pageSkipTarget" id="pageSkipTarget">
                                <option value="description">选择页面</option>
                                <!--<option value="2">第2页</option>-->
                                <option value="-3">调查问卷结尾</option>
                                <option value="-1">取消受访者资格</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="questionRandomPanel">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h6 class="panel-title">将此页面问题设置为随机出现...
                                <i class="fa fa-question-circle"></i>
                                <div class="webui-popover-content">提示内容</div>
                            </h6>
                        </div>
                        <div class="panel-body">
                            <strong>格式：</strong>
                            <label>
                                <input type="radio" name="questionRandom" value="none" checked="checked"> 不随机</label>
                            <label>
                                <input type="radio" name="questionRandom" value="random"> 随机出现问题</label>
                            <label>
                                <input type="radio" name="questionRandom" value="flip"> 调换问题</label>


<div class="panel panel-default" id="questionsAffectedControls">
    <div class="panel-heading">
            <strong>受影响的问题：</strong>
    </div>
    <div class="panel-body">
        <label>
            <input type="radio" name="questionsAffected" id="questionsAffectedAll" value="all">
            第<span class="notranslate"></span>页上的所有问题
        </label>
        <label>
            <input type="radio" name="questionsAffected" id="questionsAffectedList" value="questionList">
            选取的问题
        </label>
        <blockquote id="questionRandomList">
            <label>
                <input type="checkbox" name="randomizeQuestion" id="randomizeQuestion_" value="">
            </label>
        </blockquote>
    </div>

</div>


                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="pageRandomPanel">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h6 class="panel-title">将此页面设置为随机出现
                                <i class="fa fa-question-circle"></i>
                                <div class="webui-popover-content">提示内容<br>提示内容 </div>
                            </h6>
                        </div>
                        <div class="panel-body">
                            <strong>格式：</strong>
                            <label>
                                <input type="radio" name="pageRandom" value="none" checked="checked"> 不随机</label>
                            <label>
                                <input type="radio" name="pageRandom" value="random"> 页面随机出现</label>
                            <label>
                                <input type="radio" name="pageRandom" value="flip"> 替换页面</label>
                            <label>
                                <input type="radio" name="pageRandom" value="rotate"> 轮换页面</label>

<div class="panel panel-default" id="pagesAffectedControls">
    <div class="panel-heading">
        <strong class="panel-title">受影响的页面：</strong>
    </div>
    <div class="panel-body">
        <label><input type="radio" name="pagesAffected" id="pagesAffectedAll" value="all">此调查问卷中的所有页面</label>
        <label><input type="radio" name="pagesAffected" id="pagesAffectedList" value="pageList">选取的页面</label>

        <blockquote id="pageRandomList">
            <label><input type="checkbox" name="randomizePage" id="pageRandomOption-" value=""></label>
        </blockquote>
    </div>
</div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="plc-btn">
            <button type="button" class="btn btn-primary" id="plc-btn-apply">应用</button>
            <button type="button" class="btn btn-default" id="plc-btn-cancel">取消</button>
        </div>
    </div>
    <!-- 页面其他操作面板 -->
    <div id="pageActionContainer">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h6 class="panel-title">
                    <span class="copyPage">复制</span>
                    <span class="movePage">移动</span>
                    <span class="deletePage">删除</span>
                    <strong>第<span id="pagePosition"></span>页</strong>
                </h6>
            </div>
            <div class="panel-body">
                <div class="copyPage">
                    复制到
                    <select name="pageAction_pageList" id="pageAction_pageList">
                        <option value="1">第1页</option>
                        <option value="2">第2页</option>
                    </select>
                    <select name="pageAction_relativePos" id="pageAction_relativePos">
                        <option value="after">之后</option>
                        <option value="before">之前</option>
                    </select>
                </div>
                <div class="movePage">
                    移动到
                    <select name="pageAction_pageList" id="pageAction_pageList">
                        <option value="1">第1页</option>
                        <option value="2">第2页</option>
                    </select>
                    <select name="pageAction_relativePos" id="pageAction_relativePos">
                        <option value="after">之后</option>
                        <option value="before">之前</option>
                    </select>
                </div>
                <div class="deletePage">
                    <label>
                        <input type="radio" name="deletePageQuestions" value="delete" checked="checked">同时删除页面上的问题</label>
                    <label>
                        <input type="radio" name="deletePageQuestions" value="before">将问题移到上方页面</label>
                    <label>
                        <input type="radio" name="deletePageQuestions" value="after">将问题移到下方页面</label>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-primary" id="pac-btn-apply">应用</button>
        <button type="button" class="btn btn-default" id="pac-btn-cancel">取消</button>
    </div>
    <!-- 编辑调查问卷标题 -->
    <div class="modal fade" id="modal-survey-title">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">调查问卷标题</h4>
                </div>
                <div class="modal-body">
                    <div>
                        调查问卷标题
                        <i class="fa fa-question-circle"></i>
                        <div class="webui-popover-content">调查问卷标题提示内容</div>
                        <input type="text" name="surveyTitle" id="surveyTitle" required>
                    </div>
                    <div>
                        对齐
                        <i class="fa fa-question-circle"></i>
                        <div class="webui-popover-content">对齐提示内容</div>
                        <select name="surveyTitleAlignment" id="surveyTitleAlignment">
                            <option value="left">靠左对齐</option>
                            <option value="center">居中对齐</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="save-survey-title">保存</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 编辑页面标题和页面说明 -->
    <div class="modal fade" id="modal-page-title">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">页面标题</h4>
                </div>
                <div class="modal-body">
                    <div>
                        页面标题
                        <input type="text" name="pageTitle" id="pageTitle">
                    </div>
                    <div>
                        页面说明
                        <div id="pageSubtitle" class="input" contenteditable="true"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="save-page-title">保存</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>

    <!--新增标志：图像文件上传对话框-->
    <div class="modal fade" id="modal-addImageDialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">上传标志图像</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="save-top-logo">保存</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 预览与测试窗口 -->
    <div id="preview_window">
        <div class="nav-header">
            <i class="fa fa-eye"></i>
             预览与测试 
            <i class="fa fa-close pull-right"></i>
        </div>
        <div id="survey_preview">
            <iframe name="survey_preview"></iframe>
        </div>
        <nav class="nav-footer">
            <ul class="device-sizes nav nav-pills">
                <li class="active"><a href="#" class="desktop"> <i class="fa fa-laptop fa-2x"></i> 桌面</a></li>
                <li><a href="#" class="tablet"> <i class="fa fa-tablet fa-2x"></i> 平板电脑</a></li>
                <li><a href="#" class="phone"> <i class="fa fa-mobile fa-2x"></i> 手机</a></li>
            </ul>
        </nav>
    </div>
@endsection