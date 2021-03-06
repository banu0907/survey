<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Tool;

class  QuestionCoding extends Controller
{
    // 对问题内容进行处理，供显示和编辑之用
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
        self::$qId      = $question["id"];
        self::$qType    = $question["type"];
        self::$qContent = $question["content"];
        // 读取问题类型横板数据库tools
        $tplText        = Tool::where('code',self::$qType)->first()->tpl_out;
        self::$tplText  = $tplText;
        $show_text      = call_user_func([__CLASS__,self::$qType."_c"]);
        return $show_text;
    }

/**
 * 编辑视图数据
 * @param  [type] $question [description]
 * @return [type]           [description]
 */
	static function edit($question)
	{
        self::$qId      = $question["id"];
        self::$qType    = $question["type"];
        self::$qContent = $question["content"];
        $editOut        = call_user_func([__CLASS__,self::$qType."_e"]);
        return $editOut;
	}

    /**
     * 选择题 qmc
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
                    "item-" . $que_id . "_" . $id_num,
                    $id_num,
                    $item
                ];

                $que_show .= str_replace($old_text , $new_text , self::$tplText);
            }
            return $que_show;
    }

    static function qmc_e()
    {
        // 对问题进行解构，分成条目
        $longword = explode("§" , self::$qContent);
        $clauses = explode("¶",$longword[0]);

        if(!empty($longword[1])){
            $addopts = explode("¶",$longword[1]);
        } else {
            $addopts = [];
        }
        return compact("clauses" ,"addopts");
    }


/**
 * 矩阵评分题 qmx 
 * @return [type] [description]
 */
    static function qmx_c()
    {
        // 此题型过于复杂，直接组装，只局部使用模版替换方法 

        $que_id = self::$qId;
        $items = explode("§",self::$qContent);
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

        $tabText = "<table class=\"table table-hover table-reset\">\n";
        // ===========
        // 构建表头
        $tabText .= "<thead>\n<tr>\n<th>&nbsp;</th>\n";
        for ($i = 0; $i < count($cols); $i++) {
            $tabText .= "<th>".$col[$i][0]."</th>\n";
        }
        // 不适用栏表头
        if(isset($editNA)){
            $tabText .= "<th>".$editNA."</th>\n";
        }
        $tabText .= "</tr>\n</thead>\n";
        // ===========
        // 构建表体
        $tabText .= "<tbody>\n";
        $old_text = [
            "{type}",
            "{name}",
            "{id}",
            "{val}",
            "{label}"
        ];
        // 首先判断是多行或单行的情况
        if ( empty( $switchToSRRS ) ) {
            // echo "<h3>多行</h3>\n";
            $tabBody = "";
            foreach ($rows as $ri => $item) {
                $rowi = $ri + 1;
                $tabBody .= "<tr><th>" . $item ."</th>\n";
                for ($i = 0; $i < count($cols); $i++) {
                    $coli = $i + 1;
                    $new_text = [
                        $que_type,
                        "item-" . $que_id . "-" . $rowi,
                        "item-" . $que_id . "-" . $rowi . "_" . $coli,
                        $coli,
                        $col[$i][0]
                    ];
                    $tabBody .= str_replace($old_text,$new_text,self::$tplText);
                }
                // 不适用栏
                if(isset($editNA)) {
                    $new_text = [
                        $que_type,
                        "item-".$que_id . "-" . $rowi,
                        "item-".$que_id . "-" . $rowi. "_NA",
                        "NA",
                        $editNA
                    ];
                    $tabBody .= str_replace($old_text,$new_text,self::$tplText);
                }
                $tabBody .= "</tr>\n";
                //  每行一个备注栏
                if(isset($otherField)){
                    if ($otherAmount === "per_row") {
                        $col_count = count($cols) + 1;
                        if(isset($editNA)) $col_count ++;
                        $tabBody .= "<tr><td colspan=\"" . $col_count . "\">" 
                            . $otherLabel
                            . "<input type=\"text\" id=\"item-".$que_id.  "-" . $rowi."_other\" name=\"". $que_id ."\" >"
                            ."</td></tr>\n";
                    }
                }

            }

                // 整个问题使用一个备注栏
            if(isset($otherField)){
                if ($otherAmount === "per_question") {
                    $col_count = count($cols) + 1;
                    if(isset($editNA)) $col_count ++;
                    $tabBody .= "<tr><td colspan=\"" . $col_count . "\">" 
                        . $otherLabel
                        . "<input type=\"text\" id=\"item-".$que_id."_other\" name=\"". $que_id ."\" >"
                        ."</td></tr>\n";
                }
            }

        } else {
            // echo "<h3>单行</h3>\n";
            $tabBody = "<tr><td class=\"td-reset\">&nbsp;</td>\n";
            for ($i = 0; $i < count($cols); $i++) {
                $id_num = $i+1;
                $new_text = [
                    $que_type,
                    "item-".$que_id,
                    "item-".$que_id."_".$id_num,
                    $id_num,
                    $col[$i][0]
                ];
                $tabBody .= str_replace($old_text,$new_text,self::$tplText);
            }
            if(isset($editNA)) {
                $new_text = [
                    $que_type,
                    "item-".$que_id,
                    "item-".$que_id."_NA",
                    "NA",
                    $editNA
                ];
                $tabBody .= str_replace($old_text,$new_text,self::$tplText);
            }

            $tabBody .= "</tr>\n";
            // 备注栏
            if (isset($otherField)) {
                $col_count = count($cols) + 1;
                if(isset($editNA)) $col_count ++;
                $tabBody .= "<tr><td colspan=\"" . $col_count . "\">" 
                    . $otherLabel
                    . "<input type=\"text\" id=\"item-".$que_id."_other\" name=\"". $que_id ."\" >"
                    ."</td></tr>\n";
            }
        }

        $tabText .= $tabBody;
        $tabText .= "</tbody>\n</table>";


        return $tabText;
    }


    static function qmx_e()
    {
        $longword = explode("§", self::$qContent);
        $rows     = explode("¶", str_replace("[row]","",$longword[0]));
        $colTexts     = explode("¶", str_replace("[col]","",$longword[1]));
        $cols      = [];
        foreach ($colTexts as $key => $value) {
            $colText = explode("¦",$value);
            $cols[$key] = [
                "text" => $colText[0],
                "weight" => $colText[1]
            ];
        }
        $opts = explode("¶",$longword[2]);
        $addopts = [];
        foreach ( $opts as $key => $value ) {
            $opt[$key] = explode("¦",$value);
            // 逐个选项分析
            if($opt[$key][0] === "switchToSRRS"){
                $addopts["switchToSRRS"] = 1;              // 设为单列
            }
            if($opt[$key][0] === "multipleChoice"){
                $addopts["multipleChoice"] = 1;                // 允许多选
            }
            if ($opt[$key][0] === "editWeighted") {
                $addopts["editWeighted"] = 1;      // 使用权重
            }
            if ($opt[$key][0] === "editNA") {
                $addopts["editNA"] = 1;
                $addopts["editNALabel"] = $opt[$key][1];        // 不适用栏标签
            }
            if ($opt[$key][0] === "editForcedRanking") {
                $addopts["editForcedRanking"] = 1;         // 强制排名
            }
            if ($opt[$key][0] === "otherField") {
                $addopts["otherField"] = 1;
                $addopts["otherAmount"] = $opt[$key][1];    // 备注（更多）种类
                $addopts["otherLabel"] = $opt[$key][2];    // 备注标签
            }
        }

        return $optText = [
            "rows" => $rows,
            "cols" => $cols,
            "addopts" => $addopts,
        ];
        // return compact("rows","cols","addopts");
    }
}
