<div class="question-row clearfix" id="{{ $question['id'] }}" data-question-class="{{ $question['question_type'] }}">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#question-Edit" data-toggle="tab">编辑</a></li>
        <li><a href="#question-Options" data-toggle="tab">选项</a></li>
        <li><a href="#question-Logic" data-toggle="tab">逻辑</a></li>
        <li><a href="#question-Move" data-toggle="tab">移动</a></li>
        <li><a href="#question-Copy" data-toggle="tab">复制</a></li>
    </ul>
    <section class="question_warnings">

    </section>
    <div class="tab-content">
        <!-- ******* 编辑 ********* -->
        <section class="active tab-pane" id="question-Edit">
            <div class="row">
                <div class="col-xs-6" id="change-type">
                    <a id="que_type_change_btn" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        {{ $toolname }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#">单选&sol;多选
                                <i class="fa fa-question-circle pull-right"></i>
                                <div class="webui-popover-content">
                                    提示内容<br>提示内容
                                </div>
                            </a></li>
                        <li><a href="#">下拉式
                                <i class="fa fa-question-circle pull-right"></i>
                                <div class="webui-popover-content">
                                    提示内容<br>提示内容
                                </div>
                            </a></li>
                        <li><a href="#">星级评分
                                <i class="fa fa-question-circle pull-right"></i>
                                <div class="webui-popover-content">
                                    提示内容<br>提示内容
                                </div>
                            </a></li>
                        <li><a href="#">矩阵评分表
                                <i class="fa fa-question-circle pull-right"></i>
                                <div class="webui-popover-content">
                                    提示内容<br>提示内容
                                </div>
                            </a></li>
                        <li><a href="#">下拉式功能表矩阵
                                <i class="fa fa-question-circle pull-right"></i>
                                <div class="webui-popover-content">
                                    提示内容<br>提示内容
                                </div>
                            </a></li>
                        <li><a href="#">排名
                                <i class="fa fa-question-circle pull-right"></i>
                                <div class="webui-popover-content">
                                    提示内容<br>提示内容
                                </div>
                            </a></li>
                        <li><a href="#">滑杆
                                <i class="fa fa-question-circle pull-right"></i>
                                <div class="webui-popover-content">
                                    提示内容<br>提示内容
                                </div>
                            </a></li>
                        <li><a href="#">单一文字框
                                <i class="fa fa-question-circle pull-right"></i>
                                <div class="webui-popover-content">
                                    提示内容<br>提示内容
                                </div>
                            </a></li>
                        <li><a href="#">多重文字框
                                <i class="fa fa-question-circle pull-right"></i>
                                <div class="webui-popover-content">
                                    提示内容<br>提示内容
                                </div>
                            </a></li>
                        <li><a href="#">备注方框
                                <i class="fa fa-question-circle pull-right"></i>
                                <div class="webui-popover-content">
                                    提示内容<br>提示内容
                                </div>
                            </a></li>
                        <li><a href="#">日期&sol;时间
                                <i class="fa fa-question-circle pull-right"></i>
                                <div class="webui-popover-content">
                                    提示内容<br>提示内容
                                </div>
                            </a></li>
                    </ul>
                    <i class="fa fa-question-circle"></i>
                    <div class="webui-popover-content">
                        转换问题类型<br>提示内容
                    </div>


                </div>
                <div class="col-xs-6 text-right">
                    <input type="checkbox" name="show_suggested_que" value="ON" checked="checked" /> 显示建议的问题
                    <i class="fa fa-question-circle"></i>
                    <div class="webui-popover-content">
                        转换问题类型<br>提示内容
                    </div>
                </div>
            </div>


            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h5 class="panel-title">
                        <span class="question-number"></span>问题：
                        <div id="editTitle" class="input" contenteditable="true"> </div>
                    </h5>
                </div>
                <div class="panel-body">
                    @yield('question_edit')
                </div>
            </div>

            <i class="fa fa-question-circle"></i>

            <div class="buttons">
                <button class="btn btn-primary add-another">
                <i class="fa fa-plus-circle"></i>
                    下一个问题
                </button>
                <div class="pull-right">
                    <button class="btn btn-primary save">保存</button>
                    <button class="btn btn-default cancel">取消</button>
                </div>
            </div>

        </section>
        <!-- ******* 选项 ********* -->
        <section class="tab-pane" id="question-Options">

            <ul class="list-group">
                <li class="list-group-item">
                        <i class="fa fa-question-circle pull-right"></i>
                    <label for="toggleReq">
                         &nbsp; 问题需要有答案
                    </label>
                        <input type="checkbox" name="toggleReq" id="toggleReq" checked="checked" class="pull-left">
                    <div class="form-group">
                    <label for="editReqtext">没有回答时，显示的错误信息</label>
                        <input type="text" name="editReqtext" id="editReqtext" class="form-control" value="这个问题是必答题。">
                    </div>
                </li>
                
                <li class="list-group-item">
                    <i class="fa fa-question-circle pull-right"></i>
                    <label for="editRand">
                        &nbsp; 选项随机排列、排序
                    </label>
                        <input type="checkbox" name="editRand" id="editRand" class="pull-left">
                    <div class="row">
                        <div class="col-md-offset-1 col-md-10">
                            <div>
                                <input type="radio" name="sortRadio" id="randomizeRadio" value="random">
                                <label for="randomizeRadio">为每个受访者随机显示选项</label>
                            </div>
                            <div>
                                <input type="radio" name="sortRadio" id="sortRadio" value="textasc">
                                <label for="sortRadio">按字母顺序排序选项</label>
                            </div>
                            <div>
                                <input type="radio" name="sortRadio" id="flipRadio" value="flip">
                                <label for="flipRadio">为每个受访者调换选项</label>
                            </div>
                            <div>
                                <input type="checkbox" name="editLast" id="editLast" value="on">
                                <label for="editLast">请勿随意排列最后一个选项</label>
                            </div>    
                        </div>
                    </div>
                </li>

            </ul>

            <div class="buttons">
                <button class="btn btn-primary add-another">
                    <span class="glyphicon glyphicon-plus-sign"></span>
                    下一个问题
                </button>
                <div class="pull-right">
                    <button class="btn btn-primary save">保存</button>
                    <button class="btn btn-default cancel">取消</button>
                </div>
            </div>
        </section>
        <!-- ******* 逻辑 ********* -->
        <section class="tab-pane" id="question-Logic">
            逻辑区 {edit_logic}

            <div class="panel panel-default">
                <div class="panel-body">

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="answerValue">如果答案是...</th>
                                <th class="skipTo">跳转到...</th>
                                <th class="clearAllLogic">全部清除</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="logicRow">
                                <td>
                                    选项
                                </td>
                                <td>
                                    <select name="selectPage" class="selectPage">
                                        <option value="">- 选择页面 -</option>
                                    </select>
                                    <select name="selectQuestion" class="selectQuestion">
                                        <option value="0">页首</option>
                                    </select>
                                </td>
                                <td>
                                    <a class="clearLogic ">清除</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>


            <div class="buttons">
                <button class="btn btn-primary add-another">
                    <span class="glyphicon glyphicon-plus-sign"></span>
                    下一个问题
                </button>
                <div class="pull-right">
                    <button class="btn btn-primary save">保存</button>
                    <button class="btn btn-default cancel">取消</button>
                </div>
            </div>
        </section>
        <!-- ******* 移动 ********* -->
        <section class="tab-pane" id="question-Move">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h5 class="panel-title">移动问题到</h5>
                </div>
                <div class="panel-body">
                    页面
                    <select name="movePage" id="movePage">
                        <!--<option value=""></option>-->
                    </select> 问题
                    <select name="moveTarget" id="moveTarget">
                        <!--<option value=""></option>-->
                    </select> 位置
                    <select name="movePos" id="movePos">
                        <option value="after">之后</option>
                        <option value="bdfare">之前</option>
                    </select>

                </div>
            </div>
            <div class="buttons">
                <button type="button" class="btn btn-primary move">确定</button>
                <button type="button" class="btn btn-default cancel">取消</button>
            </div>

        </section>
        <!-- ******* 复制 ********* -->
        <section class="tab-pane" id="question-Copy">

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h5 class="panel-title">复制这个问题到：</h5>
                </div>
                <div class="panel-body">
                    页面
                    <select name="copyPage" id="copyPage">
                        <option value=""></option>
                    </select> 问题
                    <select name="copyTarget" id="copyTarget">
                            <option value=""></option>
                        </select> 位置
                    <select name="copyPos" id="copyPos">
                        <option value="after">之后</option>
                        <option value="bdfare">之前</option>
                    </select>
                </div>
            </div>

            <div class="buttons">
                <button type="button" class="btn btn-primary copy">确定</button>
                <button type="button" class="btn btn-default cancel">取消</button>
            </div>
        </section>
    </div>


</div>