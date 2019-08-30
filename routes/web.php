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
})->name('home');

Route::get('/register', function () {
    return view('index');
})->name('register');


Route::get('/reset-password', function () {
    return view('index');
})->name('reset-password');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard')->middleware('auth');

Route::get('/dashboard', 'ContactsController@index')->name('dashboard')->middleware('auth');

Route::post('/login', 'UserController@login');
Route::post('/register', 'UserController@register');
Route::get('/logout', 'UserController@logout');
Route::post('/contact/insert', 'ContactsController@insert');
Route::get('/fetch/contact/{id}', 'ContactsController@fetch');