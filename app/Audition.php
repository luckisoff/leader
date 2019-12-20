<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Audition extends Model
{   
    use SoftDeletes;
    protected $fillable=['channel','user_id','name','number','country_code','address','gender','email'];
    
    protected  $table ="audition_registration";
    protected $dates = ['deleted_at'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function adminAuditions()
    {
        return $this->hasOne(AdminAudition::class);
    }
}
