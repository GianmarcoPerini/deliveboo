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
        $types = ['Cinese', 'Mexican', 'Tex-Mex', 'Italian', 'Churascaria', 'Hamburgheria', 'Pesce'];

        foreach($types as $type){

            $newType = new Type();
            $newType->name = $type;
            $newType->save();
        }
    }
}
