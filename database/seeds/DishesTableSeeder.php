<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use App\Models\Dish;
use App\User;

use Faker\Generator as Faker;


class DishesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $user_ids = User::pluck('id')->toArray();


        $dishes = [
            [
                'name' => 'Pizza Margherita',
                'description'=> 'La pizza Margherita è la tipica pizza napoletana, condita con pomodoro, mozzarella (tradizionalmente è usato il fior di latte, non quella di bufala), basilico fresco, sale e olio; è, assieme alla pizza marinara, la più popolare pizza italiana.',
                'available'=>$faker->numberBetween(0, 1),
                'price'=>6,
                'image'=>'https://static.cookist.it/wp-content/uploads/sites/21/2018/04/pizza-margherita-fatta-in-casa.jpg',  
            ],
            [
                'name' => 'Pizza Prosciutto e Funghi',
                'description'=> 'La pizza al prosciutto e funghi è una di quelle pizze classiche, ma così classiche che ormai se ne trovano anche versioni surgelate al supermercato.',
                'available'=>$faker->numberBetween(0, 1),
                'price'=>8,
                'image'=>'https://www.ricettasprint.it/wp-content/uploads/2020/11/Pizza-alprosciutto-e-funghi-ricettasprint.jpg',  
            ],
            [
                'name' => 'Pizza Quattro formaggi',
                'description'=> $faker->text(100),
                'available'=>$faker->numberBetween(0, 1),
                'price'=>7,
                'image'=>'https://i0.wp.com/www.piccolericette.net/piccolericette/wp-content/uploads/2017/06/3234_Pizza.jpg?resize=895%2C616&ssl=1',  
            ],
            [
                'name' => 'Guacamole',
                'description' => 'Dici "guacamole" ed è subito fiesta! La famosa salsa messicana a base di avocado non può mancare per l\'aperitivo a base di nachos e viene spesso utilizzata per farcire sfiziose tortillas e fajitas.',
                'available'=>$faker->numberBetween(0, 1),
                'price' => 6.50,
                'image' => 'https://www.giallozafferano.it/images/236-23676/Guacamole_450x300.jpg'
            ],
            [
                'name' => 'Fajitas',
                'description' => 'La cucina tex-mex nasce al confine fra il Messico e gli Stati Uniti e vanta alcune delle ricette piu appetitose al mondo! Pensiamo ai tacos, al chili, al burrit',
                'available'=>$faker->numberBetween(0, 1),
                'price' => 9.80, 
                'image' => 'https://www.giallozafferano.it/images/215-21529/Fajitas-di-carne-e-pollo_450x300.jpg'
            ],
            [
                'name' => 'Chili',
                'description' => 'Non dite mai che il chili con carne è un piatto messicano, o almeno non ditelo davanti a un texano!',
                'available'=>$faker->numberBetween(0, 1),
                'price' => 12.50,
                'image' => 'https://www.giallozafferano.it/images/210-21043/Chili-con-carne_780x520_wm.jpg'
            ],
            [
                'name' => 'Tacos', 
                'description' => 'Avete gia apprezzato la nostra ricetta dei tacos con carne e vorreste riproporla quanto prima per una cena infrasettimanale fra amici, ma purtroppo gli orari di lavoro non vi permettono di dedicare molto tempo alla cottura della carne?',
                'available'=>$faker->numberBetween(0, 1),
                'price' => 2.50,
                'image' => 'https://www.giallozafferano.it/images/175-17533/Tacos-veloci_450x300.jpg'
            ],
            [
                'name' => 'Burrito',
                'description' => 'Come la fajita, il burrito è una ricetta che si perde fra i confini di Messico e Stati Uniti. Dato l’utilizzo delle tortillas di farina, piu grandi ed elastiche rispetto a quelle di mais.',
                'available'=>$faker->numberBetween(0, 1),
                'price' => 3.50,
                'image' => 'https://www.giallozafferano.it/images/210-21070/Burrito_780x520_wm.jpg'
            ],
            [
                'name' => 'Nachos',
                'description' => 'I nachos sono dei triangolini di farina di mais ricavati dalla divisione a spicchi delle tortillas di mais; i nachos vengono fritti, ricoperti di formaggio tagliato alla julienne, cosparsi di fettine di peperoncino fresco e infornati (o passati al microonde) per qualche minuto fino alla fusione del formaggio.',
                'available'=>$faker->numberBetween(0, 1),
                'price' => 12.50,
                'image' => 'https://www.giallozafferano.it/images/6-639/Nachos_780x520_wm.jpg'
            ],
            [
                'name' => 'Frijoles refritos',
                'description' => 'La crema di fagioli (frijole refritos) è una pietanza molto usata in Messico per accompagnare piatti tipici locali a base di pollo e carne.  ',
                'available'=>$faker->numberBetween(0, 1),
                'price' => 11.50,
                'image' => 'https://www.giallozafferano.it/images/6-635/Crema-di-fagioli--frijoles-refritos_780x520_wm.jpg'
            ],
            [
                'name' => 'Fajitas di pollo',
                'description' => 'La cucina tex-mex vuole che nelle fajitas non debbano mai mancare un tocco di piccante, peperoni e cipolle saltate in padella. E poi la carne ovviamente!  ',
                'available'=>$faker->numberBetween(0, 1),
                'price' => 21.50,
                'image' => 'https://www.giallozafferano.it/images/36-3694/Fajitas-di-pollo-e-pancetta_450x300.jpg'
            ],
            [
                'name' => 'Tortilla chips',
                'description' => 'Serata tra amici e cena a tema etnico? Se amate il cibo tex-mex potete preparare tante gustose ricette ricche di colori e profumi ed iniziare con le tortilla chips! Croccanti e sottili sfoglie di mais fritte ideali da servire come antipasto.  ',
                'available'=>$faker->numberBetween(0, 1),
                'price' => 7.50,
                'image' => 'https://www.giallozafferano.it/images/6-638/Tortilla-chips_780x520_wm.jpg'
            ],
            [
                'name' => 'Ravioli rossi al pomodoro',
                'description' => 'I ravioli rossi al pomodoro sono dei fagottini di pasta fresca fatta in casa, composti da ingredienti semplici come semola, uova e pomodoro. Il ripieno dei ravioli rossi al pomodoro non potrebbe essere più sfizioso: ricotta, parmigiano e basilico. I sapori dei ravioli rossi al pomodoro si sposano bene con un condimento semplice profumato alle erbe aromatiche.',
                'available'=>$faker->numberBetween(0, 1),
                'price' => 8.50,
                'image' => 'https://www.giallozafferano.it/images/7-715/Ravioli-al-pomodoro_780x520_wm.jpg'
            ],

        ];
        
        foreach($user_ids as $user){ // ciclo sugli user

            for($i=0;$i<3;$i++){ // per ogni user creo tre piatti

                $dishIndex = rand(0, count($dishes) - 1); 
                // piatto singolo = array dishes[numero randomico]
                // ogni ristorante cosí ha 3 piatti randomicamente scelti 
                $dish = $dishes[$dishIndex];
            
                $newDish = new Dish();

                $newDish->user_id = $user;
                $newDish->name = $dish['name'];
                $newDish->description = $dish['description'];
                $newDish->available = $faker->numberBetween(0, 1);
                $newDish->price = $dish['price'];
                $newDish->weigth = $faker->numberBetween(2, 100);
                $newDish->image = $dish['image'];

                $newDish->save();
                
            }
        }


    }
}
