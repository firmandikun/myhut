<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;
use App\Models\OperationCategory;



class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['product', 'store']);

        // Filter berdasarkan status jika ada
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan date_sale jika ada
        if ($request->has('date_sale') && $request->date_sale != '') {
            $query->whereDate('date_sale', $request->date_sale);
        }

        // Filter berdasarkan store_id jika ada
        if ($request->has('store_id') && $request->store_id != '') {
            $query->where('store_id', $request->store_id);
        }

        // Ambil data transaksi dengan pagination
        $transactions = $query->latest()->paginate(10);

        // Ambil data store untuk dropdown filter
        $stores = Store::all();

        return view('transactions.index', compact('transactions', 'stores'));
    }


    public function create()
    {
        $products = Product::all();
        $stores = Store::all();
        return view('transactions.create', compact('products', 'stores'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'status'     => 'required|in:processing,shipped,completed',
            'store_id'   => 'nullable|exists:stores,id',
            'date_sale'  => 'required|date',
        ]);



        // Cek stok SEBELUM memulai transaksi
        $product = Product::findOrFail($validated['product_id']);

        if ($product->stock <= 0) {
            return back()->with([
                'sweet_alert' => [
                    'icon' => 'error',
                    'title' => 'Stok Habis!',
                    'text' => 'Produk ini sedang tidak tersedia (stok 0).'
                ]
            ])->withInput();
        }


        // Mulai transaksi DB untuk menjaga integritas data
        DB::beginTransaction();



        try {
            // Simpan transaksi
            $transaction = Transaction::create([
                'product_id'  => $validated['product_id'],
                'quantity'    => $validated['quantity'],
                'total_price' => $validated['quantity'] * $product->sale_price,
                'store_id'    => $validated['store_id'] ?? null,
                'status'      => $validated['status'],
                'date_sale'   => $validated['date_sale'], // <--- Tambahkan ini
            ]);

            // Ambil produk yang terkait
            $product = Product::findOrFail($validated['product_id']);

            // dd($product->stock);

            if ($product->stock <= 0) {
                return redirect()->back()->with('sweet_alert', [
                    'icon' => 'error',
                    'title' => 'Stok Habis!',
                    'text' => 'Produk ini sedang tidak tersedia (stok 0).'
                ])->withInput();
            }

            // TransactionController.php
            if ($product->stock < $validated['quantity']) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'Stok Tidak Cukup! Jumlah pesanan melebihi stok yang tersedia.')
                    ->withInput();
            }

            // Kurangi stok produk
            $product->decrement('stock', $validated['quantity']);

            // Commit transaksi jika semua berhasil
            DB::commit();

            // Redirect atau tampilkan pesan sukses
            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil!');

        } catch (\Exception $e) {
            // Rollback jika terjadi error
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        $products = Product::all();
        $stores = Store::all();
        return view('transactions.edit', compact('transaction', 'products', 'stores'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'status'     => 'required|in:processing,shipped,completed',
            'store_id'   => 'nullable|exists:stores,id',
            'date_sale'  => 'required|date',
        ]);

        $transaction = Transaction::findOrFail($id);

        $product = Product::findOrFail($validated['product_id']);

        $quantityDifference = $validated['quantity'] - $transaction->quantity;

        DB::beginTransaction();

        try {
            $transaction->update([
                'product_id'  => $validated['product_id'],
                'quantity'    => $validated['quantity'],
                'total_price' => $validated['quantity'] * $product->sale_price,
                'store_id'    => $validated['store_id'] ?? null,
                'status'      => $validated['status'],
                'date_sale'   => $validated['date_sale'], // <--- Tambahkan ini
            ]);

            if ($product->stock <= 0) {
                return redirect()->back()->with('sweet_alert', [
                    'icon' => 'error',
                    'title' => 'Stok Habis!',
                    'text' => 'Produk ini sedang tidak tersedia (stok 0).'
                ])->withInput();
            }

            // TransactionController.php
            if ($product->stock < $validated['quantity']) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'Stok Tidak Cukup! Jumlah pesanan melebihi stok yang tersedia.')
                    ->withInput();
            }
            // Cek apakah stok cukup jika quantity yang baru lebih banyak
            if ($quantityDifference > 0) {
                if ($product->stock < $quantityDifference) {
                    dd('Stok tidak cukup untuk memenuhi permintaan.');
                    return back()->with('error', 'Stok tidak cukup.');
                }

                // Kurangi stok produk jika quantity meningkat
                $product->decrement('stock', $quantityDifference);
            } else {
                // Tambahkan stok produk jika quantity berkurang
                $product->increment('stock', abs($quantityDifference));
            }

            // Commit transaksi jika semua berhasil
            DB::commit();

            // Redirect atau tampilkan pesan sukses
            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diupdate!');

        } catch (\Exception $e) {
            // Rollback jika terjadi error
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function report(Request $request)
    {
        $query = Transaction::with(['product', 'store']);

        // Filter berdasarkan status jika ada
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan store_id jika ada
        if ($request->has('store_id') && $request->store_id != '') {
            $query->where('store_id', $request->store_id);
        }

        // Filter berdasarkan periode
        if ($request->has('period')) {
            switch ($request->period) {
                case 'today':
                    $query->whereDate('date_sale', Carbon::today());
                    break;
                case 'this_week':
                    // Perbaikan filter minggu ini
                    $query->whereBetween('date_sale', [
                        Carbon::now()->startOfWeek(Carbon::MONDAY), // Mulai Senin
                        Carbon::now()->endOfWeek(Carbon::SUNDAY)    // Sampai Minggu
                    ]);
                    break;
                case 'this_month':
                    $query->whereBetween('date_sale', [
                        Carbon::now()->startOfMonth(),
                        Carbon::now()->endOfMonth()
                    ]);
                    break;
                case 'custom':
                    if ($request->has('start_date') && $request->start_date != '') {
                        $query->whereDate('date_sale', '>=', $request->start_date);
                    }
                    if ($request->has('end_date') && $request->end_date != '') {
                        $query->whereDate('date_sale', '<=', $request->end_date);
                    }
                    break;
            }
        } else {
            // Default: bulan ini jika tidak ada filter periode
            $query->whereBetween('date_sale', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ]);
        }



        // Hitung total sebelum pagination
        $totalQuantity = $query->sum('quantity');
    $grossRevenue = $query->sum('total_price'); // Pendapatan kotor

        // Hitung biaya admin dan pendapatan bersih
        $adminFee = 0;
        $netRevenue = $grossRevenue;

        $adminCategory = OperationCategory::where('name', 'Biaya Admin')->first();

        if ($adminCategory) {
            $adminOperation = $adminCategory->operations()->first();

            if ($adminOperation && $adminOperation->cost) {
                if (strtolower($adminOperation->description) === 'persen') {
                    $adminPercentage = (float) $adminOperation->cost;
                    $adminFee = $grossRevenue * ($adminPercentage / 100);
                    $netRevenue = $grossRevenue - $adminFee;
                } else {
                    // Jika biaya admin nominal tetap
                    $adminFee = (float) $adminOperation->cost;
                    $netRevenue = $grossRevenue - $adminFee;
                }
            }
        }

        // Ambil data transaksi dengan pagination
        $transactions = $query->latest('date_sale')->paginate(10);

        // Ambil data store untuk dropdown filter
        $stores = Store::all();

        return view('transactions.report', compact('transactions', 'stores', 'totalQuantity', 'netRevenue'));
    }

