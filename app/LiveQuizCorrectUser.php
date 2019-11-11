<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiveQuizCorrectUser extends Model
{
    protected $fillable=['user_id','question_set','correct','prize','point','total_time','live_paid'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
