<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function users(){
        return $this->hasMany('App\User');
    }
}
