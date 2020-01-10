<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stories extends Model
{
    
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    
	public static function boot()
    {
		//execute the parent's boot method 
        parent::boot();
		
    }

    public function getCreatedAtAttribute($created_at)
    {
        return \Carbon\Carbon::parse($created_at)->diffForHumans();
    }
}
