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
            <h6 class="fw-semibold mb-0">Transactions</h6>
        </div>

        <div class="card basic-data-table">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Transactions</h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('transactions.store') }}" method="POST" class="row gy-3">
                            @csrf
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="date_sale">Tanggal Penjualan</label>
                                    <input type="date" name="date_sale" id="date_sale" class="form-control" value="{{ old('date_sale', $transaction->date_sale ?? '') }}" required>
                                </div>

                            </div>
                            <div class="col-12">
                                <label for="product_id"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">Product <span
                                        class="text-danger-600">*</span> </label>
                                <select class="form-control radius-8 form-select" id="product_id" name="product_id">
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }} -
                                            Rp{{ number_format($product->sale_price, 0, ',', '.') }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="store_id" class="form-label fw-semibold text-primary-light text-sm mb-8">Store
                                    <span class="text-danger-600">*</span> </label>
                                <select class="form-control radius-8 form-select" id="store_id" name="store_id">
                                    @foreach ($stores as $store)
                                        <option value="{{ $store->id }}">{{ $store->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" name="quantity" class="form-control" placeholder="Enter Quantity">
                            </div>
                            <div class="col-12">
                                <label for="status" class="form-label fw-semibold text-primary-light text-sm mb-8">Status
                                    <span class="text-danger-600">*</span> </label>
                                <select class="form-control radius-8 form-select" id="status" name="status">
                                    <option value="processing">Processing</option>
                                    <option value="shipped">Shipped</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>


                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary-600">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Di head atau sebelum </body> -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @if (session('sweet_alert'))
            <script>
                Swal.fire({
                    icon: '{{ session('sweet_alert.icon') }}',
                    title: '{{ session('sweet_alert.title') }}',
                    text: '{{ session('sweet_alert.text') }}',
                });
            </script>
        @endif

        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                });
            </script>
        @endif

    @endsection
