<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Problem
 *
 * @property-read \App\ProblemCategory $ProblemCategory
 * @mixin \Eloquent
 */
class Problem extends Model
{
    protected $table = "problems";

    public function ProblemCategory()
    {
    	return $this->hasOne('App\ProblemCategory');
    }
}
