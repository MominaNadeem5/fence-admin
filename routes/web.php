<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\WebsiteContentController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Models\ProductCategory;
use App\Models\Product;
// Public homepage

Route::get('/', function () {
    $settings = DB::table('home_page_settings')->first();

    return view('welcome', compact('settings'));
});


// Homepage data

Route::get('/home-data', function () {
    $settings = DB::table('home_page_settings')->first();

    $services = DB::table('home_page_services')
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get();

    $categories = ProductCategory::withCount([
        'products' => function ($query) {
            $query->where('is_active', true);
        }
    ])
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get();
$products = Product::with('category')
    ->where('is_active', true)
    ->latest()
    ->take(8)
    ->get();
    return response()->json([
        'settings' => $settings,
        'services' => $services,
        'categories' => $categories,
        'products' => $products,
    ]);
});


// Admin login
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])
    ->name('admin.login');

Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->middleware('throttle:5,1');

// Admin registration: authenticated admin only
Route::get('/admin/register', [AdminAuthController::class, 'showRegister'])
    ->middleware(['auth', 'admin'])
    ->name('admin.register');

Route::post('/admin/register', [AdminAuthController::class, 'register'])
    ->middleware(['auth', 'admin', 'throttle:5,1']);

// Protected dashboard
Route::get('/admin', [DashboardController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('admin.dashboard');

// Logout
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])
    ->middleware('auth')
    ->name('admin.logout');

// Website content management
Route::get('/admin/website-content', [WebsiteContentController::class, 'edit'])
    ->middleware(['auth', 'admin'])
    ->name('admin.website-content.edit');

Route::put('/admin/website-content', [WebsiteContentController::class, 'update'])
    ->middleware(['auth', 'admin'])
    ->name('admin.website-content.update');


 // Product Categories Management
Route::resource('/admin/categories', ProductCategoryController::class)
    ->except(['show'])
    ->middleware(['auth', 'admin'])
    ->names('admin.categories')
    ->parameters(['categories' => 'category']);

Route::resource('/admin/products', ProductController::class)
    ->except(['show'])
    ->middleware(['auth', 'admin'])
    ->names('admin.products')
    ->parameters(['products' => 'product']);