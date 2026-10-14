<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('dashboard', [
            'totalProducts' => Product::count(),
            'totalCategories' => Category::count(),
            'totalSuppliers' => Supplier::count(),
            'totalValue' => Product::selectRaw('COALESCE(SUM(price * stock), 0) as v')->value('v'),
            'lowStock' => Product::with('category')->whereColumn('stock', '<=', 'min_stock')->orderBy('stock')->get(),
        ]);
    }
}
