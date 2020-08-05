<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

$paths = array(
				'companies'           => 'CompaniesController',
				'employees'            => 'EmployeesController',
			);
            
foreach($paths as $slug => $controller){
	Route::get('/'.$slug.'/index', $controller.'@index')->name($slug.'.index');
	Route::post('/'.$slug.'/list', $controller.'@list')->name($slug.'.list');
	Route::delete('/'.$slug.'/delete/{id}', $controller.'@destroy')->name($slug.'.delete');
	Route::get('/'.$slug.'/form/{id}', $controller.'@form')->name($slug.'.form');
	Route::post('/'.$slug.'/store/', $controller.'@store')->name($slug.'.save');
	Route::post('/'.$slug.'/alldeletes', $controller.'@alldeletes')->name($slug.'.alldeletes');
}
