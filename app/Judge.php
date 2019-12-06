<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Judge extends Model
{
    public $timestamps = false;

    public function getTypeAttribute($type)
    {
        return ucfirst($type);
    }
}
