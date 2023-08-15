<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('/generate-random-password', 'RandomPasswordController@generateRandomPassword');
    Route::get('/generate-random-password/checkUser', 'RandomPasswordController@getUserCode');
    Route::get('/generate-random-password/deleteUser', 'RandomPasswordController@deleteUserCode');
    Route::get('/generate-random-password/resetCode', 'RandomPasswordController@resetUserCode');
    Route::get('/generate-random-password/checkCode', 'RandomPasswordController@checkCode');



});