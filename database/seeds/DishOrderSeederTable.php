<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use App\Models\Dish;
use App\Models\Order;


class DishOrderSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dishes = Dish::all();

        $order_id = Arr::pluck(Order::all(), 'id');

        foreach($dishes as $dish){
            $dish->orders()->sync([Arr::random($order_id) => ['quantity' => 1]]);
        }
    }
}
