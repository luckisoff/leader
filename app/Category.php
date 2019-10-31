<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'picture', 'is_series', 'status','is_approved','created_by', 'created_at', 'updated_at'];
    
	public function subCategory()
    {
        return $this->hasMany('App\SubCategory');
    }

    public function genre()
    {
        return $this->hasMany('App\Genre');
    }

    public function adminVideo()
    {
        return $this->hasMany('App\AdminVideo');
    }
    
    public function story()
    {
        return $this->hasMany('App\Stories');
    }
    

	public static function boot()
    {
        //execute the parent's boot method 
        parent::boot();

        //delete your related models here, for example
        static::deleting(function($categories)
        {
            foreach($categories->subCategory as $sub_category)
            {                
                $sub_category->delete();
            } 

            foreach($categories->adminVideo as $video)
            {                
                $video->delete();
            } 

        });	

    }

    
}
