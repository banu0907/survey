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
		    	Answer::where('question_id',$question->id)->update(['order_num'=>0]);
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
        // Answer::where('question_id',$qId)->where('order_num','>',$itemSize)->delete();
        // Answer::where('question_id',$qId)->where('order_num',0)->delete();
        Answer::where([['question_id',$qId],['order_num',0]])->delete();
    	return true;
    }

/*
 * 矩阵评分题 qmx 
 */
    static function qmx($qId,$qContent)
    {
    	$overall_i = 0;					// 答项整体排序号
        $items = explode("§",$qContent);
        // 拆行
        $rows = explode("¶", str_replace("[row]","",$items[0]));
        // print_r($rows);
        // 拆列
        $cols = explode("¶", str_replace("[col]","",$items[1]));
        $col = [];
        foreach ($cols as $key => $value) {
            $col[$key] = explode("¦",$value);
        }
        // print_r($col);

        // 拆选项
        $opts = explode("¶",$items[2]);
        $opt = [];
        $que_type = "radio";
        foreach ($opts as $key => $value) {
            $opt[$key] = explode("¦",$value);
            // 逐个选项分析
            if($opt[$key][0] === "switchToSRRS"){
                $switchToSRRS = 1;              // 设为单列
            }
            if($opt[$key][0] === "multipleChoice"){
                $multipleChoice = 1;                // 允许多选
                $que_type = "checkbox";
            }
            if ($opt[$key][0] === "editWeighted") {
                $editWeighted = 1;
            }
            if ($opt[$key][0] === "editNA") {
                $editNA = $opt[$key][1];        // 不适用栏标签
            }
            if ($opt[$key][0] === "editForcedRanking") {
                $editForcedRanking = 1;         // 强制排名
            }
            if ($opt[$key][0] === "otherField") {
                $otherField = 1;
                $otherAmount = $opt[$key][1];    // 备注（更多）种类
                $otherLabel = $opt[$key][2];    // 备注标签
            }
        }
        // print_r($opt);

        // 首先判断是多行或单行的情况
        if ( empty( $switchToSRRS ) ) {
            // echo "<h3>多行</h3>\n";
            $tabBody = "";
            foreach ($rows as $ri => $item) {
                $rowi = $ri + 1;

                for ($i = 0; $i < count($cols); $i++) {
	            	$overall_i ++;
                    $coli = $i + 1;
                    $tag = "item-" . $qId . "-" . $rowi . "_" . $coli;
                    $answer = $col[$i][0];
                    Answer::updateOrCreate(
                    	['question_id'=>$qId, 'tag'=>$tag ],
                    	['order_num'=>$overall_i, 'answer'=>$answer ]
                    );
                }
                // 不适用栏
                if(isset($editNA)) {
                	$overall_i ++;
                    $tag = "item-".$qId . "-" . $rowi. "_NA";
                    Answer::updateOrCreate(
                    	['question_id'=>$qId, 'tag'=>$tag ],
                    	['order_num'=>$overall_i, 'answer'=>$editNA ]
                    );
                }

                //  每行一个备注栏
                if(isset($otherField)){
                    if ($otherAmount === "per_row") {
                        $overall_i ++;
                        $tag = "item-" . $qId . "-" . $rowi."_other";
	                    Answer::updateOrCreate(
	                    	['question_id'=>$qId, 'tag'=>$tag ],
	                    	['order_num'=>$overall_i, 'answer'=>$otherLabel ]
	                    );
                    }
                }

            }

                // 整个问题使用一个备注栏
            if(isset($otherField)){
                if ($otherAmount === "per_question") {
                    $overall_i ++;
                    $tag = "item-".$qId."_other";
                    Answer::updateOrCreate(
                    	['question_id'=>$qId, 'tag'=>$tag ],
                    	['order_num'=>$overall_i, 'answer'=>$otherLabel ]
                    );
                }
            }

        } else {
            // echo "<h3>单行</h3>\n";
            $tabBody = "<tr><td class=\"td-reset\">&nbsp;</td>\n";
            for ($i = 0; $i < count($cols); $i++) {
                $id_num = $i+1;
                $overall_i ++;
                $tag = "item-".$qId."_".$id_num;
                $answer = $col[$i][0];
                Answer::updateOrCreate(
                	['question_id'=>$qId, 'tag'=>$tag ],
                	['order_num'=>$overall_i, 'answer'=>$answer ]
                );
            }
            if(isset($editNA)) {
            	$overall_i ++;
                $tag = "item-".$qId."_NA";
                Answer::updateOrCreate(
                	['question_id'=>$qId, 'tag'=>$tag ],
                	['order_num'=>$overall_i, 'answer'=>$editNA ]
                );
            }

            // 备注栏
            if (isset($otherField)) {
                $overall_i ++;
                $tag = "item-".$qId."_other";
                Answer::updateOrCreate(
                	['question_id'=>$qId, 'tag'=>$tag ],
                	['order_num'=>$overall_i, 'answer'=>$otherLabel ]
                );
            }
        }

        // 删除多余答项
        // Answer::where('question_id',$qId)->where('order_num','>',$overall_i)->delete();
		Answer::where([['question_id',$qId],['order_num',0]])->delete();
        return true;
    	// ####### end: qmx #######
    }
}
