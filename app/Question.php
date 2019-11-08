<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $connection='mysql2';

    public function options(){
        return $this->hasMany(Option::class);
    }
}
