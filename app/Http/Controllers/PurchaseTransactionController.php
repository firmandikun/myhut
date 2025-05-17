<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseTransactionController extends Controller
{
    public function index()
    {
        $purchases = PurchaseTransaction::with('product')->latest()->get();
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $products = Product::all();
        return view('purchases.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'purchase_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        DB::beginTransaction();

        try {
            $product = Product::findOrFail($validated['product_id']);

            $purchase = PurchaseTransaction::create([
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'price_per_unit' => $product->sale_price,
                'total_price' => $validated['quantity'] * $product->sale_price,
                'purchase_date' => $validated['purchase_date'],
                'notes' => $validated['notes']
            ]);

            $product->increment('stock', $validated['quantity']);

            DB::commit();

            return redirect()->route('purchases.index')
                ->with('success', 'Pembelian berhasil dicatat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $purchase = PurchaseTransaction::findOrFail($id);
        $products = Product::all();
        return view('purchases.edit', compact('purchase', 'products'));
    }

    public function update(Request $request, $id)
    {
        $purchase = PurchaseTransaction::findOrFail($id);

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'purchase_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        DB::beginTransaction();

        try {
            $oldQuantity = $purchase->quantity;
            $product = Product::findOrFail($validated['product_id']);

            $purchase->update([
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'price_per_unit' => $product->sale_price,
                'total_price' => $validated['quantity'] * $product->sale_price,
                'purchase_date' => $validated['purchase_date'],
                'notes' => $validated['notes']
            ]);

            // Update stok: rollback stok lama, lalu tambah stok baru
            $product->decrement('stock', $oldQuantity);
            $product->increment('stock', $validated['quantity']);

            DB::commit();

            return redirect()->route('purchases.index')
                ->with('success', 'Transaksi berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $purchase = PurchaseTransaction::findOrFail($id);

        DB::beginTransaction();

        try {
            $product = $purchase->product;
            $product->decrement('stock', $purchase->quantity);
            $purchase->delete();

            DB::commit();

            return redirect()->route('purchases.index')
                ->with('success', 'Transaksi berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

}
