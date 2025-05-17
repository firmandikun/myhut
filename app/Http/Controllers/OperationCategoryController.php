<?php

namespace App\Http\Controllers;

use App\Models\OperationCategory;
use Illuminate\Http\Request;

class OperationCategoryController extends Controller
{
    /**
     * Menampilkan daftar kategori operasional.
     *
     * Mengambil semua kategori operasional yang ada di database
     * dan menampilkannya di halaman index.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categories = OperationCategory::all();
        return view('operations.categories.list', compact('categories'));
    }



    /**
     * Menampilkan form untuk menambah kategori baru.
     *
     * Mengarahkan pengguna ke halaman untuk menambahkan kategori baru
     * dengan form input nama kategori.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Menampilkan halaman form untuk menambahkan kategori
        return view('operations.categories.create');
    }

    /**
     * Menyimpan kategori baru ke dalam database.
     *
     * Menerima input nama kategori dari form, melakukan validasi, dan
     * menyimpan kategori baru ke dalam tabel 'operation_categories'.
     * Jika validasi gagal, akan mengembalikan pesan kesalahan.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:operation_categories,name'
        ]);

        OperationCategory::create($validated);

        return redirect()->route('operations.categories.list')->with('success', 'Kategori berhasil ditambahkan.');
    }


    /**
     * Menampilkan form untuk mengedit kategori yang ada.
     *
     * Mengambil kategori berdasarkan ID yang diberikan, dan menampilkan
     * form edit dengan data kategori yang ada.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Mencari kategori berdasarkan ID yang diberikan
        $category = OperationCategory::findOrFail($id);

        // Menampilkan form edit kategori dengan data kategori yang ditemukan
        return view('operations.categories.edit', compact('category'));
    }

    /**
     * Memperbarui kategori yang sudah ada.
     *
     * Menerima input dari form edit kategori, memvalidasi data,
     * dan memperbarui kategori yang sudah ada di database berdasarkan ID.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $category = OperationCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:operation_categories,name,' . $id
        ]);

        $category->update($validated);

        return redirect()->route('operations.categories.list')->with('success', 'Kategori berhasil diperbarui.');
    }



    /**
     * Menghapus kategori dari database.
     *
     * Mencari kategori berdasarkan ID dan menghapusnya dari database.
     * Setelah kategori berhasil dihapus, akan melakukan redirect ke
     * halaman daftar kategori dengan pesan sukses.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $category = OperationCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('operations.categories.list')->with('success', 'Kategori berhasil dihapus.');
    }
}
