@extends('layouts.default') 
@section('title','问卷列表') 
@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            所有调查问卷
            <div class="btn-group">
                <button class="btn btn-default btn-xs dropdown" data-toggle="dropdown">
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">所有调查问卷</a></li>
                    <li><a href="#">问卷分类A</a></li>
                    <li><a href="#">问卷分类B</a></li>
                    <li>
                        <button>管理分类</button>
                    </li>
                </ul>
            </div>
            <button id="sort_arranged" class="btn btn-xs btn-default">
                <i class="fa fa-folder"></i>
            </button>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="hidden">
                        <input id="select_all_question" name="select_all_question" type="checkbox" value="ON" />
                    </th>
                    <th>标题</th>
                    <th id="sort_by_uptime">
                        <a href="#">
                                修改时间
                                <i class="fa fa-chevron-down"></i>
                                </a>
                    </th>
                    <th>回复数</th>
                    <th>设计</th>
                    <th>收集</th>
                    <th>分析</th>
                    <th>分享</th>
                    <th>其他</th>
                    <th id="sort_moveto" class="hidden" colspan="8">
                        <div class="btn-group">
                            <button class="btn btn-default btn-xs dropdown" data-toggle="dropdown">
                                移动到
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">未分类调查问卷</a></li>
                                <li><a href="#">分类B</a></li>
                                <li>
                                    <button>+ 新增分类</button>
                                </li>
                            </ul>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
            @foreach ($surveys as $survey)
                <tr>
                    <td class="hidden">
                        <input type="checkbox" value="ON" />
                    </td>
                    <td>
                        <div><a href="{{ route('surveys.show',$survey->id) }}">{{ $survey->survey }}</a></div>
                        <div class="small">建立时间：{{ $survey->created_at }}</div>
                    </td>
                    <td>{{ $survey->updated_at }}</td>
                    <td>{{ $survey->replies_sum }}</td>
                    <td>
                        <a href="{{ route('create',$survey->id) }}" data-toggle="tooltip" title="编辑调查问卷"><i class="fa fa-edit"></i></a>
                    </td>
                    <td>
                        <a href="{{ route('collect',$survey->id) }}" data-toggle="tooltip" title="发布调查问卷"><i class="fa fa-paper-plane-o"></i></a>
                    </td>
                    <td>
                        <a href="#"><i class="fa fa-bar-chart"></i></a>
                    </td>
                    <td>
                        <a href="#"><i class="fa fa-share-alt"></i></a>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">寄送副本</a></li>
                                <li><a href="#">迁移调查问卷</a></li>
                                <li><a href="#">建立范本</a></li>
                                <li><a href="#">清除回复</a></li>
                                <li>
<form action="{{ route('surveys.destroy',$survey->id) }}" method="POST">
	{{ csrf_field() }}
	{{ method_field('DELETE') }}
	<button type="submit" class="btn btu-sm btn-default">删除调查问卷</button>
</form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="panel-footer">
	        <a href="{{ route('surveys.create') }}" class="btn btn-primary">+ 建立调查问卷</a>
        </div>
        <!-- <div>所有调查问卷：第2个，共2个</div> -->
    </div>
        {!! $surveys->render() !!}
</div>
@endsection