<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use Session;

use Validator;

use App\Barbecue;

use App\BarbecueRenter;

use App\User;

class BarbecuesRenterController extends Controller
{

	public function __construct()
    {

        $this->messages = [
        	'barbecue.required' => "No se puede rentar la barbacoa",
        	'barbecue.integer' => "No se puede rentar la barbacoa",
        	'barbecue.exist' => "Esta Barbacoa no se encuentra en la DB",

            'date_from.required' => "Debe indicar desde que día tendrá la barbacoa",
            'date_from.date' => "Debe indicar una fecha inicial valida",
            'date_to.required' => "Debe indicar hasta que día tendrá la barbacoa",
            'date_to.date' => "Debe indicar una fecha final valida",

        ];
    }

    public function booking(Request $request){

    	$validator = Validator::make($request->all(), [
    		'barbecue' => 'required|integer|exists:barbecues,id',
    		'date_from' => 'required|date',
            'date_from' => 'required|date'
        ],$this->messages);

        if ($validator->fails()) {

            return redirect()
            			->back()
                        ->withErrors($validator);
        }

        $barbecue = Barbecue::find($request->barbecue);

        $renter = new BarbecueRenter;
        $renter->id_user = Auth::user()->id;
        $renter->id_barbecue = $request->barbecue;
        $renter->date_from = $request->date_from;
        $renter->date_to = $request->date_to;
        $renter->amount = $barbecue->price;

        if(isset($request->transport)){
        	$renter->address = $request->address;
        }

        if($renter->save()){

        	$barbecue = Barbecue::find($renter->id_barbecue);

        	$barbecue->seller = User::find($barbecue->id_user);

        	Session::flash('status', 'Su renta ha sido registrada exitosamente');

            return view('details', ['renter' => $renter, 'barbecue' => $barbecue]);

        }

    	return json_encode($request->all());
    }


    public function show($id)
    {

        $renter = BarbecueRenter::find($id);

        if($renter){

        	$barbecue = Barbecue::find($renter->id_barbecue);

        	$barbecue->seller = User::find($barbecue->id_user);

            return view('details', ['renter' => $renter, 'barbecue' => $barbecue]);
        }

        return redirect('/booking')
                ->with('status', "Renta no encontrada.");
        
    }
}
