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
Route::get('/', function(){
	return redirect()->route('login');	
});

Route::get('/login', 'Auth\LoginController@view')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('login.exe');

Route::view('/welcome', 'welcome');

Route::middleware('user')->group(function(){
	Route::get('/dashboard', function(){
		return view('pages.dashboard');
	})->name('dashboard');
	Route::get('/self', 'UserController@self')->name('self-data');
	Route::post('/self', 'UserController@selfStore')->name('self-store');

	Route::prefix('user')->name('user.')->group(function(){
		Route::get('/', 'UserController@index')->name('index');
		Route::post('/form', 'UserController@form')->name('form');
		Route::post('/store', 'UserController@store')->name('store');
		Route::post('/delete', 'UserController@delete')->name('delete');
		Route::post('/reset/password', 'UserController@reset')->name('reset.password');
		Route::any('/callDtTabls', 'UserController@dataTables')->name('cdt');
	});

	Route::prefix('master')->name('master.')->group(function(){
		Route::prefix('website')->name('website.')->group(function(){
			Route::get('/', 'MasterWebsiteController@index')->name('index');
			Route::post('/form', 'MasterWebsiteController@form')->name('form');
			Route::post('/store', 'MasterWebsiteController@store')->name('store');
			Route::any('/callDtTabls', 'MasterWebsiteController@dataTables')->name('cdt');
		});

		Route::prefix('bank')->name('bank.')->group(function(){
			Route::get('/', 'MasterBankController@index')->name('index');
			Route::post('/form', 'MasterBankController@form')->name('form');
			Route::post('/store', 'MasterBankController@store')->name('store');
			Route::any('/callDtTabls', 'MasterBankController@dataTables')->name('cdt');
		});

		Route::prefix('tier')->name('tier.')->group(function(){
			Route::get('/', 'MasterTierController@index')->name('index');
			Route::post('/form', 'MasterTierController@form')->name('form');
			Route::post('/store', 'MasterTierController@store')->name('store');
			Route::any('/callDtTabls', 'MasterTierController@dataTables')->name('cdt');
		});
	});

	Route::prefix('customer')->name('customer.')->group(function(){
		Route::get('/', 'CustomerController@index')->name('index');
		Route::post('/form', 'CustomerController@form')->name('form');
		Route::post('/store', 'CustomerController@store')->name('store');
		Route::post('/import', 'CustomerController@import')->name('import');
		Route::any('/callDtTabls', 'CustomerController@dataTables')->name('cdt');
	});


	Route::get('sign-out', 'Auth\LoginController@logout')->name('sign.out');
});