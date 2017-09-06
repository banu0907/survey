<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyPage extends Model
{
	// protected $fillable = ['page_number','page_title'];
	protected $guarded = [];

	public function survey()
	{
		return $this->belongsTo(Survey::class);
	}
	public function questions()
	{
		return $this->hasMany(Question::class);
	}
}
