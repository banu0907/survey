<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    //
	public function questions()
	{
		return $this->hasMany(Question::class,"question_type","code");
	}
}
