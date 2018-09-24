<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class Barbecue extends Model
{
    
	public static function getBarbecues($latitude, $longitude){
		
		$barbecues = DB::select('
					SELECT b.*, ( 6371 * acos( cos( radians('.$latitude.') ) * cos( radians( `latitude`) ) * cos( radians( `longitude` ) - radians('.$longitude.') ) + sin( radians('.$latitude.') ) * sin( radians( `latitude` ) ) ) ) AS distance
					FROM barbecues b 
					HAVING distance < 10
					ORDER BY distance'
				);

		return $barbecues;
	}

}
