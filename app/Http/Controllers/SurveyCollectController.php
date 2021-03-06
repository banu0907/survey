<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;

class SurveyCollectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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

/**
 * 问卷发布选项 更新
 * @param  Survey  $survey  [description]
 * @param  Request $request [description]
 * @return [type]           [description]
 */
	public function update(Survey $survey,Request $request)
	{
        $data = [];
        if ($request->allow_multiple_responses) {
            $data["multiple_responses"] = $request->allow_multiple_responses;
        }
        if($request->edit_responses) {
            $data["edit_responses"] = $request->edit_responses;
        }
        if ($request->make_anonymous) {
        	$data["make_anonymous"] = $request->make_anonymous;
        }
        if ($request->instant_results) {
        	$data["instant_results"] = $request->instant_results;
        }
        if ($request->end_time) {
        	$end_time = $request->end_time;
        	if($end_time == "false") {
        		$end_time = NULL;
        	}
        	$data["end_time"] = $end_time;
        }

        if ($request->max_responses) {
        	$max_responses = $request->max_responses;
        	if($max_responses == "false") {
        		$max_responses = NULL;
        	}
        	$data["max_responses"] = $max_responses;
        }

        if ($request->ipaccess) {
        	$ipaccess = $request->ipaccess;
        	if ($ipaccess == "false") {
        		$ipaccess = NULL;
        		$data["ip_list"] = NULL;
        	} else {
        		$data["ip_list"] = $request->ip_list;
        	}
        	$data["ipaccess"] = $ipaccess;
        }

		// 疗程式调查设置
        if($request->course) {
        	$course = $request->course;
        	if ($course == "false") {
        		$data["course_days"] = NULL;
        	}
        }

        if ($request->course_days) {
        	$data['course_days'] = $request->course_days;
        }

        if ($request->course_frequency) {
        	$frequency = $request->course_frequency;
        	if ($frequency == 'false') {
        		$frequency = NULL;
        	}
        	$data['course_frequency'] = $frequency;
        }

        if ($request->course_start_time) {
        	$start_time = $request->course_start_time;
        	if ($start_time == "false") {
        		$data['course_start_time'] = NULL;
        	} else {
        		$data['course_start_time'] = $start_time;
        	}
        }

        $updated = $survey->update($data);
        // return compact('data','end_time');
        return $updated ? "true" : "false";
	}
}