public function export(Request $request)
{
    $query = Transaction::with(['product', 'store']);

    // Filter berdasarkan status jika ada
    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }

    // Filter berdasarkan store_id jika ada
    if ($request->has('store_id') && $request->store_id != '') {
        $query->where('store_id', $request->store_id);
    }

    // Filter berdasarkan periode
    if ($request->has('period')) {
        switch ($request->period) {
            case 'today':
                $query->whereDate('date_sale', Carbon::today());
                break;
            case 'this_week':
                $query->whereBetween('date_sale', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'this_month':
                $query->whereBetween('date_sale', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                break;
            case 'custom':
                if ($request->has('start_date') && $request->start_date != '') {
                    $query->whereDate('date_sale', '>=', $request->start_date);
                }
                if ($request->has('end_date') && $request->end_date != '') {
                    $query->whereDate('date_sale', '<=', $request->end_date);
                }
                break;
        }
    }

    $transactions = $query->latest('date_sale')->get();

    $fileName = 'laporan-transaksi-' . now()->format('Y-m-d') . '.xlsx';

    return Excel::download(new TransactionsExport($transactions), $fileName);
}

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);

        $product = Product::findOrFail($transaction->product_id);

        DB::beginTransaction();

        try {
            $product->increment('stock', $transaction->quantity);

            $transaction->delete();

            DB::commit();

            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus dan stok dikembalikan!');

        } catch (\Exception $e) {
            // Rollback jika terjadi error
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function summary()
{
    $today = Carbon::today();
    $startOfWeek = Carbon::now()->startOfWeek();
    $startOfMonth = Carbon::now()->startOfMonth();

    $summary = [
        'today' => [
            'total_quantity' => Transaction::whereDate('date_sale', $today)->sum('quantity'),
            'total_price'    => Transaction::whereDate('date_sale', $today)->sum('total_price'),
        ],
        'this_week' => [
            'total_quantity' => Transaction::whereBetween('date_sale', [$startOfWeek, now()])->sum('quantity'),
            'total_price'    => Transaction::whereBetween('date_sale', [$startOfWeek, now()])->sum('total_price'),
        ],
        'this_month' => [
            'total_quantity' => Transaction::whereBetween('date_sale', [$startOfMonth, now()])->sum('quantity'),
            'total_price'    => Transaction::whereBetween('date_sale', [$startOfMonth, now()])->sum('total_price'),
        ],
    ];

    return view('dashboard.index', compact('summary'));
}
}
