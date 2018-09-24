<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use Hash;

use Validator;

use App\Barbecue;

use App\BarbecueRenter;

use App\User;

class UsersController extends Controller
{

	public function __construct()
    {

        $this->messages = [
        	'name_register.required' => "Debe ingresar su nombre",
            'email.required' => "Debe ingregar su email",
          	'email.email' => "Debe ingresar un email valida",
          	'email.exists' => "Ya existe una cuenta asociada a este correo",
            'password_register.required' => "Debe ingresar una contraseña",
            
            'city_register.required' => "Debe indicar Ciudad en la que reside",
            'zipcode_register.required' => "Debe ingresar Zip Code de su Ciudad",
            'country_register.required' => "Debe seleccionar un país"
        ];
    }

    public function store(Request $request){

    	/*
			error code (Para saber cual modal levantar)
			1: Login 
			2: Register
    	*/
    	$validator = Validator::make($request->all(), [
    		'name_register' => 'required',
            'email' => 'required|email|unique:users',
            'password_register' => 'required',
            'city_register' => 'required',
            'zipcode_register' => 'required',
            'country_register' => 'required'
        ],$this->messages);

        if ($validator->fails()) {

            return redirect()
            			->back()
                        ->withErrors($validator)
                        ->withInput()
                        ->with('error_code', 2);
        }

        $user = new User;
        $user->name = $request->name_register;
        $user->email = $request->email;
        $user->password = Hash::make($request->password_register);
        $user->city = $request->city_register;
        $user->zipcode = $request->zipcode_register;
        $user->country = $request->country_register;

        if($user->save()){

            return redirect()
                    ->back()
                    ->with('status', 'Su cuenta ha sido registrada exitosamente. Para empezar a ver las barbacoas cercanas a ti, inicia sesión.');
        
        }

        return redirect()->back()->with('status_register', "Ha ocurrido un error al tratar de registrar su cuenta.");
    }


    public function history(){

        $renters = BarbecueRenter::where('id_user', Auth::user()->id)->orderBy('created_at', 'DESC')->get();

        foreach($renters as $renter){
            $renter->barbecue = Barbecue::find($renter->id_barbecue);

            $renter->seller = User::find($renter->barbecue->id_user);
            
        }

        return view('history', ['renters' => $renters]);
    }
}
