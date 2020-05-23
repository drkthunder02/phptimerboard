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

/**
 * Unsecure Display pages
 */
Route::get('/', 'Hauling\HaulingController@displayForm')->name('/');
Route::post('/', 'Hauling\HaulingController@displayFormResults');
Route::get('/display/quotes', 'Hauling\HaulingController@displayQuotes')->name('quotes');

Route::group(['middleware' => ['auth']], function(){
    /**
     * Dashboard Controller Display pages
     */
    Route::get('/dashboard', 'Dashboard\DashboardController@index')->name('/dashboard');
    //Route::get('/profile', 'Dashboard\DashboardController@profile');

    /**
     * Scopes Controller display pages
     */
    Route::get('/scopes/select', 'Auth\EsiScopeController@displayScopes');
    Route::post('redirectToProvider', 'Auth\EsiScopeController@redirectToProvider');
    
});
/*
Route::group(['middleware' => ['guest']], function() {

});
*/

/**
 * Login Display pages
 */
Route::get('/login', 'Auth\LoginController@redirectToProvider')->name('login');
Route::get('/callback', 'Auth\LoginController@handleProviderCallback')->name('callback');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');


