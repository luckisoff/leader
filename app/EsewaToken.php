<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EsewaToken extends Model
{
    protected $fillable=['user_id','request_id'];
}
