<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
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

Route::get('description', [ApiController::class,'getAllDescription']);

Route::post('description', [ApiController::class,'createDescription']);


Route::put('description/{id}', [ApiController::class,'updateDescription']);

Route::delete('descriptiondelete/{id}',[ApiController::class,'deleteDescription']);



Route::get('/', function () {
    return view('welcome');
});

