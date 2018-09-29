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
    return redirect('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth.unique.user');
Route::get('/home/{id}/ligar', 'HomeController@ligar')->name('smartplug.ligar')->middleware('auth.unique.user');
Route::get('/home/{id}/desligar', 'HomeController@desligar')->name('smartplug.desligar')->middleware('auth.unique.user');
Route::get('/home/ligarTodos', 'HomeController@ligarTodos')->name('smartplug.ligartodos')->middleware('auth.unique.user');
Route::get('/home/desligarTodos', 'HomeController@deslTodos')->name('smartplug.deligartodos')->middleware('auth.unique.user');



