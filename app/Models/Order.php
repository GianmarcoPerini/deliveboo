<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = ['name', 'surname', 'phone', "email", "city", "zip_code", "address"];

    public function dishes(){
        return $this->belongsToMany('App\Models\Dish');
    }
}
