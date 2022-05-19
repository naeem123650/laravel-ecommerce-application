<?php

use App\Http\Controllers\Admin\Attribute\AttributeController;
use App\Http\Controllers\Admin\Attribute\AttributeValueController;
use App\Http\Controllers\Admin\Brand\BrandController;
use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\Product\ProductAttributeController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\Product\ProductImageController;
use App\Http\Controllers\Admin\Setting\SettingController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'],function(){

    Route::get('/login',[LoginController::class,'showLoginForm'])->name('admin.login');

    Route::post('/login',[LoginController::class,'login'])->name('admin.login.post');

    Route::get('/logout',[LoginController::class,'logout'])->name('admin.logout');

    Route::group(['middleware' => 'auth:admin'],function(){

        Route::get('/dashboard',function(){
            return view('admin.dashboard.index');
        })->name('admin.dashboard');

        Route::get('/settings',[SettingController::class,'index'])->name('admin.settings');

        Route::post('/settings',[SettingController::class,'update'])->name('admin.settings.update');

        Route::group(['prefix' => 'categories'],function(){
            Route::get('/',[CategoryController::class,'index'])->name('admin.categories.index');
            Route::get('/create',[CategoryController::class,'create'])->name('admin.categories.create');
            Route::post('/store',[CategoryController::class,'store'])->name('admin.categories.store');
            Route::get('/{id}/edit',[CategoryController::class,'edit'])->name('admin.categories.edit');
            Route::post('/update',[CategoryController::class,'update'])->name('admin.categories.update');
            Route::get('/{id}/delete',[CategoryController::class,'delete'])->name('admin.categories.delete');
            Route::get('/status/update',[CategoryController::class,'updateStatus'])->name('admin.categories.updateStatus');
        });

        Route::group(['prefix' => 'attributes'],function(){
            Route::get('/',[AttributeController::class,'index'])->name('admin.attributes.index');
            Route::get('/create',[AttributeController::class,'create'])->name('admin.attributes.create');
            Route::post('/store',[AttributeController::class,'store'])->name('admin.attributes.store');
            Route::get('/{id}/edit',[AttributeController::class,'edit'])->name('admin.attributes.edit');
            Route::put('/update',[AttributeController::class,'update'])->name('admin.attributes.update');
            Route::get('/{id}/delete',[AttributeController::class,'delete'])->name('admin.attributes.delete');

            Route::post('attribute/{id}/store',[AttributeValueController::class,'store'])->name('admin.attributevalue.store');
            Route::get('attribute/{id}/edit',[AttributeValueController::class,'edit'])->name('admin.attributevalue.edit');
            Route::post('attribute/{id}/update',[AttributeValueController::class,'update'])->name('admin.attributevalue.update');
            Route::get('attribute/{id}/delete',[AttributeValueController::class,'delete'])->name('admin.attributevalue.delete');
        });

        Route::group(['prefix' => 'brands'],function(){
            Route::get('/',[BrandController::class,'index'])->name('admin.brands.index');
            Route::get('/create',[BrandController::class,'create'])->name('admin.brands.create');
            Route::post('/store',[BrandController::class,'store'])->name('admin.brands.store');
            Route::get('/{id}/edit',[BrandController::class,'edit'])->name('admin.brands.edit');
            Route::put('/update',[BrandController::class,'update'])->name('admin.brands.update');
            Route::get('/{id}/delete',[BrandController::class,'delete'])->name('admin.brands.delete');
        });

        Route::group(["prefix" => "products"],function(){
            Route::get('/',[ProductController::class,'index'])->name("admin.products.index");
            Route::get('/create',[ProductController::class,'create'])->name("admin.products.create");
            Route::post('/store',[ProductController::class,'store'])->name("admin.products.store");
            Route::get('/{id}/edit',[ProductController::class,'edit'])->name("admin.products.edit");
            Route::put('/update',[ProductController::class,'update'])->name("admin.products.update");
            Route::get('/{id}/delete',[ProductController::class,'delete'])->name("admin.products.delete");

            Route::post("images/upload",[ProductImageController::class,'upload'])->name("admin.products.images.upload");
            Route::get('/images/{id}/delete',[ProductImageController::class,'delete'])->name("admin.products.images.delete");

            // Load attributes on the page load from attributes table
            //eg. size and color.
            Route::get('attributes/load',[ProductAttributeController::class,'loadAttributes']);

            // Load product attributes on the page load
            //Route::post('attributes', 'Admin\ProductAttributeController@productAttributes');
            Route::post("attributes",[ProductAttributeController::class,'productAttributes']);


            // Load option values for a attribute
            //Route::post('attributes/values', 'Admin\ProductAttributeController@loadValues');
            Route::post('attributes/values',[ProductAttributeController::class,'loadValues']);

            // Add product attribute to the current product
            //Route::post('attributes/add', 'Admin\ProductAttributeController@addAttribute');
            Route::post("attributes/add",[ProductAttributeController::class,'addAttribute']);

            // Delete product attribute from the current product
            //Route::post('attributes/delete', 'Admin\ProductAttributeController@deleteAttribute');
            Route::post("attributes/delete",[ProductAttributeController::class,'deleteAttribute']);

        });
    });
});
