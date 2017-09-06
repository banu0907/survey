@extends('questions.create')
@section('question_edit')

<label for="switchToSRRS">
    设为单列评分表（无列选项）。
    <i class="fa fa-question-circle pull-right"></i>
    <div class="webui-popover-content">
        提示内容
        <br>提示内容
    </div>
</label>
<input type="checkbox" name="switchToSRRS" id="switchToSRRS" value="1" class="pull-left closeSonOpt">
<div id="rowsWrap" class="sonBox">
    <table class="table table-hover" id="rows">
        <thead>
            <tr>
                <th colspan="2">
                    行
                    <div class="pull-right">
                        <button type="button" class="btn btn-default">批量增加新答案</button>
                        <i class="fa fa-question-circle pull-right"></i>
                        <div class="webui-popover-content">
                            提示内容
                            <br>提示内容
                        </div>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class="choice">
                <td class="choiceText">
                    <div class="input" contenteditable="true"></div>
                </td>
                <td class="choiceActions">
                    <a class="add" href="#"> <i class="fa fa-plus-circle"></i> </a>
                    <a class="delete" href="#"> <i class="fa fa-times-circle"></i> </a>
                </td>
            </tr>
            <tr class="choice">
                <td class="choiceText">
                    <div class="input" contenteditable="true"></div>
                </td>
                <td class="choiceActions">
                    <a class="add" href="#"> <i class="fa fa-plus-circle"></i> </a>
                    <a class="delete" href="#"> <i class="fa fa-times-circle"></i> </a>
                </td>
            </tr>
            <tr class="choice">
                <td class="choiceText">
                    <div class="input" contenteditable="true"></div>
                </td>
                <td class="choiceActions">
                    <a class="add" href="#"> <i class="fa fa-plus-circle"></i> </a>
                    <a class="delete" href="#"> <i class="fa fa-times-circle"></i> </a>
                </td>
            </tr>
        </tbody>
    </table>
    <div>
        <label>
            <input type="checkbox" name="toggleMultipleChoice" id="toggleMultipleChoice" value="1">允许每行多个回复（多选）</label>
    </div>
</div>
<div id="columnsWrap">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>栏</th>
                <th class="weightValue">权重</th>
                <th class="choiceActions"></th>
            </tr>
        </thead>
        <tbody>
            <tr class="column">
                <td class="choiceText">
                    <div class="input" contenteditable="true"></div>
                </td>
                <td class="weightValue">
                    <input type="text" name="" id="" size="3" value="1">
                </td>
                <td class="choiceActions">
                    <a class="add" href="#"> <i class="fa fa-plus-circle"></i> </a>
                    <a class="delete" href="#"> <i class="fa fa-times-circle"></i> </a>
                </td>
            </tr>
            <tr class="column">
                <td class="choiceText">
                    <div class="input" contenteditable="true"></div>
                </td>
                <td class="weightValue">
                    <input type="text" name="" id="" size="3" value="2">
                </td>
                <td class="choiceActions">
                    <a class="add" href="#"> <i class="fa fa-plus-circle"></i> </a>
                    <a class="delete" href="#"> <i class="fa fa-times-circle"></i> </a>
                </td>
            </tr>
            <tr class="column">
                <td class="choiceText">
                    <div class="input" contenteditable="true"></div>
                </td>
                <td class="weightValue">
                    <input type="text" name="" id="" size="3" value="3">
                </td>
                <td class="choiceActions">
                    <a class="add" href="#"> <i class="fa fa-plus-circle"></i> </a>
                    <a class="delete" href="#"> <i class="fa fa-times-circle"></i> </a>
                </td>
            </tr>
            <tr class="column">
                <td class="choiceText">
                    <div class="input" contenteditable="true"></div>
                </td>
                <td class="weightValue">
                    <input type="text" name="" id="" size="3" value="4">
                </td>
                <td class="choiceActions">
                    <a class="add" href="#"> <i class="fa fa-plus-circle"></i> </a>
                    <a class="delete" href="#"> <i class="fa fa-times-circle"></i> </a>
                </td>
            </tr>
            <tr class="column">
                <td class="choiceText">
                    <div class="input" contenteditable="true"></div>
                </td>
                <td class="weightValue">
                    <input type="text" name="" id="" size="3" value="5">
                </td>
                <td class="choiceActions">
                    <a class="add" href="#"> <i class="fa fa-plus-circle"></i> </a>
                    <a class="delete" href="#"> <i class="fa fa-times-circle"></i> </a>
                </td>
            </tr>
            <tr>
                <td>
                	<div id="editNALabel" class="input hide" contenteditable="true">不适用</div>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="row">
        <div class="col-xs-4">
            <label>
                <input type="checkbox" name="editWeighted" id="editWeighted" value="1" checked="checked"> 使用权重
            </label>
            <i class="fa fa-question-circle"></i>
            <div class="webui-popover-content">
                提示内容
                <br>提示内容
            </div>
        </div>
        <div class="col-xs-4">
            <label>
                <input type="checkbox" name="editNA" id="editNA" value="1"> 新增 「N/A」不适用栏
            </label>
            <i class="fa fa-question-circle"></i>
            <div class="webui-popover-content">
                提示内容
                <br>提示内容
            </div>
        </div>
        <div class="col-xs-4">
            <label>
                <input type="checkbox" name="editForcedRanking" id="editForcedRanking" value="1"> 强制排名
            </label>
            <i class="fa fa-question-circle"></i>
            <div class="webui-popover-content">
                提示内容
                <br>提示内容
            </div>
        </div>
    </div>
    <hr>
    <div>
        <label for="toggleOtherField">
            增加「其他」备注项
            <i class="fa fa-question-circle pull-right"></i>
            <div class="webui-popover-content">
                提示内容
                <br>提示内容
            </div>
        </label>
        <input type="checkbox" name="toggleOtherField" id="toggleOtherField" value="1" class="pull-left openSonOpt">
        <div class="sonOpt">
            <h6>标签</h6>
            <div class="input" id="otherLabel" contenteditable="true">备注</div>
            <h6>列</h6>
            <div>
                <label for="otherAmountPerQ">
                    <input type="radio" name="otherAmount" id="otherAmountPerQ" value="per_question"> 整个问题使用一个备注
                </label>
                <label for="otherAmountPerRow">
                    <input type="radio" name="otherAmount" id="otherAmountPerRow" value="per_row"> 每行一个备注
                </label>
            </div>
        </div>
    </div>
</div>

@endsection