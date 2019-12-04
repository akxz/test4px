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

// Получаем доступ к файлам вне папки public
// По-умолчанию /logo/img.jpg -> storage/public/logo/img.jpg
// А нам надо /logo/img.jpg -> storage/app/logo/img.jpg
// Это сработает только для текстовых файлов
// для изображений надо в конфиг nginx добавить строки:
// location ~ ^/logo/(.+\.(?:gif|jpe?g|png))$ {
//    		alias /srv/www/PROJECTNAME/storage/app/logo/$1;
//	}
Route::get('logo/{file}', function ($file) {
    $path = storage_path('app' . DIRECTORY_SEPARATOR . 'logo' . DIRECTORY_SEPARATOR . $file);
    return response()->file($path);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/users', 'UserController@index')->name('user');
Route::get('/user/create', 'UserController@create');
Route::get('/user/edit/{id}', 'UserController@edit');
Route::post('/user/store', 'UserController@store');
Route::post('/user/update/{id}', 'UserController@update');
Route::delete('/user/destroy/{id}', 'UserController@destroy');

Route::get('/sections', 'SectionController@index')->name('section');
Route::get('/section/create', 'SectionController@create');
Route::get('/section/edit/{id}', 'SectionController@edit');
Route::post('/section/store', 'SectionController@store');
Route::post('/section/update/{id}', 'SectionController@update');
Route::delete('/section/destroy/{id}', 'SectionController@destroy');
