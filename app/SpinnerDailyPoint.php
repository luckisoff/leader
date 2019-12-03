<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpinnerDailyPoint extends Model
{
    protected $fillable=['user_id','point','available_spin','check-in'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
