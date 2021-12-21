<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\User_info;
use App\User;

class UserInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $users = User::pluck('id')->toArray();
        foreach($users as $user)
        {
            $newInfo = new User_info();
            $newInfo->user_id = $user;
            $newInfo->iva = $faker->numerify('###########');
            $newInfo->address = $faker->streetName();
            $newInfo->city = $faker->city();
            $newInfo->zip_code = $faker->numerify('#####');
            $newInfo->phone = $faker->numerify('#############');
            $newInfo->image = $faker->imageUrl(1280, 720);;
            $newInfo->description = $faker->text(100);
            $newInfo->save();
        }
    }
}
