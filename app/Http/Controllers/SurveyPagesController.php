<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SurveyPage;

class SurveyPagesController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function index()
    {
    	# code...
    }

    public function show(SurveyPage $surveypage)
    {
        $survey = $surveypage->survey;
        return view('survey_design.page', compact('surveypage','survey'));
    }

    public function create()
    {
        # code...
    }

    public function store(Request $request)
    {
        $surveypage = SurveyPage::create([
            'survey_id'=>$request->survey_id,
            'page_num'=>$request->page_num
        ]);
        return redirect()->route('surveypages.show',[$surveypage]);
    }

    public function edit(SurveyPage $surveypage)
    {
    	return compact('surveypage');
    }

    public function update(SurveyPage $surveypage,Request $request)
    {
        $data = [];
        if ($request->page_title) {
            $data["page_title"] = $request->page_title;
        }
        if ($request->page_description) {
            $data["page_description"] = $request->page_description;
        }
        if ($request->page_logic) {
            if($request->page_logic === "description") $request->page_logic = NULL;
            $data["page_logic"] = $request->page_logic;
        }

        $updated = $surveypage->update($data);
        return $updated ? "true" : "false";
    }
    
    public function destroy(SurveyPage $surveypage , Request $request)
    {
        if ($request->delpageque === "delete") {
            $deletelist = $surveypage->questions;
            $surveypage->questions()->update([
                    "deleted_flag"=>true
                ]);
        }
        $surveypage->delete();
        return view('survey_design.page_deleted',compact('deletelist'));
    }

    public function sort(Request $request)
    {
        $pageIds = explode(',', $request->pageidlist);
        foreach ($pageIds as $key => $pageId) {
            $page_num = $key + 1;
            SurveyPage::find( intval($pageId) )->update([
                    'page_num' => $page_num
                ]);
        }
        return compact('pageIds');
    }
}
