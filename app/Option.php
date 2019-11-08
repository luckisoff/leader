<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $connection='mysql2';
    
    public function question(){
        return $this->belongsTo(Question::class);
    }
}
