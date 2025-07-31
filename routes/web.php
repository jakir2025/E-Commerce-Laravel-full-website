<?php

use App\Http\Controllers\Backend\AdminAuthController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\FrontendController;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use League\CommonMark\Extension\FrontMatter\FrontMatterParser;

// Route::get('/', function () {
//     return view('welcome'); 
// });

Route::get('/', [FrontendController::class, 'index']);
Route::get('/shop', [FrontendController::class, 'shopProducts']);
Route::get('/return-process', [FrontendController::class, 'returnProcess']);
Route::get('/product-details/{slug}', [FrontendController::class, 'productDetails']);
Route::get('/type-products/{type}', [FrontendController::class, 'typeProducts']);
Route::get('/view-cart-products', [FrontendController::class, 'viewCart']);
Route::get('/checkout', [FrontendController::class, 'checkOut']);

//Policy Routes

Route::get('/privacy-policy', [FrontendController::class, 'privacyPolicy']);
Route::get('/terms-condition', [FrontendController::class, 'termsCondition']);
Route::get('/refund-policy', [FrontendController::class, 'refundPolicy']);
Route::get('/payment-policy', [FrontendController::class, 'paymentPolicy']);
Route::get('/about-us', [FrontendController::class, 'aboutUs']);

//admin auth routes
Route::get('/admin/login', [AdminAuthController::class, 'loginForm']);
Route::get('/admin/logout', [AdminAuthController::class, 'logoutAdmin']);


Auth::routes();
Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');


//Category Routes
Route::get('/admin/category/create', [CategoryController::class, 'categoryCreate']);
Route::post('/admin/category/store', [CategoryController::class, 'categoryStore']);
Route::get('/admin/category/list', [CategoryController::class, 'categoryList']);
Route::get('/admin/category/delete/{id}', [CategoryController::class, 'categoryDelete']);
Route::get('/admin/category/edit/{id}', [CategoryController::class, 'categoryEdit']);
Route::post('/admin/category/update/{id}', [CategoryController::class, 'categoryUpdate']);


//SubCategory Routes
Route::get('/admin/sub-category/create', [SubCategoryController::class, 'subCategoryCreate']);
Route::post('/admin/sub-category/store', [SubCategoryController::class, 'subCategoryStore']);
Route::get('/admin/sub-category/list', [SubCategoryController::class, 'subCategoryList']);
Route::get('/admin/sub-category/delete/{id}', [SubCategoryController::class, 'subCategoryDelete']);
Route::get('/admin/sub-category/edit/{id}', [SubCategoryController::class, 'subCategoryEdit']);
Route::post('/admin/sub-category/update/{id}', [SubCategoryController::class, 'subCategoryUpdate']);

//product routes
Route::get('/admin/product/create', [ProductController::class, 'productCreate']);
Route::post('/admin/product/store', [ProductController::class, 'productStore']);
Route::get('/admin/product/list', [ProductController::class, 'productList']);
Route::get('/admin/product/delete/{id}', [ProductController::class, 'productDelete']);
Route::get('/admin/product/edit/{id}', [ProductController::class, 'productEdit']);
Route::post('/admin/product/update/{id}', [ProductController::class, 'productUpdate']);

Route::get('/admin/product/color/delete/{id}', [ProductController::class, 'colorDelete']);
Route::get('/admin/product/size/delete/{id}', [ProductController::class, 'sizeDelete']);
Route::get('/admin/product/gallery-image/delete/{id}', [ProductController::class, 'galleryImageDelete']);
Route::get('/admin/product/gallery-image/edit/{id}', [ProductController::class, 'galleryImageEdit']);
Route::post('/admin/product/gallery-image/update/{id}', [ProductController::class, 'galleryImageUpdate']);

