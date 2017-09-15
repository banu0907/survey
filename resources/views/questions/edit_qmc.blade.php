@extends('questions.edit')

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

                        @foreach ($clauses as $clause)
                            <tr>
                                <td>
                                    <input type="{{ in_array("mcp", $addopts) ? "checkbox" : "radio" }}" disabled="disabled">
                                </td>
                                <td>
                                    <div class="input" contenteditable="true">{{ $clause }}</div>
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
                        @endforeach

                        </tbody>
                    </table>
			<label>
					<input type="checkbox" name="mcq" id="mcq" {{ in_array("mcp", $addopts) ? "checked=\"checked\"" : "" }} >
                    允许此问题具有多个答案（多选）
			</label>
@endsection