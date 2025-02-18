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

// api/V1 routes
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function () {
    Route::apiResource('customers', 'CustomerController::class');
    Route::apiResource('invoices', 'InvoiceController::class');
});