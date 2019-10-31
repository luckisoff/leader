<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;
class LeaderBoard extends Model
{
    protected $fillable=['user_id','point','level'];
    
    public function user(){
        return $this->belogsTo(User::class);
    }
}
