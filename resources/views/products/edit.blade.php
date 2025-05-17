@extends('layouts.app')

@section('content')
<div class="dashboard-main-body">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Form Edit Produk</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('products.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Produk</label>
                    <input type="text" class="form-control" name="name" id="name"
                        value="{{ old('name', $product->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">Stok</label>
                    <input type="number" class="form-control" name="stock" id="stock"
                        value="{{ old('stock', $product->stock) }}" required>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Harga</label>
                    <input type="number" class="form-control" name="price" id="price"
                        value="{{ old('price', $product->price) }}" required>
                </div>

                <div class="mb-3">
                    <label for="sale_price" class="form-label">Harga Jual</label>
                    <input type="number" class="form-control" name="sale_price" id="sale_price"
                        value="{{ old('sale_price', $product->sale_price) }}" required>
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Kategori</label>
                    <select name="category_id" id="category_id" class="form-control" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
@endsection
