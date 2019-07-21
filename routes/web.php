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
    return view('welcome');
});

Auth::routes();

//Current User Home
Route::get('/home', 'HomeController@home')->name('home')->middleware('auth');

//Profile Related Routes
Route::get('/u/{user}', 'ProfilesController@view')->name('profile.show');
Route::get('u/{id}/edit', 'ProfilesController@edit')->name('profile.edit')->middleware('auth');
Route::put('u/{id}', 'ProfilesController@update')->name('profile.update')->middleware('auth');

//Post Related Routes. Authenticated Only
Route::get('/p/{post}', 'PostsController@view');
Route::get('/p', 'PostsController@create')->middleware('auth');
Route::post('/p', 'PostsController@store')->middleware('auth');
Route::delete('/p/{post}', 'PostsController@delete')->middleware('auth');

//Comment Related Routes. Authenticated Only
Route::post('/p/{post}', 'PostsController@store')->middleware('auth');
