<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    protected $table = "problems";

    public function ProblemCategory()
    {
    	return $this->hasOne('App\ProblemCategory');
    }
}
