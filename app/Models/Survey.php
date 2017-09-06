<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
	// protected $fillable = ['survey'];
    protected $guarded = []; 

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function subpages()
    {
    	return $this->hasMany(SurveyPage::class);
    }
    
    public function questions()
    {
    	return $this->hasManyThrough(Question::class,SurveyPage::class);
    }
}
