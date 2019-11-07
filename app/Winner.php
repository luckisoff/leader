<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Winner extends Model
{
    protected $fillable=['user_id','question_set','point','prize','quiz_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
