<?php

use Illuminate\Database\Seeder;
use App\Models\Dish;
use App\Models\Ingredient;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

class IngredientSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $dishes = Arr::pluck(Dish::all(), 'id');

        foreach($dishes as $dish)
        {
            for($i = 0; $i < 3; $i++)
            {
                $newIngredient = new Ingredient();
                $newIngredient->dish_id = $dish;
                $newIngredient->name = $faker->word();
                $newIngredient->save();
            }
        }
    }
}
