<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class LeaderBoard extends Model
{
    protected $fillable=['user_id','point','level'];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}
