<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaderAmountWithDraw extends Model
{
    protected $fillable=['user_id','amount','type','mobile','status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
