<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use Validator;

class LoginController extends Controller
{
    public function __construct()
    {

        $this->messages = [
            'email_login.required' => "Debe ingregar el email",
          	'email_login.email' => "Debe ingresar un email valida",
            'password_login.required' => "Debe ingresar una contraseña"
        ];
    }


    public function home(){
        return view('welcome');
    }



	public function auth(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'email_login' => 'required|email',
            'password_login' => 'required',
        ],$this->messages);

        if ($validator->fails()) {

            return redirect()
            			->back()
                        ->withErrors($validator)
                        ->withInput()
                        ->with('error_code', 1);
        }

        if (Auth::attempt(['email' => $request->email_login, 'password' => $request->password_login],isset($request->remember)) ) {
            
            return redirect('/booking');

        }
            
        return redirect()
        		->back()
        		->with('error_code', 1)
        		->with('status_login', "No se ha podido iniciar sesion. Revise sus datos.");
        
    }




    public function logout()
    {

        Auth::logout();
        return redirect('/');

    }

}
