<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Survey;

use Auth;

class SurveysController extends Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        $surveys = Auth::user()->surveys()->orderBy("updated_at","DESC")->paginate(10);
        return view('surveys.index',compact('surveys'));
    }

    public function show(Survey $survey)
    {
        return '摘要： '.$survey->id;
    }

    public function create()
    {
    	return view('surveys.create');
    }

    public function store(Request $request)
    {
        $survey = Auth::user()->surveys()->create([
            'survey' =>$request->survey
        ]);
        $survey->subpages()->create([
                'page_num'=>1,
            ]);
        return redirect()->route('create',$survey->id);
    }

    public function edit(Survey $survey)
    {
        return '编辑问卷: '.$survey->id;
    }

    public function update(Survey $survey , Request $request)
    {
        $data = [];
        if ($request->surveyTitle) {
            $data["survey"] = $request->surveyTitle;
        }
        if($request->surveyTitleAlignment) {
            $data["survey_alignment"] = $request->surveyTitleAlignment;
        }
        $updated = $survey->update($data);
        return $updated ? "true" : "false";
    }

    public function destroy(Survey $survey)
    {
        $survey->questions()->delete();
        $survey->subpages()->delete();
        $survey->delete();
        session()->flash('success','成功删除问卷！');
        return redirect()->route('surveys.index');
    }
}

