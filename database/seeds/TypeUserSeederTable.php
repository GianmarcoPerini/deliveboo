<?php

use App\Models\Type;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class TypeUserSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        $type_id = Arr::pluck(Type::all(), 'id');

        foreach($users as $user){
            $user->types()->sync([Arr::random($type_id),Arr::random($type_id)]);
        }
    }
}
