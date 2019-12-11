<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    protected $fillable=['type','value','user_id','status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
