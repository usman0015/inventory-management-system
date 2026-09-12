<?php

namespace App\Http\Controllers;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {

           // Get total items by category
    // $categories = Item::select('category', DB::raw('count(*) as total'))
    //                   ->groupBy('category')
    //                   ->get();

    // Prepare data for chart
    // $labels = $categories->pluck('category');
    // $data = $categories->pluck('total');

    // return view('dashboard.index', compact('labels', 'data'));






// AI integration


    //  $totalItems = Item::count();
    //     $totalOrders = Order::count();
    //     $completedOrders = Order::where('status', 'completed')->count();

    //     // AI logic: Gather simple data
        $categoryData = Item::select('category', DB::raw('count(*) as total'))
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->groupBy('category')
            ->get();

        $labels = $categoryData->pluck('category')->toArray();
        $data = $categoryData->pluck('total')->toArray();

        // --- Other dashboard stats ---
        $totalItems = Item::count();
        $totalOrders = Order::count();
        $completedOrders = Order::where('status', 'completed')->count();
        $totalStockUnits = Item::sum('quantity');

        // --- Top selling item by item_id (safe) ---
        $topSelling = Order::where('status', 'completed')
            ->selectRaw('item_id, COUNT(*) as total')
            ->groupBy('item_id')
            ->orderByDesc('total')
            ->first();

        $topItemName = $topSelling ? Item::find($topSelling->item_id)?->name : null;

        // --- Low stock items example ---
        $lowStockItems = Item::where('quantity', '<', 5)->pluck('name')->toArray();

        // --- Summary (placeholder AI insight) ---
        $summary = "You have {$totalItems} items and {$totalOrders} orders. ";
        if ($topItemName) {
            $summary .= "Top selling item: {$topItemName}. ";
        }
        if (!empty($lowStockItems)) {
            $summary .= "Low stock: " . implode(', ', $lowStockItems) . ". ";
        }
        $summary .= "Total stock units: {$totalStockUnits}.";

        // --- Send all to view (including labels/data for chart) ---
        return view('dashboard.index', compact(
            'labels','data',
            'totalItems','totalOrders','completedOrders','totalStockUnits','summary'
        ));
    }
}
