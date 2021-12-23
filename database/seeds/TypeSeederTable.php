<?php

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['Cinese', 'Pizza', 'Hamburgher', 'Italiano', 'Giapponese'];
        $imgs = [
            'https://just-eat-prod-eu-res.cloudinary.com/image/upload/c_fill,f_auto,h_190,q_auto,w_187/v1/it/cuisine-icons/cinese',
            'https://just-eat-prod-eu-res.cloudinary.com/image/upload/c_fill,f_auto,h_190,q_auto,w_187/v1/it/cuisine-icons/pizza',
            'https://just-eat-prod-eu-res.cloudinary.com/image/upload/c_fill,f_auto,h_190,q_auto,w_187/v1/it/cuisine-icons/hamburger',
            'https://just-eat-prod-eu-res.cloudinary.com/image/upload/c_fill,f_auto,h_190,q_auto,w_187/v1/it/cuisine-icons/italiano',
            'https://just-eat-prod-eu-res.cloudinary.com/image/upload/c_fill,f_auto,h_190,q_auto,w_187/v1/it/cuisine-icons/giapponese'
        ];

        for($i = 0; $i < count($types); $i++){

            $newType = new Type();
            $newType->name = $types[$i];
            $newType->img = $imgs[$i];
            $newType->isCheck = false;
            $newType->save();
        }
    }
}
