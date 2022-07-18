<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

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
Route::get('/user/messages', 'App\Http\Controllers\MessageController@UserMessages')->middleware(['auth'])->name('user.messages');
Route::resource('message', MessageController::class)->middleware(['auth']);

require __DIR__.'/auth.php';
