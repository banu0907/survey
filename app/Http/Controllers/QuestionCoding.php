<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Tool;

class  QuestionCoding extends Controller
{
    //
    static $qId;
    static $qType;
    static $qContent;
    static $tplText;

    // public function __construct($question)
    // {
    // }
/**
 * 问题显示用HTML编码生成输出
 * @param  [array] $question [description]
 * @return [type]           [description]
 */
    static function show($question)
    {
        self::$qId = $question["id"];
        self::$qType = $question["type"];
        self::$qContent = $question["content"];
        // 读取问题类型横板数据库tools
        $tplText = Tool::where('code',self::$qType)->first()->tpl_out;
        self::$tplText = $tplText;
        $show_text = call_user_func([__CLASS__,self::$qType."_c"]);
        return $show_text;
    }


	static function edit($question)
	{
		
	}

    /**
     * 选择题 HTML编码
     * @return [type] [description]
     */
    static function qmc_c()
    {
    	// 拆分提交的数据长字串
        $longword = explode("§", self::$qContent);
        $items = explode("¶",$longword[0]);
        $que_type = "radio";
        if(!empty($longword[1])){
            $addopts = explode("¶",$longword[1]);
            if(in_array("mcp", $addopts)){
                $que_type = "checkbox";
            }
        }
        // 生成HTML
            $que_id = self::$qId;
            $que_show = "";
            foreach ($items as $key => $item) {
                $id_num = $key + 1;
                $old_text = [
                    "{type}" ,
                    "{name}" ,
                    "{id}" ,
                    "{val}" ,
                    "{text}"
                ];
                $new_text = [
                    $que_type,
                    "item-" . $que_id,
                    "item-" . $que_id . "-" . $id_num,
                    $id_num,
                    $item
                ];

                $que_show .= str_replace($old_text , $new_text , self::$tplText);
            }
            return $que_show;
    }
}
