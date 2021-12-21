<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    public function dish(){
        return $this->belongsTo('App\Models\Dish');
    }
}
