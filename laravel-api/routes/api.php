<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* 

API Routes 

Here is where you can register API routes for your application. These 
routes are loaded by the RouteServiceProvider within a group which 
is assigned the "api" middleware group. Enjoy building your API!

*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// api/v1
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function() {
    Route::apiResource('customers', CustomerController::class); // here we are using the apiResource method to create a resourceful route for the customers endpoint
    Route::apiResource('invoices', InvoiceController::class); // here we are using the apiResource method to create a resourceful route for the invoices endpoint

    Route::post('invoices/bulk', ['uses' => 'InvoiceController@bulkStore']); // here we are creating a custom route for bulk storing invoices
});