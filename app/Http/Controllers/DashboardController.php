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

        $summary = [
            'today' => [
                'total_quantity' => (clone $query)->whereDate('date_sale', $today)->sum('quantity'),
                'total_price'    => (clone $query)->whereDate('date_sale', $today)->sum('total_price'),
            ],
            'this_week' => [
                'total_quantity' => (clone $query)->whereBetween('date_sale', [$startOfWeek, now()])->sum('quantity'),
                'total_price'    => (clone $query)->whereBetween('date_sale', [$startOfWeek, now()])->sum('total_price'),
            ],
            'this_month' => [
                'total_quantity' => (clone $query)->whereBetween('date_sale', [$startOfMonth, now()])->sum('quantity'),
                'total_price'    => (clone $query)->whereBetween('date_sale', [$startOfMonth, now()])->sum('total_price'),
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



        // Ambil data operasional
        $operations = Operation::with('category')->get();

        // Kelompokkan data operasional berdasarkan kategori
        $operations = Operation::all();
        // total produk
        $totalProducts = Product::count();

        $stores = Store::all();

        $totalAsset = Product::select(DB::raw('SUM(stock * price) as total_asset'))->value('total_asset');
        $potentialRevenue = Product::select(DB::raw('SUM(stock * sale_price) as total'))->value('total');

       // Nilai default
        $adminCost = 0;
        $netRevenue = $potentialRevenue;

        // Cari kategori "biaya admin"
        $adminCategory = OperationCategory::where('name', 'Biaya Admin')->first();

        $adminCategory = OperationCategory::where('name', 'Biaya Admin')->first();

        if ($adminCategory) {
            // Ambil operasi pertama dari kategori Biaya Admin
            $adminOperation = $adminCategory->operations()->first();

            if ($adminOperation && $adminOperation->cost) {
                // Pastikan cost adalah dalam persen
                if (strtolower($adminOperation->description) === 'persen') {

                    $adminPercentage = (float) $adminOperation->cost;

                    $adminCost = $potentialRevenue * ($adminPercentage / 100);

                    // Kurangi total revenue dengan biaya admin
                    $netRevenue = $potentialRevenue - $adminCost;


                }
            }
        }





        return view('dashboard.index', compact('stats', 'lowStockProducts', 'topProducts', 'stores', 'storeId', 'operations', 'totalProducts', 'totalAsset', 'netRevenue'));
    }
}
