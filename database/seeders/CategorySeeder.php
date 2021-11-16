<?php

namespace Database\Seeders;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();
        Category::insert([
            ['name' => 'Laptops','slug'=>'laptops','created_at' => $now,'updated_at'=>$now],
            ['name' => 'Desktops','slug'=>'desktops','created_at' => $now,'updated_at'=>$now],
            ['name' => 'Tablets','slug'=>'tablets','created_at' => $now,'updated_at'=>$now],
            ['name' => 'Phones','slug'=>'phones','created_at' => $now,'updated_at'=>$now],
            ['name' => 'Tvs','slug'=>'tvs','created_at' => $now,'updated_at'=>$now],
        ]);
    }
}
