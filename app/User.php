<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    public function types(){
        return $this->belongsToMany('App\Models\Type');
    }

    public function userinfo(){
        return $this->hasOne('App\Models\User_info');
    }

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }

    public function dishes() {
        return $this->hasMany('App\Models\Dish');
    }
    
    public function getImagePrefix(){
        if ( str_starts_with($this->image, "users/images")){
            
            return asset('storage') . '/';
        }
        return "";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','iva','address','city','zip_code','phone','image','description','category_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
