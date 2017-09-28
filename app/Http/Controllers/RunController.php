<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;

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




    	return $survey;
    }
}
