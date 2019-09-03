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
    return view('index');
})->name('home')->middleware('guest');

Route::get('/register', function () {
    return view('index');
})->name('register')->middleware('guest');


Route::get('/reset-password', function () {
    return view('index');
})->name('reset-password');

Route::get('/dashboard', 'ContactsController@index')->name('dashboard')->middleware('auth');

Route::post('/login', 'UserController@login');
Route::post('/register', 'UserController@register');
Route::get('/logout', 'UserController@logout');
Route::post('/contact/insert', 'ContactsController@insert');
Route::get('/fetch/count/{id}', 'ContactsController@fetch');
Route::get('/fetch/view/history/{id}', 'ContactsController@view_history');

Route::get('/faker_data', 'DemoDataController@index')->middleware('auth');
Route::get('/faker_view_data', 'DemoDataController@views')->middleware('auth');