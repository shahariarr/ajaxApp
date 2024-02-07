<?php

use App\Http\Controllers\UserController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::resource('/user', 'App\Http\Controllers\UserController');
Route::view('/userProfile','user');


Route::post("/userdelete",[UserController::class,'UserDelete']);
Route::post("/user-by-id",[UserController::class,'UserByID']);
Route::post("/update-user",[UserController::class,'userUpdate']);

