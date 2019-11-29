<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpinnerDailyPoint extends Model
{
    protected $fillable=['user_id','point','available_spin'];
}
