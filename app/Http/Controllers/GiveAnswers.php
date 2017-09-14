<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Question;
use App\Models\Answer;

class GiveAnswers extends Controller
{
    //
    
    static $survey_id;
    static function pub($survey_id)
    {
    	try {
	    	self::$survey_id = $survey_id;
	    	$questions = Question::where("survey_id",$survey_id)->each(function ($question,$key)
	    	{
	    		// echo $question->id." ".$question->question_type." ".$question->content;
	    		call_user_func([__CLASS__,$question->question_type],$question->id,$question->content);
	    	});

	    	return true;

    	} catch (Exception $e){
    		return false;
    	}
    }

/*
 * 选择题 qmc
 */
    static function qmc($qId,$qContent)
    {

    	$longword = explode("§", $qContent);
        $items = explode("¶",$longword[0]);
        // 更新或新建答项
        foreach ($items as $key => $item) {
            $order_num = $key + 1;
            $tag = "item-" . $qId . "_" . $order_num;
	    	Answer::updateOrCreate(
	    		['question_id'=>$qId, 'tag' => $tag ],
	    		['order_num'=> $order_num, 'answer' => $item ]
	    	);
        }
        // 删除多余答项
        $itemSize = count($items);
        Answer::where('question_id',$qId)->where('order_num','>',$itemSize)->delete();
    	return true;
    }

/*
 * 矩阵评分题 qmx 
 */
    static function qmx($qId,$qContent)
    {
    	
    }
}
