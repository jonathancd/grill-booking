<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', ['as' => 'home', 'uses' => function () {
    if(!Auth::check()){
    	return view('welcome');
    }else{
		return redirect('/booking');
	}
}]);

Route::post('/register',['as' => 'register', 'uses' => 'UsersController@store']);
Route::post('/login',['as' => 'login', 'uses' => 'LoginController@auth']);


Route::get('/logout',['as' => 'logout', 'uses' => 'LoginController@logout']);

Route::group(['middleware' => 'auth'], function() {
	Route::get('/booking', 'BarbecueController@booking');
	Route::post('/booking', 'BarbecuesRenterController@booking');
	Route::get('/booking/{id}', 'BarbecueController@show');
	Route::get('/booking/{id}/details', 'BarbecuesRenterController@show');
	Route::get('/booking/renter/history', 'UsersController@history');
});
