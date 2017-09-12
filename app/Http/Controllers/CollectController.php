<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;

class CollectController extends Controller
{
    // 发布问卷动作，先发布后设置
	public function index(Survey $survey)
	{
		// 检查问卷为空时返回设计页
		 if ($survey->questions()->count()<1) {
			session()->flash("warning","您的问卷还没有设计任何问题，无法发布。");
		 	return redirect()->route("create",[$survey]);
		 }
		// 问卷最后修改时间
	    $survey_updated = $survey->questions()->orderBy("updated_at","DESC")->first()->updated_at;
		// 问卷最后发布时间
		$survey_pubdated = "2017-01-01 12:00:00";
		if( $survey_pubdated > $survey_updated ){
		 echo "已发布" ;
		} else {
		 echo "未发布" ;
		 // 进入发布程序
		 
			session()->flash("success","关于问卷生成的信息提示。");
		};
		return redirect()->route("collect.edit",[$survey]);
	}

/**
 * 问卷发布选项
 * @param  Survey $survey [description]
 * @return [type]         [description]
 */
	public function edit(Survey $survey)
	{
		
		return view("collect.edit",compact('survey'));
	}
}
