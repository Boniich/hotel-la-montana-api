<?php

namespace Database\Seeders;

use App\Models\Food;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $food = new Food();

        $food->name = "Hamburgesa";
        $food->description = "Clasica hamburgesa argentina";
        $food->image = "image";
        $food->price = 10.5;
        $food->preparation_time = 5.5;

        $food->save();


        $food2 = new Food();

        $food2->name = "Fideos con salsa";
        $food2->description = "Fideos caseros con una salsa de toma italiana";
        $food2->image = "image";
        $food2->price = 10.5;
        $food2->preparation_time = 5.5;

        $food2->save();


        $food3 = new Food();

        $food3->name = "Papas con cheddar";
        $food3->description = "Papas con mucho cheddar y pansetas";
        $food3->image = "image";
        $food3->price = 10.5;
        $food3->preparation_time = 5.5;

        $food3->save();
    }
}
