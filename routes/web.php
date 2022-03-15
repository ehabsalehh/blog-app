<?php
use App\Http\controllers\PagesController;
use App\Http\controllers\PostsController;
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
Route::get('/', [PagesController::class,'index']);
Route::get('/services', [PagesController::class,'services']);
Route::get('/about', [PagesController::class,'about']);
Route::Resource("/posts",PostsController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
