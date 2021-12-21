<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            OrderTableSeeder::class,
            CategorySeedTable::class,
            TypeSeederTable::class,
            UserSeederTable::class,
            DishesTableSeeder::class,
            IngredientSeederTable::class,   
            DishOrderSeederTable::class,
            TypeUserSeederTable::class,         
        ]);
    }
}
