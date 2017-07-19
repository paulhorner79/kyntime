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

Route::group(['middleware' => ['auth']], function () {

    Route::get('timecode', 'Controller@dashboard')->name('timecode');
    Route::post('timecode', 'Controller@setTimecode')->name('timecode');
    Route::post('timecode/clear', 'Controller@clearTimecode')->name('timecode.clear');
    Route::resource('scenes', 'SceneController', ['only' => ['index', 'store', 'update', 'destroy']]);
    Route::resource('sections', 'SectionController', ['only' => ['index', 'store', 'update', 'destroy']]);
    Route::group([
        'as'        => 'sections.',
        'prefix'    => 'sections/{section}'
    ], function () {
        Route::resource('events', 'EventController', ['only' => ['index', 'store', 'update', 'destroy']]);
    });

    Route::get('users', 'Controller@users')->name('users');
    Route::post('users', 'Controller@addUser')->name('users.add');
    Route::delete('users', 'Controller@deleteUser')->name('users.delete');
});

Route::get('/', function () {
    return view('index');
});
Route::get('/home', function () {
    return view('index');
});
Auth::routes();
