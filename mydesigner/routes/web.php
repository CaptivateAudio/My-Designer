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

/**
 * Global Routes
 */

Route::get('/dashboard', 'DashboardController@dashboard')->name('dashboard');

Route::resource('account', 'AccountController')->only([ 'show', 'edit', 'update' ]);

Route::get('/account',  ['as' => 'account.show', 'uses' => 'AccountController@show']);
Route::get('/edit-account',  ['as' => 'account.edit', 'uses' => 'AccountController@edit']);
Route::patch('/update-account',  ['as' => 'account.update', 'uses' => 'AccountController@update']);

/**
 * Admin Routes
 */

Route::namespace('Admin')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('users', 'UserController');
        Route::resource('teams', 'TeamController');
        Route::resource('packages', 'PackageController');
	});

Route::get('/admin/user/{id}/styles',  ['as' => 'admin.users.styles', 'uses' => 'Style\StyleController@admin_view']);

/**
 * User Routes
 */
Route::namespace('Style')
    ->prefix('style')
    ->name('style.')
    ->group(function () {
        Route::resource('settings', 'StyleController');
	});