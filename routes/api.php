<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnquiryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/enquiries', [EnquiryController::class, 'index']);
Route::post('/enquiries', [EnquiryController::class, 'store']);
Route::patch('/enquiries/{enquiry}/status', [EnquiryController::class, 'updateStatus']);