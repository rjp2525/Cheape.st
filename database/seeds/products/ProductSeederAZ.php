<?php

use Cheapest\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class ProductSeederAZ extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            //
        ];

        // Insert all the products
        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
