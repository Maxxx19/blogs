<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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

Route::get('/home', [App\Http\Controllers\BlogController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {

    Route::get('blog/create', [App\Http\Controllers\BlogController::class, 'create']);
    Route::get('blog/restoreArticles', [App\Http\Controllers\BlogController::class, 'restoreArticles']);
    Route::post('blog', [App\Http\Controllers\BlogController::class, 'store']);
    Route::get('blog/{blog}/edit', [App\Http\Controllers\BlogController::class, 'edit'])->name('blogs.edit');;
    Route::get('blog/{blog}', [App\Http\Controllers\BlogController::class, 'show']);
    Route::put('blog/{blog}', [App\Http\Controllers\BlogController::class, 'update'])->name('blog.update');
    Route::delete('blog/{blog}', [App\Http\Controllers\BlogController::class, 'destroy']);
    Route::get('getBlog/{blog}', [App\Http\Controllers\BlogController::class, 'getBlog']);

    Route::resource('article', App\Http\Controllers\ArticleController::class);  

});