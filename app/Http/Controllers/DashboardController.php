<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\StockMovement;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $metrics = [
            'items' => Item::count(),
            'categories' => Category::count(),
            'stock' => Item::sum('stock'),
            'lowStock' => Item::lowStock()->count(),
        ];
        $lowStockItems = Item::with('category')->lowStock()->orderBy('stock')->limit(6)->get();
        $recentMovements = StockMovement::with('item')->latest('moved_at')->latest('id')->limit(8)->get();

        return view('dashboard', compact('metrics', 'lowStockItems', 'recentMovements'));
    }
}
