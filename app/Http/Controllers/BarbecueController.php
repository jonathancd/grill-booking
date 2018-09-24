<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Barbecue;

use App\User;

class BarbecueController extends Controller
{

    public function booking()
    {

    	$user = Auth::user();

    	return view('booking', ['user' => $user]);

    }


    public function barbecues(Request $request, $latitude, $longitude)
    {

    	$barbecues = Barbecue::getBarbecues($latitude, $longitude);

    	return response()->json([
    								"barbecues" => $barbecues
    							], 200);
    }


    public function show($id)
    {

        $barbecue = Barbecue::find($id);

        if($barbecue){
            return view('show', ['barbecue' => $barbecue]);
        }

        return redirect('/booking')
                ->with('status', "Barbacoa no encontrada.");
        
    }


}
