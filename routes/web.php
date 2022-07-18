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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/wall', 'App\Http\Controllers\MessageController@index')->middleware(['auth'])->name('wall');
Route::resource('message', MessageController::class)->middleware(['auth']);

require __DIR__.'/auth.php';
