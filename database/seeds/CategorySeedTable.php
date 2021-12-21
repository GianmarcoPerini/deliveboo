<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeedTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Hotel','Bar','Ristorante','Paninoteca','Osteria','Rosticeria'];

        foreach($categories as $cat){
            $category = new Category();
            $category->name = $cat;
            $category->save();
        }


        
    }
}
