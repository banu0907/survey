<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Question;
use App\Models\Tool;

class QuestionsController extends Controller
{
    //
    public function __construct()
    {
    	# code...
    }

    public function index()
    {
    	# code...
    }

    public function show(Question $question)
    {
        return view('survey_design.question_show',compact('question'));
    }

    public function create(Request $request)
    {
        \Debugbar::disable();
        $question = [
            'id'=>$request->que_id,
            'question_type'=> $request->que_class
        ];
        $toolname = Tool::where("code",$request->que_class)->first()->name;
        $template_file = 'questions.create_'.$request->que_class;
    	return view($template_file,compact('question','toolname'));
    }

    public function store(Request $request)
    {

        // 存入问题数据表
        $question = Question::create([
            'survey_id'         => $request->survey_id,
            'survey_page_id'    => $request->survey_page_id,
            'question_type'     => $request->que_type,
            'title'             => $request->que_title,
            'content'           => $request->que_body,
            'required_question' => $request->que_req,
            'required_text'     => $request->que_red_text,
            'item_random'       => $request->item_ran,
            'item_last_fix'     => $request->item_last,
        ]);

        // 转换问题内容编码为HTML显示内容
        $data = [
            "id"=>$question->id,
            "type"=>$question->question_type,
            "content"=>$question->content,
        ];
        $question->content_show = QuestionCoding::show($data);
        // 存入数据表
        $question->save();

        // return "问题创建已执行". $question->id;
        return redirect()->route('questions.show',[$question]);
    }

    public function edit(Request $request)
    {
        \Debugbar::disable();
        $question = Question::find($request->que_id);
        // 对问题进行解构，分成条目
        $longword = explode("§" , $question->content);
        $clauses = explode("¶",$longword[0]);
        $que_type = "radio";
        if(!empty($longword[1])){
            $addopts = explode("¶",$longword[1]);
        } else {
            $addopts = [];
        }
        
        $toolname = Tool::where("code",$question->question_type)->first()->name;
        $template_file = 'questions.edit_'.$question->question_type;
        return view($template_file , compact('question','clauses','addopts','toolname'));
    }

    public function update(Request $request)
    {
        $showData = [
            "id"=>$request->que_id,
            "type"=>$request->que_type,
            "content"=>$request->que_body,
        ];
        $content_show = QuestionCoding::show($showData);
        $question = Question::find($request->que_id);
        $data = [
            'survey_id'         => $request->survey_id,
            'survey_page_id'    => $request->survey_page_id,
            'question_type'     => $request->que_type,
            'title'             => $request->que_title,
            'content'           => $request->que_body,
            'content_show'      => $content_show,
            'required_question' => $request->que_req,
            'required_text'     => $request->que_red_text,
            'item_random'       => $request->item_ran,
            'item_last_fix'     => $request->item_last,
        ];
    	
        $question->update($data);
        return redirect()->route("questions.show",[$question]);
    }
    
    public function destroy(Request $request)
    {
        $deleted = Question::find($request->id);
    	$deleted->update(['deleted_flag'=>true]);
        return view('questions.deleted',compact('deleted'));
    }

    public function undel(Request $request)
    {
        $question = Question::find($request->id);
        $question->update(['deleted_flag'=>false]);
        return redirect()->route("questions.show",[$question]);
    }

    public function sort(Request $request)
    {
        $idList = explode(',', $request->idlist);
        $page_num = explode(',', $request->pagelist);
        foreach ($idList as $key => $id_num) {
            $question_num = $key + 1;
            Question::find( intval($id_num) )->update([
                'question_num'=>$question_num,
                'survey_page_id'=>$page_num[$key]
            ]);
        }
        return compact('idList','page_num');
    }
}
