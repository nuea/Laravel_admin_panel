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

Route::match(array('GET', 'POST'),'/admin','AdminController@login');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', 'AdminController@logout');

Route::group(['middleware' => ['auth']],function(){
    //Move route admin/dashboard in here.
    Route::get('/admin/dashboard','AdminController@dashboard');
    Route::get('/admin/settings','AdminController@settings'); 
    Route::get('/admin/check-pwd','AdminController@chkPassword');
    
    Route::match(['get','post'],'/admin/update-pwd','AdminController@updatePassword');

    // Categories Routes(Admin)
    Route::match(['get','post'],'/admin/add-category','CategoryController@addCategory');
    Route::get('/admin/view-categories','CategoryController@viewCategories'); 
});