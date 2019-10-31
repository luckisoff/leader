<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GundrukOfflineQuiz extends Model
{
    protected  $table = "leaderboard_offline_quiz";

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
