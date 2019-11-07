<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Livequiz extends Model
{
    protected $fillable=['user_id','question','question_set','option','answer','prize','point'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    
}
