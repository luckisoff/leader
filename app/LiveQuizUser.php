<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiveQuizUser extends Model
{
    protected $fillable=['question_set','user_id'];
}
