<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Audition extends Model
{   
    use SoftDeletes;
    protected $fillable=['channel','user_id','name','number','country_code','address','gender','email', 'registration_code_send_count','sms_queue'];
    
    protected  $table ="audition_registration";
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'registration_code_send_count'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function adminAuditions()
    {
        return $this->hasOne(AdminAudition::class);
    }
}
