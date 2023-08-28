<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

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
/*
* onther way if you only to display
*/
// Route::view("/home","home");

// Route ::get("/user",function( Request $request){
//     return response("my name is :".$request->name." and my last name is : ".$request->last);
// });

// list listing 
Route::get('/',[ListingController::class,'index'])->name('login');


// create listing 
Route::get('/listing/create',[ListingController::class,'create'])->middleware("auth");

//store listing 
Route::post('/listing/store',[ListingController::class,'store'])->middleware("auth");

// show edite form

Route::get('/listing/{listing}/edit',[ListingController::class,'edit'])->middleware("auth");

// Edit submit to update

Route::put('/listing/{listing}',[ListingController::class,'update'])->middleware("auth");

//delete Listing
Route::delete('/listing/{listing}',[ListingController::class,'destroy'])->middleware("auth");
//manage listings 
Route::get('/listing/manage',[ListingController::class,'manage'])->middleware("auth");

// make sure that this rout at bottum  because he will think that this /listing/create is in this :/listing/{listing} 
//route get find list 

Route::get('/listing/{listing}',[ListingController::class,'show']);

// User Registration 
Route::get('/register',[UserController::class,'create'])->middleware("guest");

Route::post('/users',[UserController::class,'store'])->middleware("guest");
Route::post('/logout',[UserController::class,'logout'])->middleware("auth");
// show login form
Route::get('/login',[UserController::class,'login'])->middleware("guest");
Route::post('/users/authenticate',[UserController::class,'authenticate']);





