<?php

use App\Http\Controllers\backend\AdminController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\frontend\HomeController;
use Illuminate\Support\Facades\Route;


 
Route::get('/',[HomeController::class,'Home']);
Route::get('/product/{slug}',      [HomeController::class, 'Product']);
Route::post('/add-cart',         [HomeController::class, 'AddCart']);
Route::get('/cart-item',         [HomeController::class, 'CartItem']);
Route::get('/check-out',         [HomeController::class, 'checkOut']);
Route::post('/place-order',         [HomeController::class, 'placeOrder']);
Route::get('/recipt',         [HomeController::class, 'recipt']);
Route::get('/my-order',         [HomeController::class, 'myOrder']);
Route::get('/view-order/{id}',         [HomeController::class, 'viewOrder']);

// Sign-in
Route::get('/signin',[UserController::class,'Signin'])->name('login');
Route::post('/signin-submit',[UserController::class,'SigninSubmit']);

Route::get('/signup',[UserController::class,'Signup']);
Route::post('/signup-submit',[UserController::class,'SignupSubmit']);
Route::get('/logout/{id}',[HomeController::class,'Logout']);

Route::middleware(['admin'])->group(function(){
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/admin/signout',[AdminController::class,'signOut']);


    //Category
    Route::get('/admin/add-category',[CategoryController::class,'AddCate']);
    Route::post('/admin/add-category-submit',[CategoryController::class,'AddCateSub']);
    Route::get('/admin/list-category',           [CategoryController::class, 'listCategory']);


    ///Product
    Route::get('/admin/add-product',[ProductController::class,'AddProduct']);
    Route::post('/admin/add-product-submit',[ProductController::class,'addProductSubmit']);
    Route::get('/admin/list-product/',[ProductController::class,'listProduct']);

    //Logo
    Route::get('/admin/add-logo',               [AdminController::class, 'addLogo']);
    Route::post('/admin/add-logo-submit',       [AdminController::class, 'addLogoSubmit']);
    Route::get('/admin/list-logo',              [AdminController::class, 'listLogo']);
    Route::get('/admin/update-logo/{id}',       [AdminController::class, 'updateLogo']);
    Route::post('/admin/update-logo-submit',    [AdminController::class, 'updateLogoSubmit']);
    Route::post('/admin/remove-logo-submit',    [AdminController::class, 'removeLogoSubmit']);

});

