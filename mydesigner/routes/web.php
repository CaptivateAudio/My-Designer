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

/* User and Designer Routes */
Route::get('/packages',  ['as' => 'user.packages.list', 'uses' => 'DesignController@packages']);
Route::get('/designs/request/{design_id}',  ['as' => 'user.designs.requests.view', 'uses' => 'DesignController@view_design_request']);

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

Route::get('/designs/new/{package_id}',  ['as' => 'user.request.design', 'uses' => 'DesignController@design_request']);
Route::resource('design',  'DesignController')->only([ 'store' ]);
Route::get('/designs/requests',  ['as' => 'user.designs.requests', 'uses' => 'DesignController@list_design_request']);

/**
 * Designer Routes
 */
Route::get('/packages/designs/requests/{package_id}',  ['as' => 'designer.team.designs.requests', 'uses' => 'DesignController@team_design_request']);
Route::put('/design/request/assign/{design_id}',  ['as' => 'designer.assign.designs.request', 'uses' => 'DesignController@assign_design_request']);

//Route::get('/designs/requests/request',  ['as' => 'designer.team.designs.requests', 'uses' => 'DesignController@team_design_request']);
