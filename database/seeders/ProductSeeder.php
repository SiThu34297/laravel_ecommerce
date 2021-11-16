<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        //laptops
        for ($i=1; $i <= 30; $i++) {
            Product::create([
                'name' => 'Laptop ' . $i,
                'slug' => 'laptops-' . $i,
                'details' => [13,14,15][array_rand([13, 14, 15])].'inch,'. [1,2,3][array_rand([1, 2, 3])]. "TB SSD, 32GB RAM",
                'price' => rand(149999, 249999),
                'description'=> 'Lorem'. $i .' ipsum dolor sit, amet consectetur adipisicing elit. Praesentium possimus aperiam molestias reiciendis deleniti ipsum, perferendis inventore cumque explicabo beatae.'
            ])->categories()->attach(1);
        }
        $products = Product::find(1);
        $products->categories()->attach(2);

        //desktops
        for ($i=1; $i <= 9; $i++) {
            Product::create([
                'name' => 'Desktop ' . $i,
                'slug' => 'desktops-' . $i,
                'details' => [24,25,27][array_rand([24, 25, 27])].'inch,'. [1,2,3][array_rand([1, 2, 3])]. "TB SSD, 32GB RAM",
                'price' => rand(249999, 429999),
                'description'=> 'Lorem'. $i .' ipsum dolor sit, amet consectetur adipisicing elit. Praesentium possimus aperiam molestias reiciendis deleniti ipsum, perferendis inventore cumque explicabo beatae.'
            ])->categories()->attach(2);
        }

        //tablet
        for ($i=1; $i <= 10; $i++) {
            Product::create([
                'name' => 'Tablet ' . $i,
                'slug' => 'tablets-' . $i,
                'details' => [9,10,13][array_rand([9, 10, 13])].'inch,'. [1,2,3][array_rand([1, 2, 3])]. "Memory Storage, 8GB RAM",
                'price' => rand(149999, 249999),
                'description'=> 'Lorem'. $i .' ipsum dolor sit, amet consectetur adipisicing elit. Praesentium possimus aperiam molestias reiciendis deleniti ipsum, perferendis inventore cumque explicabo beatae.'
            ])->categories()->attach(3);
        }

        //mobile phone
        for ($i=1; $i <= 10; $i++) {
            Product::create([
                'name' => 'Phone ' . $i,
                'slug' => 'phones-' . $i,
                'details' => [5,6,7][array_rand([5, 6, 7])].'inch,'. [1,2,3][array_rand([1, 2, 3])]. "Memory Storage, 8GB RAM",
                'price' => rand(149999, 249999),
                'description'=> 'Lorem'. $i .' ipsum dolor sit, amet consectetur adipisicing elit. Praesentium possimus aperiam molestias reiciendis deleniti ipsum, perferendis inventore cumque explicabo beatae.'
            ])->categories()->attach(4);
        }

        //tv
        for ($i=1; $i <= 10; $i++) {
            Product::create([
                'name' => 'Tv ' . $i,
                'slug' => 'tvs-' . $i,
                'details' => [39,40,45][array_rand([39, 40, 45])].'inch,'. [1,2,3][array_rand([1, 2, 3])]. "Memory Storage, 8GB RAM",
                'price' => rand(149999, 249999),
                'description'=> 'Lorem'. $i .' ipsum dolor sit, amet consectetur adipisicing elit. Praesentium possimus aperiam molestias reiciendis deleniti ipsum, perferendis inventore cumque explicabo beatae.'
            ])->categories()->attach(5);
        }
    }
}
