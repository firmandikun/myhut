<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    // Menampilkan daftar produk
    public function index()
    {

        $products = Product::with('category')->get();
        return view('products.index', compact('products'));
    }

    // Menampilkan form untuk menambah produk baru
    public function create()
    {
        $categories = Category::all();

        return view('products.create', compact('categories'));
    }


    // Menyimpan produk baru ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    // Menampilkan form untuk mengedit produk
    public function edit($id)
    {
        // Mengambil data produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Mengambil semua kategori
        $categories = Category::all();

        // Mengembalikan tampilan untuk mengedit produk
        return view('products.edit', compact('product', 'categories'));
    }


    // Memperbarui produk yang sudah ada
    public function update(Request $request, $id)
    {
        // Validasi data yang masuk
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        // Mencari produk berdasarkan ID dan memperbarui data
        $product = Product::findOrFail($id);
        $product->update($validated);

        // Redirect ke halaman produk dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    // Menghapus produk
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

}
