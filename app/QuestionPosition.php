<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionPosition extends Model
{
    protected $fillable=['id','set','question_id'];
}
