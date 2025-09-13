<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Summary stats
        $totalItems = Item::count();
        $itemsIn    = Item::where('status', 'in')->count();
        $itemsOut   = Item::where('status', 'out')->count();
        $totalValue = Item::sum('value');

        $stats = [
            'total_items' => $totalItems,
            'items_in'    => $itemsIn,
            'items_out'   => $itemsOut,
            'total_value' => $totalValue,
        ];

        // Chart data: jumlah items_in & damaged per bulan (1..12)
        $itemsInByMonth = Item::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->where('status', 'in')
            ->groupBy('month')
            ->pluck('total', 'month'); // keyed by month number

        $damagedByMonth = Item::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->where('condition', 'damaged')
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthsLabels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $itemsInData  = [];
        $damagedData  = [];

        for ($m = 1; $m <= 12; $m++) {
            $itemsInData[] = isset($itemsInByMonth[$m]) ? (int)$itemsInByMonth[$m] : 0;
            $damagedData[] = isset($damagedByMonth[$m]) ? (int)$damagedByMonth[$m] : 0;
        }

        // Build chart array exactly as view expects
        $chart = [
            'months'  => $monthsLabels,
            'items_in'=> $itemsInData,
            'damaged' => $damagedData,
        ];

        return view('dashboard', compact('user', 'stats', 'chart'));
    }
}
