<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiveViewer extends Model
{
    protected $fillable=['user_id','question_set'];
}
