<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Condition; // Import the Condition model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Authenticate and get the user
        $user = Auth::user();

        // ----------------------------------------------------
        // 2. Calculate Statistics for Dashboard Cards (FIXED)
        // ----------------------------------------------------
        
        // Total items is the number of distinct records in the table.
        $totalItemRecords = Item::count();
        
        // "Items In Stock" is now the sum of the 'quantity' column for all items.
        $itemsInStock = Item::sum('quantity');
        
        // Since there is no 'status' column, 'Items Out' is conceptually 0 for now.
        $itemsOutStock = 0;
        
        // Total value is not in your current migration, so we'll default to 0.
        $totalAssetValue = 0;

        $stats = [
            'total_items' => number_format($totalItemRecords), 
            'items_in'    => number_format($itemsInStock),
            'items_out'   => number_format($itemsOutStock),
            'total_value' => $totalAssetValue, 
        ];

        // ----------------------------------------------------
        // 3. Prepare Data for the Chart (FIXED)
        // ----------------------------------------------------
        
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $months[] = now()->subMonths($i)->format('M Y'); 
        }

        $sixMonthsAgo = now()->subMonths(6);

        // Fetch counts for all new items created in the last 6 months
        $itemsInQuery = Item::select(
                DB::raw('MONTH(created_at) as month_num'), 
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', $sixMonthsAgo)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'month_num')
            ->toArray();

        // Find the ID for the 'Damaged' condition from the conditions table
        $damagedConditionId = Condition::where('condition_name', 'Damaged')->value('id');

        // Fetch counts for 'Damaged' items created in the last 6 months using condition_id
        $damagedQuery = Item::select(
                DB::raw('MONTH(created_at) as month_num'), 
                DB::raw('COUNT(*) as total')
            )
            ->where('condition_id', $damagedConditionId)
            ->where('created_at', '>=', $sixMonthsAgo)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'month_num')
            ->toArray();

        $chartData = [
            'months'   => $months,
            'items_in' => [],
            'damaged'  => [],
        ];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthIndex = $date->month;
            
            $chartData['items_in'][] = $itemsInQuery[$monthIndex] ?? 0;
            $chartData['damaged'][]  = $damagedQuery[$monthIndex] ?? 0;
        }

        // Return the view with all required data
        return view('dashboard', [
            'user'  => $user,
            'stats' => $stats,
            'chart' => $chartData,
        ]);
    }
}

