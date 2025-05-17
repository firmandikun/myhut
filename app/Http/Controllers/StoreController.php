<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    // Menampilkan daftar semua store
    public function index()
    {
        $stores = Store::all();
        return view('stores.index', compact('stores'));
    }

    // Menampilkan form tambah store
    public function create()
    {
        return view('stores.create');
    }

    // Menyimpan store baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'nullable|email|max:255',
            'address'      => 'nullable|string|max:500',
            'phone_number' => 'nullable|string|max:15',  // Validasi untuk phone_number
        ]);

        Store::create($validated);

        return redirect()->route('stores.index')->with('success', 'Store created successfully!');
    }

    // Menampilkan form edit store
    public function edit($id)
    {
        $store = Store::findOrFail($id);
        return view('stores.edit', compact('store'));
    }

    // Menyimpan perubahan store
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'nullable|email|max:255',
            'address'      => 'nullable|string|max:500',
            'phone_number' => 'nullable|string|max:15',  // Validasi untuk phone_number
        ]);

        $store = Store::findOrFail($id);
        $store->update($validated);

        return redirect()->route('stores.index')->with('success', 'Store updated successfully!');
    }


    // Menghapus store
    public function destroy($id)
    {
        $store = Store::findOrFail($id);
        $store->delete();

        return redirect()->route('stores.index')->with('success', 'Store deleted successfully.');
    }
}
