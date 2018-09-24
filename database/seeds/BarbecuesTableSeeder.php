<?php

use Illuminate\Database\Seeder;

class BarbecuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('barbecues')->insert([
        	'id_user' => '1',
            'model' => "1515 Patio Pro Grill",
	        'description' => "Esta es la descripción",
	        'year' => 2013,
	        'price' => "100,00",
	        'transport' => 1,
	        'cooking_area' => "250 sq/in",
			'materials' => "Heavy steel construction and cast iron cooking grates",
			'dimensions' => '31" x 21" x 44" (50lbs)',
			'fuel' => "Charcoal",
			'ideal_for' => "Small Backyard Grilling",
	        'photo' => "barbecue1.jpg",
	        'latitude' => "8.293122", 
	        'longitude' => "-62.740024"
        ]);


        DB::table('barbecues')->insert([
        	'id_user' => '1',
            'model' => "2828 Pro Deluxe Grill",
	        'description' => "Esta es la descripción",
	        'year' => 2015,
	        'price' => "130,00",
	        'transport' => 0,
	        'cooking_area' => "580 sq/in",
			'materials' => "Heavy steel construction and cast iron cooking grates",
			'dimensions' => '42" x 29" x 50" (100lbs)',
			'fuel' => "Charcoal",
			'ideal_for' => "Backyard Grilling",
	        'photo' => "barbecue2.jpg",
	        'latitude' => "8.283735",
	        'longitude' => "-62.757804"
        ]);


        DB::table('barbecues')->insert([
        	'id_user' => '1',
            'model' => "Akorn Kamado Grill",
	        'description' => "Esta es la descripción",
	        'year' => 2015,
	        'price' => "150,00",
	        'transport' => 1,
	        'cooking_area' => "314 sq/in",
			'materials' => "Powder coated steel exterior and porcelain coated steel interior",
			'dimensions' => '45" x 31" x 47" (100lbs)	',
			'fuel' => "Charcoal",
			'ideal_for' => "Backyard Grilling and Smoking",
	        'photo' => "barbecue3.jpg",
	        'latitude' => "8.279189",
	        'longitude' => "-62.716261"
        ]);


        DB::table('barbecues')->insert([
        	'id_user' => '1',
            'model' => "3001 Grillin' Pro",
	        'description' => "Esta es la descripción",
	        'year' => 2018,
	        'price' => "200,00",
	        'transport' => 0,
	        'cooking_area' => "438 sq/in",
			'materials' => "Durable steel construction and cast iron cooking grates",
			'dimensions' => '49" x 28" x 49" (88lbs)',
			'fuel' => "Propane",
			'ideal_for' => "Backyard Grilling",
	        'photo' => "barbecue4.jpg",
	        'latitude' => "8.305672",
	        'longitude' => "-62.722748"
        ]);


        
    }
}
