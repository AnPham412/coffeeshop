<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

// Category 
Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
Route::get('/admin/category/add', [AdminController::class, 'category_add'])->name('admin.category.add');
Route::post('/admin/category/store', [AdminController::class, 'category_store'])->name('admin.category.store');
Route::get('/admin/category/{id}/edit', [AdminController::class, 'category_edit'])->name('admin.category.edit');
Route::put('/admin/category/update',[AdminController::class,'category_update'])->name('admin.category.update');
Route::delete( '/admin/category/{id}/delete', [AdminController::class, 'category_delete'])->name('admin.category.delete');


// Brand route
Route::get('/admin/brands', [AdminController::class, 'brands'])->name('admin.brands');
Route::get('/admin/brand/add', [AdminController::class, 'add_brand'])->name('admin.brand.add');
Route::post('/admin/brand/store', [AdminController::class, 'brand_store'])->name('admin.brand.store');
Route::get('/admin/brand/edit/{id}', [AdminController::class, 'brand_edit'])->name('admin.brand.edit');
Route::put('/admin/brand/update',[AdminController::class,'brand_update'])->name('admin.brand.update');
Route::delete( '/admin/brand/{id}/delete', [AdminController::class, 'brand_delete'])->name('admin.brand.delete');


//Product
Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
Route::get('/admin/product/add', [AdminController::class, 'product_add'])->name('admin.product.add');
Route::post('/admin/product/store',[AdminController::class,'product_store'])->name('admin.product.store');
Route::get('/admin/product/edit/{id}',[AdminController::class,'product_edit'])->name('admin.product.edit');
Route::put('/admin/product/update',[AdminController::class,'product_update'])->name('admin.product.update');
Route::delete( '/admin/product/{id}/delete', [AdminController::class,'product_delete'])->name('admin.product.delete');


//Shop
Route::get('/shop',[ShopController::class,'index'])->name('shop.index');
Route::get('/shop/{product_slug}',[ShopController::class,'product_detail'])->name('shop.product.detail');


//Cart
Route::get('/cart',[CartController::class,'index'])->name('cart.index');
Route::post('cart/add',[CartController::class,'add_to_cart'])->name('cart.add');

