<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
   
     *
     * @return void
     */
    public function run()
    {
        $ingredients = [
            ['name' => 'Курица'],
            ['name' => 'Лук'],
            ['name' => 'Морковь'],
            ['name' => 'Картофель'],
            ['name' => 'Чеснок'],
            ['name' => 'Помидоры'],
            ['name' => 'рыба'],
            ['name' => 'свинина'],
            ['name' => 'орехи'],
            ['name' => 'Сладкий перец'],
            ['name' => 'Говядина'],
            ['name' => 'Рис'],
            ['name' => 'Спагетти']
        ];

        DB::table('ingredients')->insert($ingredients);
    }
}