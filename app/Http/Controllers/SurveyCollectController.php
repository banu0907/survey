<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;

class SurveyCollectController extends Controller
{
    // 发布问卷动作，先发布后设置
	public function index(Survey $survey)
	{
		// 检查问卷为空时返回设计页
		 if ($survey->questions()->count()<1) {
			session()->flash("warning","⚠️ &nbsp; 您的问卷还没有设计任何问题，无法发布。");
		 	return redirect()->route("create",[$survey]);
		 }
		// 问卷最后修改时间
	    $survey_updated = $survey->questions()->orderBy("updated_at","DESC")->first()->updated_at;
		// 问卷最后发布时间
		$survey_pubdated = $survey->published;
		if(empty($survey_pubdated)){
			$survey_pubdated = date("Y-m-d h:i:s",0);
		}

		if( $survey_pubdated > $survey_updated ){
		 echo "已发布" ;
		} else {
		 echo "未发布" ;
		 // 进入发布程序
		 	$pubstatus = GiveAnswers::pub($survey->id);
		 	if($pubstatus){
		 		$survey->published = date("Y-m-d h:i:s");
		 		$survey->save();
		 	}
			session()->flash("success","✅ &nbsp; 问卷『". $survey->survey ."』已生成发布。请设置回复选项。");
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

	public function update(Survey $survey)
	{
		
	}
}
