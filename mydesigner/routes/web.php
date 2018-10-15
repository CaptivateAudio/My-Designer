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

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/dashboard', 'DashboardController@dashboard')->name('dashboard');

Route::resource('account', 'AccountController')->only([ 'show', 'edit', 'update' ]);

Route::get('/account',  ['as' => 'account.show', 'uses' => 'AccountController@show']);
Route::get('/edit-account',  ['as' => 'account.edit', 'uses' => 'AccountController@edit']);
Route::patch('/update-account',  ['as' => 'account.update', 'uses' => 'AccountController@update']);

