<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {        
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'iva' => ['required', 'digits:11'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string'],
            'zip_code' => ['required', 'digits:5'],
            'phone' => ['required', 'numeric'],
            'image' => ['image'],
            'description' => ['string', 'nullable'],
        ],
        [
            'required.name' => "Inserire un nomer per l'attività",
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {       
        // dd($data); 
        $data['image'] = Storage::put('users/images', $data['image']);
        return User::create([
            'category_id' => $data['category'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'iva' => $data['iva'],
            'address' => $data['address'],
            'city' => $data['city'],
            'zip_code' => $data['zip_code'],
            'phone' => $data['phone'],
            'image' => $data['image'],
            'description' => $data['description'],            
        ]);
    }
}
