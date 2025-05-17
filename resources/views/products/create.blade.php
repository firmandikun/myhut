@extends('layouts.app')

<style>
    .dt-column-title {
        margin-right: 20px
    }

    th div.dt-column-title {
        flex: 1;
    }
</style>

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Create Product</h6>
            <ul class="d-flex align-items-center gap-2">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                        Create Produk
                    </a>
                </div>
            </ul>
        </div>

        <div class="card basic-data-table">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Vertical Input Form</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('products.store') }}" method="POST" class="row gy-3">
                            @csrf
                            <div class="col-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Name">
                            </div>
                            <div class="col-12">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="number" name="stock" class="form-control" placeholder="Enter Stock">
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="price">Price</label>
                                <input type="number" name="price" class="form-control" placeholder="Enter Price">
                            </div>
                            <div class="col-12">
                                <label for="category_id"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">Category <span
                                        class="text-danger-600">*</span> </label>
                                <select class="form-control radius-8 form-select" id="category_id" name="category_id">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="sale_price">Sale Price</label>
                                <input type="number" name="sale_price" class="form-control"
                                    placeholder="Enter Sale Price">
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary-600">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    @endsection
