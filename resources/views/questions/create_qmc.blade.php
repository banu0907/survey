@extends('questions.create')

@section('question_edit')
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th colspan="3">
                                    答案选择
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
                            <tr>
                                <td>
                                    <input type="radio" name="" id="" disabled="disabled">
                                </td>
                                <td>
                                    <div class="input" contenteditable="true">
                                        选项一
                                    </div>
                                </td>
                                <td>
                                    <a class="add" href="#">
                                    <i class="fa fa-plus-circle"></i>
                                    </a>
                                    <a class="delete" href="#">
                                    <i class="fa fa-times-circle"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="" id="" disabled="disabled">
                                </td>
                                <td>
                                    <div class="input" contenteditable="true">
                                        选项二
                                    </div>
                                </td>
                                <td>
                                    <a class="add" href="#">
                                        <i class="fa fa-plus-circle"></i>
                                    </a>
                                    <a class="delete" href="#">
                                    <i class="fa fa-times-circle"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
			<label>
					<input type="checkbox" name="mcq" id="mcq">
                    允许此问题具有多个答案（多选）
			</label>
@endsection