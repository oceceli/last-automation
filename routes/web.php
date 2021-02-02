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
    return view('web.layouts.welcome'); // !! değişecek
});




Route::middleware('auth')->group(function () {
    #automatic #addAfter
	Route::resource('/units', 'UnitController');
	Route::resource('/categories', 'CategoryController');
    Route::resource('/products', 'ProductController');
    Route::resource('/recipes', 'RecipeController');
    
    Route::get('/work-orders/daily', 'WorkOrderController@daily')->name('work-orders.daily');
    Route::resource('/work-orders', 'WorkOrderController');
    
    Route::resource('/stock-moves', 'StockMoveController');
    Route::resource('/inventory', 'InventoryController');
    Route::resource('/companies', 'CompanyController');
    // Route::resource('/addresses', 'AddressController');

    Route::get('/dispatchorders/daily/{dispatchOrder}/prepare', 'DispatchOrderController@prepare')->name('dispatchorders.prepare');
    Route::get('/dispatchorders/daily', 'DispatchOrderController@daily')->name('dispatchorders.daily');
    Route::resource('/dispatchorders', 'DispatchOrderController');
    
    Route::resource('/roles', 'RoleController');
    
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

});









Route::fallback(function () {
    return response()->json([
        'message' => 'Page not found!',
    ], 404);
});

