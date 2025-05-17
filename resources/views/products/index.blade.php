{{--  --}}

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
            <h6 class="fw-semibold mb-0">List Product</h6>
            <ul class="d-flex align-items-center gap-2">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                        Create Produk
                    </a>
                </div>
            </ul>
        </div>
        <div class="card basic-data-table">
            <div class="card-header">
                <h5 class="card-title mb-0">Product Datatables</h5>
            </div>
            <div class="card-body">
                <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                    <thead>
                        <tr>
                            <th scope="col">Product Name</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Purchase Price</th>
                            <th scope="col">Sale Price</th>
                            <th scope="col">Category</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($products as $product)
                            <tr>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <h6 class="text-md mb-0 fw-medium flex-grow-1">{{ $product->name }}</h6>
                                    </div>
                                    <h6 class="text-md mb-0 fw-medium flex-grow-1">
                                        {{ $product->stock }}
                                        @if ($product->stock == 0)
                                            <span class="text-red-500"> (Habis)</span>
                                        @elseif ($product->stock < 30)
                                            <span class="text-yellow-500"> (Hampir Habis)</span>
                                        @endif
                                    </h6>


                                </td>
                                <td>
                                    <h6 class="text-md mb-0 fw-medium flex-grow-1">{{ $product->stock }}</h6>
                                </td>
                                <td>
                                    <h6 class="text-md mb-0 fw-medium flex-grow-1">{{ $product->price }}</h6>
                                </td>
                                <td>
                                    <h6 class="text-md mb-0 fw-medium flex-grow-1">{{ $product->sale_price }}</h6>
                                </td>
                                <td>
                                    <h6 class="text-md mb-0 fw-medium flex-grow-1">{{ $product->category->name }}</h6>
                                </td>

                                <td class=" d-flex align-items-center justify-content-center gap-2">
                                    <a href="{{ route('products.edit', $product->id) }}"
                                        class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                        <iconify-icon icon="lucide:edit"></iconify-icon>
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                            <iconify-icon icon="mingcute:delete-2-line"></iconify-icon></button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        @push('scripts')
            <script>
                let table = new DataTable('#dataTable');
            </script>
        @endpush
    @endsection
