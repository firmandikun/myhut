<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\Store;
use App\Models\Operation;
use App\Models\OperationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
   public function index(Request $request)
{
    $storeId = $request->store_id;

    $today = Carbon::today();
    $startOfWeek = Carbon::now()->startOfWeek();
    $startOfMonth = Carbon::now()->startOfMonth();

    $query = Transaction::query();

    if ($storeId) {
        $query->where('store_id', $storeId);
    }

    // Hitung total pendapatan untuk setiap periode
    $todayRevenue = (clone $query)->whereDate('date_sale', $today)->sum('total_price');
    $weekRevenue = (clone $query)->whereBetween('date_sale', [$startOfWeek, now()])->sum('total_price');
    $monthRevenue = (clone $query)->whereBetween('date_sale', [$startOfMonth, now()])->sum('total_price');

    // Hitung biaya admin
    $adminPercentage = 0;
    $adminCategory = OperationCategory::where('name', 'Biaya Admin')->first();

    if ($adminCategory) {
        $adminOperation = $adminCategory->operations()->first();
        if ($adminOperation && $adminOperation->cost) {
            if (strtolower($adminOperation->description) === 'persen') {
                $adminPercentage = (float) $adminOperation->cost;
            }
        }
    }

    // Hitung pendapatan bersih setelah dipotong biaya admin
    $summary = [
        'today' => [
            'total_quantity' => (clone $query)->whereDate('date_sale', $today)->sum('quantity'),
            'total_price'    => $todayRevenue,
            'net_revenue'     => $todayRevenue * (1 - ($adminPercentage / 100)),
            'admin_cost'     => $todayRevenue * ($adminPercentage / 100),
        ],
        'this_week' => [
            'total_quantity' => (clone $query)->whereBetween('date_sale', [$startOfWeek, now()])->sum('quantity'),
            'total_price'    => $weekRevenue,
            'net_revenue'     => $weekRevenue * (1 - ($adminPercentage / 100)),
            'admin_cost'     => $weekRevenue * ($adminPercentage / 100),
        ],
        'this_month' => [
            'total_quantity' => (clone $query)->whereBetween('date_sale', [$startOfMonth, now()])->sum('quantity'),
            'total_price'    => $monthRevenue,
            'net_revenue'     => $monthRevenue * (1 - ($adminPercentage / 100)),
            'admin_cost'     => $monthRevenue * ($adminPercentage / 100),
        ]
    ];

    $stats = $summary;

    $lowStockProducts = Product::where('stock', '<=', 100)
        ->take(10)
        ->get();

    $topProducts = DB::table('transactions')
        ->join('products', 'transactions.product_id', '=', 'products.id')
        ->select(
            'products.id',
            'products.name as product_name',
            DB::raw('SUM(transactions.quantity) as total_sold'),
            DB::raw('SUM(transactions.total_price) as total_price')
        )
        ->groupBy('products.id', 'products.name')
        ->orderByDesc('total_sold')
        ->take(5)
        ->limit(5)
        ->get();

    $operations = Operation::with('category')->get();
    $operations = Operation::all();
    $totalProducts = Product::count();
    $stores = Store::all();
    $totalAsset = Product::select(DB::raw('SUM(stock * price) as total_asset'))->value('total_asset');
    $potentialRevenue = Product::select(DB::raw('SUM(stock * sale_price) as total'))->value('total');

    // Hitung untuk potential revenue juga
    $adminCost = $potentialRevenue * ($adminPercentage / 100);
    $netRevenue = $potentialRevenue - $adminCost;

    return view('dashboard.index', compact(
        'stats',
        'lowStockProducts',
        'topProducts',
        'stores',
        'storeId',
        'operations',
        'totalProducts',
        'totalAsset',
        'netRevenue',
        'adminPercentage'
    ));
}
}
