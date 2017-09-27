<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Survey;
use App\Models\SurveyPage;
use App\Models\Question;

/**
 * 问卷设计工具
 */
class SurveyDesignController extends Controller
{
    /**
     * summary
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 设计主页面
    public function index(Survey $survey)
    {
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
        
        // 删除的问题列表
        $deletelist = Question::where([
                ['survey_id',$survey->id],
                ['deleted_flag',1]
            ])
            ->orderBy('updated_at','desc')->get();
        \Debugbar::info($deletelist);

        return view('survey_design.index',compact('survey','subpages','deletelist'));
        // return compact('survey','subpages');
    }

/**
 * 预览
 * @param  Survey $survey [description]
 * @return [type]         [description]
 */
    public function preview(Survey $survey)
    {
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

        return view('survey_design.preview',compact('survey','subpages'));
    }


    public function test()
    {
        $surveys = Survey::all();
        $newsurveys = $surveys->map(function ($item,$key)
        {
            $item->survey_logo = '彩旗飘';
            // print($key);
            $item->new_key = [0,1,2,3];
        });
        return $surveys;
    }
}
