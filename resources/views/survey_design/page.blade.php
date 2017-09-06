
<!-- ############# 📑 第{{ $surveypage->page_num }}页 ############### -->
<section class="survey-page" id="pageid-{{ $surveypage->id }}">
    <div class="pageControls row">
        <div class="pageNumber col-xs-2">
            第<span class="pagePosition">{{ $surveypage->page_num }}</span>页
        </div>
        <div class="col-xs-5">
            <div class="btn-group menu-logic">
                <button class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown">
                    页面逻辑
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="pull-left">跳页逻辑</a>
                        <i class="fa fa-question-circle pull-right"></i>
                        <div class="webui-popover-content">
                            提示内容
                            <br>提示内容
                        </div>
                    </li>
                    <li>
                        <a class="pull-left">问题随机出现</a>
                        <i class="fa fa-question-circle pull-right"></i>
                        <div class="webui-popover-content">
                            提示内容
                            <br>提示内容
                        </div>
                    </li>
                    <li>
                        <a class="pull-left">页面随机出现</a>
                        <i class="fa fa-question-circle pull-right"></i>
                        <div class="webui-popover-content">
                            提示内容
                            <br>提示内容
                        </div>
                    </li>
                </ul>
            </div>
            <div class="btn-group menu-more_actions">
                <button class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown">
                    其他操作
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li class="copy_page">
                        <a class="pull-left">复制页面</a>
                        <i class="fa fa-question-circle pull-right"></i>
                        <div class="webui-popover-content">
                            提示内容
                            <br>提示内容
                        </div>
                    </li>
                    <li class="move_page">
                        <a class="pull-left">移动页面</a>
                        <i class="fa fa-question-circle pull-right"></i>
                        <div class="webui-popover-content">
                            提示内容
                            <br>提示内容
                        </div>
                    </li>
                    <li class="edit_page">
                        <a class="pull-left">编辑页面资讯</a>
                        <i class="fa fa-question-circle pull-right"></i>
                        <div class="webui-popover-content">
                            提示内容
                            <br>提示内容
                        </div>
                    </li>
                    <li class="require_qs">
                        <a class="pull-left">需编辑问题</a>
                        <i class="fa fa-question-circle pull-right"></i>
                        <div class="webui-popover-content">
                            提示内容
                            <br>提示内容
                        </div>
                    </li>
                    <li class="delete_page">
                        <a class="pull-left">删除页面</a>
                        <i class="fa fa-question-circle pull-right"></i>
                        <div class="webui-popover-content">
                            提示内容
                            <br>提示内容
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-xs-5 text-right pageNavigation">
            <div class="btn-group menu-selectPage">
                <button class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown">
                    P<span class="pagePosition"></span>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu page-list-menu">
                </ul>
            </div>
            <div class="btn-group">
                <button class="btn btn-default btn-sm menu-previous">
                    <i class="fa fa-chevron-left"></i>
                </button>
                <button class="btn btn-default btn-sm menu-next">
                    <i class="fa fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="survey-page-head">
                <button type="button" class="btn btn-primary pull-right">编辑</button>
                <h1{!! $survey->survey_alignment=="center"  ? " class=\"text-center\"" : "" !!}>
                {{ $survey->survey }}
                </h1>
            </div>
            <h2>
                <span>{{ $surveypage->page_title or '+ 新增页面标题' }}</span>
                <button type="button" class="btn btn-primary pull-right">编辑</button>
            </h2>
            <h3>
                <span>{!! $surveypage->page_description !!}</span>
                <button type="button" class="btn btn-primary pull-right">编辑</button>
            </h3>
        </div>
        <div class="panel-body">
            <div class="form-horizontal">
                <div class="survey-page-body">
                    <!--   页内问题区域   -->
                    @foreach ($surveypage->questions as $question)
                        @include('survey_design.question_show')
                    @endforeach
                </div>
                <div class="question-body-new clearfix">
                    <div class="btn-group">
                        <button class="btn btn-primary">
                            <i class="fa fa-plus-circle"></i> 新增问题
                        </button>
                        <a class="btn btn-primary addnew_question_box" rel="popower">
                            <span class="caret"></span>
                        </a>
                    </div>
                    <p>或<a>复制并粘贴上您的问题</a></p>
                </div>
                <div class="survey-page-submit">
                    <button class="btn btn-lg prev-button">上一页</button>
                    <button class="btn btn-lg done-button">完成</button>
                    <button class="btn btn-lg next-button">下一页</button>
                    <a class="btn btn-primary">编辑</a>
                </div>
            </div>
            <div class="survey-footer text-center">
                <hr> 917apple LOGO
                <p>
                    <small>技术提供<br>
                        制作调查问卷轻松简单</small>
                </p>
                <button type="button" class="btn btn-default">隐藏脚注</button>
            </div>
        </div>
    </div>
    <div class="survey-page-new text-primary">
        <i class="fa fa-file"></i>
         + 新页面
    </div>
</section>
