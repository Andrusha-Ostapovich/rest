<?php

use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Models\News;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/','App\Http\Controllers\NewsController@show');

Auth::routes();



Route::post('/home', [NewsController::class, 'store'])->name('news.store');



Route::get('/home', 'App\Http\Controllers\NewsController@showNews')->middleware('auth');
Route::delete('/news/{id}', [NewsController::class, 'destroy'])->name('news.destroy')->middleware('auth');
Route::get('/news/{id}/edit', [NewsController::class, 'edit'])->name('news.edit')->middleware('auth');
Route::put('/news/{id}', [NewsController::class, 'update'])->name('news.update')->middleware('auth');

Route::get('/news/{id}', [NewsController::class, 'shows'])->name('news.show');








