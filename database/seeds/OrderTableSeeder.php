<?php

use Illuminate\Database\Seeder;
use App\Models\Order;
use Faker\Generator as Faker;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ( $i = 0 ; $i < 30; $i++) {
            $newOrder= new Order();

            $newOrder->name = $faker->firstName();
            $newOrder->surname = $faker->lastName();
            $newOrder->phone = $faker->e164PhoneNumber();
            $newOrder->email = $faker->safeEmail();
            $newOrder->city = $faker->city();
            $newOrder->zip_code = $faker->randomNumber(5, false);
            $newOrder->address = $faker->address();

            $newOrder->save();
        }
    }
}
