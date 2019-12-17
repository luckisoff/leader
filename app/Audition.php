<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Audition extends Model
{
    public $timestamps = false;
    protected $fillable=['user_id','name','number','address','gender','email'];
    protected  $table ="audition_registration";

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function adminAuditions()
    {
        return $this->hasMany(AdminAudition::class);
    }
}
