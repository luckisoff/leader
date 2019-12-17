<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminAudition extends Model
{
    protected $fillable=['admin_id','audition_id'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

}
