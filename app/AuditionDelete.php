<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuditionDelete extends Model
{
    protected $fillable=['admin_id','audition_id','ip'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function audition()
    {
        return $this->belongsTo(Audition::class,'audition_id')->withTrashed();
    }
}
