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

Route::group(['middleware' => ['auth']], function(){
    /**
     * Admin Controller display pages
     */
    Route::get('/admin/dashboard/display', 'Admin\AdminController@displayDashboard');
    Route::get('/admin/dashboard/add/entity', 'Admin\AdminController@displayAddEntity');
    Route::post('/admin/dashboard/add/entity', 'Admin\AdminController@storeAddEntity');
    Route::get('/admin/dashboard/remove/entity', 'Admin\AdminController@displayRemoveEntity');
    Route::post('/admin/dashboard/remove/entity', 'Admin\AdminController@storeRemoveEntity');
    Route::get('/admin/dashboard/add/permission', 'Admin\AdminController@displayAddPermission');
    Route::post('/admin/dashboard/add/permission', 'Admin\AdminController@storeAddPermission');
    Route::get('/admin/dashboard/remove/permission', 'Admin\AdminController@displayRemovePermission');
    Route::post('/admin/dashboard/remove/permission', 'Admin\AdminController@storeRemovePermission');

    /**
     * Timer Controller display pages
     */
    Route::get('/timer/add', 'Timers\TimerController@displayAddTimer');
    Route::post('timer/add', 'Timers\TimerController@storeAddTimer');
    Route::get('/timer/remove', 'Timers\TimerController@displayRemoveTimer');
    Route::post('/timer/remove', 'Timers\TimerController@storeRemoveTimer');
    Route::get('/timer/modify', 'Timers\TimerController@displayModifyTimer');
    Route::post('/timer/modify', 'Timers\TimerController@storeModifyTimer');
    Route::get('/timer/display', 'Timers\TimerController@displayTimers');
});


/**
 * Login Display pages
 */
Route::get('/login', 'Auth\LoginController@redirectToProvider')->name('login');
Route::get('/callback', 'Auth\LoginController@handleProviderCallback')->name('callback');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');


