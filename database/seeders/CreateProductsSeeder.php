<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CreateProductsSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create();
        $posts = Category::all()->pluck('id')->toArray();
        $products = [
            'name' => 'A70',
            'category_id'=> $faker->randomElement($posts),
            'seller_id' => '1',
            'brand' => 'Samsung',
            'description'=>'aaaaa',
            'original_price'=>'1200000',
            'selling_price'=>'1300000',
            'qty'=>'12',
            'status'=>'1',
            'trending'=>'1',
            'meta_title'=>'aaaaaaaaaaa',
            'meta_keywords'=>'aaaaaaaaaaaaaa2',

        ];
        Product::create($products);

    }
}
