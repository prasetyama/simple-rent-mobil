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

Route::group(['namespace' => 'App\Http\Controllers'], function()
{   
    /**
     * Home Routes
     */
    Route::get('/', 'HomeController@index')->name('home.index');

    Route::group(['middleware' => ['guest']], function() {
        /**
         * Register Routes
         */
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');

        /**
         * Login Routes
         */
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');

    });

    Route::group(['prefix' => 'kendaraan'], function() {
        Route::get('/', 'KendaraanController@index')->name('kendaraan.index');
    });

    Route::group(['middleware' => ['auth', 'permission']], function() {
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');

        /**
         * User Routes
         */
        Route::group(['prefix' => 'users'], function() {
            Route::get('/', 'UsersController@index')->name('users.index');
            Route::get('/create', 'UsersController@create')->name('users.create');
            Route::post('/create', 'UsersController@store')->name('users.store');
            Route::get('/{user}/show', 'UsersController@show')->name('users.show');
            Route::get('/{user}/edit', 'UsersController@edit')->name('users.edit');
            Route::patch('/{user}/update', 'UsersController@update')->name('users.update');
            Route::delete('/{user}/delete', 'UsersController@destroy')->name('users.destroy');
        });

        Route::group(['prefix' => 'kendaraan'], function() {
            Route::get('/', 'KendaraanController@index')->name('kendaraan.index');
            Route::get('/create', 'KendaraanController@create')->name('kendaraan.create');
            Route::post('/create', 'KendaraanController@store')->name('kendaraan.store');
            Route::get('/{kendaraan}/show', 'KendaraanController@show')->name('kendaraan.show');
            Route::get('/{kendaraan}/edit', 'KendaraanController@edit')->name('kendaraan.edit');
            Route::patch('/{kendaraan}/update', 'KendaraanController@update')->name('kendaraan.update');
            Route::delete('/{kendaraan}/delete', 'KendaraanController@destroy')->name('kendaraan.destroy');

            Route::get('/{kendaraan}/book', 'KendaraanController@book')->name('kendaraan.book');
            Route::post('/{kendaraan}/book/process', 'KendaraanController@bookProcess')->name('kendaraan.bookProcess');

            Route::get('/my-booking', 'KendaraanController@myBooking')->name('kendaraan.myBooking');
            Route::patch('/{booking}/return', 'KendaraanController@return')->name('kendaraan.return');
        });

        Route::resource('roles', RolesController::class);
        Route::resource('permissions', PermissionsController::class);
    });
});
