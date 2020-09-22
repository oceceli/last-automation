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

Route::get('/deneme', function () {
    return view('deneme');
}); 



Route::middleware('auth')->group(function () {
    #automatic #addAfter
    Route::resource('/products', 'ProductController');


});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');






Route::fallback(function () {
    return response()->json([
        'message' => 'Page not found!',
    ], 404);
});

