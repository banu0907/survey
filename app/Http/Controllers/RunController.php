<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Question;

class RunController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
    // 显示问卷
    public function show(Survey $survey)
    {
    	// 分析问题所属的权限和状态
    	if (empty($survey->course_days)) {
    		// 常规问卷





    	} else {
    		// 疗程式调查问卷

    	}


        // 子页面显示
        $subpages = $survey->subpages()->orderBy('page_num','asc')->get()->map(function ($item,$key)
        {
            // $item->questions = SurveyPage::find($pageid)->questions()->orderBy('question_num','asc')->get()->toArray();
            $item->questions = Question::where([
                    ['survey_page_id',$item->id],
                    ['deleted_flag',0]
                ])
                 ->orderBy('question_num','asc')->get();
            return $item;

        });

        \Debugbar::info($subpages);

        return view('testing.run',compact('survey','subpages'));

    	// return $survey;
    }
}
