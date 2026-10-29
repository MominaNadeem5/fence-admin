<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'categories' => ProductCategory::count(),
            'active_categories' => ProductCategory::where('is_active', true)->count(),
            'services' => DB::table('home_page_services')->where('is_active', true)->count(),
            'admins' => User::where('is_admin', true)->count(),
        ];

        $recentProducts = Product::with('category')->latest()->take(5)->get();

        $uncategorizedCount = Product::whereNull('category_id')->count();

        return view('admin.dashboard', compact('stats', 'recentProducts', 'uncategorizedCount'));
    }
}
