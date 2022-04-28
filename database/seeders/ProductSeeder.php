<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
    	Product::factory()->create([
		    'name' => 'Samsung Galaxy S20 Ultra',
		    'price' => '2849900'
		]);

		Product::factory()->create([
		    'name' => 'Apple Iphone 11 64GB',
		    'price' => '2799900'
		]);

		Product::factory()->create([
		    'name' => 'Samsung Galaxy Note 10 Plus',
		    'price' => '2299900'
		]);

		Product::factory()->create([
		    'name' => 'Portátil Lenovo 14W',
		    'price' => '799000'
		]);

		Product::factory()->create([
		    'name' => 'MacBook Air 13 Chip M1 256GB',
		    'price' => '4699000'
		]);  

		Product::factory(20)->create();      
    }
}
