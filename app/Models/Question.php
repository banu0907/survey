<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];
    //
    
    public function survey()
    {
    	return $this->belongsTo(Survey::class);
    }

    public function survey_page()
    {
    	return $this->belongsTo(SurveyPage::class);
    }

    public function tool()
    {
        return $this->belongsTo(Tool::class,"question_type","code");
    }
}
