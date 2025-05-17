@extends('layouts.app')

@section('content')
    <div class="dashboard-main-body">
        <div class="row">
            <div class="col-xxl-9">
                <div class="card radius-8 border-0">
                    <div class="card-body">
                        <div class="row d-flex justify-content-end align-items-center ">
                            <div class="mb-3" style="width: 20%">
                                <form method="GET" action="{{ route('dashboard') }}" class="mb-4">
                                    <div class="form-group">
                                        <label for="store_id" class="mb-2">Filter Store:</label>
                                        <select name="store_id" id="store_id" class="form-control"
                                            onchange="this.form.submit()">
                                            <option value="">Semua Store</option>
                                            @foreach ($stores as $store)
                                                <option value="{{ $store->id }}"
                                                    {{ request('store_id') == $store->id ? 'selected' : '' }}>
                                                    {{ $store->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" style="margin-bottom: 24px">
                                <div class="border cborder radius-8 p-3 h-100 d-flex flex-column justify-content-between">
                                    <div class="d-flex align-items-center mb-3 gap-2">
                                        <span
                                            class="w-44-px h-44-px text-info-600 bg-info-light border border-info-light-white d-flex justify-content-center align-items-center radius-8 me-2">
                                            <iconify-icon icon="fluent:box-20-filled" class="icon"></iconify-icon>
                                        </span>
                                        <div>
                                            <div class="text-secondary-light text-md fw-medium">Total Products</div>
                                            <div class="fw-semibold">
                                                {{ $totalProducts }} Items
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4" style="margin-bottom: 24px">
                                <div class="border cborder radius-8 p-3 h-100 d-flex flex-column justify-content-between">
                                    <div class="d-flex align-items-center mb-3 gap-2">
                                        <span
                                            class="w-44-px h-44-px text-info-600 bg-info-light border border-info-light-white d-flex justify-content-center align-items-center radius-8 me-2">
                                            <iconify-icon icon="fluent:box-20-filled" class="icon"></iconify-icon>
                                        </span>
                                        <div>
                                            <div class="text-secondary-light text-md fw-medium">Total Asset</div>
                                            <div class="fw-semibold">
                                                 Rp{{ number_format($totalAsset, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4" style="margin-bottom: 24px">
                                <div class="border cborder radius-8 p-3 h-100 d-flex flex-column justify-content-between">
                                    <div class="d-flex align-items-center mb-3 gap-2">
                                        <span
                                            class="w-44-px h-44-px text-info-600 bg-info-light border border-info-light-white d-flex justify-content-center align-items-center radius-8 me-2">
                                            <iconify-icon icon="fluent:box-20-filled" class="icon"></iconify-icon>
                                        </span>
                                        <div>
                                            <div class="text-secondary-light text-md fw-medium">Potential Revenue (if all stock sold)</div>
                                            <div class="fw-semibold">
                                                Rp{{ number_format($netRevenue, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            @php
                                $icons = [
                                    'today' => 'fluent:calendar-day-20-filled',
                                    'this_week' => 'fluent:calendar-week-20-filled',
                                    'this_month' => 'fluent:calendar-month-20-filled',
                                ];

                                $labels = [
                                    'today' => 'Today',
                                    'this_week' => 'This Week',
                                    'this_month' => 'This Month',
                                ];
                            @endphp

                            @foreach ($labels as $key => $label)
                                <div class="col-md-4 " style="margin-bottom: 24px">
                                    <div
                                        class="border cborder radius-8 p-3 h-100 d-flex flex-column justify-content-between">
                                        <div class="d-flex align-items-center mb-3 gap-2">
                                            <span
                                                class="w-44-px h-44-px text-primary-600 bg-primary-light border border-primary-light-white d-flex justify-content-center align-items-center radius-8 me-2">
                                                <iconify-icon icon="{{ $icons[$key] }}" class="icon"></iconify-icon>
                                            </span>
                                            <div>
                                                <div class="text-secondary-light text-md fw-medium">{{ $label }}
                                                </div>
                                                <div class="fw-semibold text-primary-light">
                                                    Rp{{ number_format($stats[$key]['total_price'], 0, ',', '.') }}
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-sm mb-0">
                                            Total Products Sold:
                                            <span class="bg-success-focus rounded-2 fw-medium text-success-main text-sm"
                                                style="padding: 5px 10px">
                                                {{ $stats[$key]['total_quantity'] }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-xxl-3">
                <div class="card h-100">

                    <div class="card-body">
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                            <h6 class="mb-2 fw-bold text-lg">Operational</h6>
                             <a href="/operations"
                                class="text-primary-600 hover-text-primary d-flex align-items-center gap-1">
                                View All
                                <iconify-icon icon="solar:alt-arrow-right-linear" class="icon"></iconify-icon>
                            </a>
                        </div>
                        @php
                            $operationIcons = [
                                'heroicons:document',
                                'mdi:finance',
                                'fluent:money-16-filled',
                                'carbon:report',
                                'mdi:chart-box-outline',
                            ];
                        @endphp

                        <div class="mt-32">
                            @foreach ($operations as $operation)
                                @php
                                    $randomIcon = $operationIcons[array_rand($operationIcons)];
                                @endphp

                                <div class="d-flex align-items-center justify-content-between gap-3 mb-32">
                                    <div class="d-flex align-items-center gap-2">
                                        <span
                                            class="w-40-px h-40-px radius-8 bg-primary-light text-primary d-flex align-items-center justify-content-center flex-shrink-0">
                                            <iconify-icon icon="{{ $randomIcon }}" class="text-xl"></iconify-icon>
                                        </span>

                                        <div class="flex-grow-1">
                                            <h6 class="text-md mb-0 fw-normal">
                                                {{ $operation->category ? $operation->category->name : 'Tidak ada kategori' }}
                                            </h6>
                                            <span class="text-sm text-secondary-light fw-normal">
                                                {{ $operation->date->format('Y-m-d') }}
                                            </span>
                                        </div>
                                    </div>

                                    @if (optional($operation->category)->name === 'Biaya Admin')
                                        <span class="text-danger text-md fw-medium">
                                            {{ $operation->cost }}%
                                        </span>
                                    @else
                                        <span class="text-danger text-md fw-medium">
                                            Rp{{ number_format($operation->cost, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>


                    </div>
                </div>
            </div>
        </div>


        <div class="row " style="margin-top: 24px">
            <div class="col-xxl-6">
                <div class="card h-100">
                    <div class="card-body p-24">
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between mb-20">
                            <h6 class="mb-2 fw-bold text-lg mb-0">Top Selling Product</h6>
                            <a href="/transactions"
                                class="text-primary-600 hover-text-primary d-flex align-items-center gap-1">
                                View All
                                <iconify-icon icon="solar:alt-arrow-right-linear" class="icon"></iconify-icon>
                            </a>
                        </div>
                        <div class="table-responsive scroll-sm">
                            <table class="table bordered-table mb-0 text-left">
                                <thead>
                                    <tr>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Total Orders</th>
                                        <th scope="col">Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($topProducts as $item)
                                        <tr>
                                            <td>{{ $item->product_name ?? '-' }}</td>
                                            <td>{{ $item->total_sold }}</td>
                                            <td>{{ $item->total_price }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center">Belum ada data produk terlaris.</td>
                                        </tr>
                                    @endforelse
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-6">
                <div class="card h-100">
                    <div class="card-body p-24">
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between mb-20">
                            <h6 class="mb-2 fw-bold text-lg">Product stock is almost out</h6>
                            <a href="/products/list"
                                class="text-primary-600 hover-text-primary d-flex align-items-center gap-1">
                                View All
                                <iconify-icon icon="solar:alt-arrow-right-linear" class="icon"></iconify-icon>
                            </a>
                        </div>
                        <div class="table-responsive scroll-sm">
                            <table class="table bordered-table mb-0 text-left">
                                <thead>
                                    <tr>
                                        <th scope="col">Product Name</th>
                                        <th scope="col text-center">Quantity</th>
                                    </tr>
                                </thead>
                                @php
                                    $maxStock = 100;
                                @endphp

                                @forelse ($lowStockProducts as $item)
                                    @php
                                        $stock = $item->stock ?? 0;
                                        $percentage = min(100, ($stock / $maxStock) * 100);

                                        if ($percentage < 25) {
                                            $progressClass = 'bg-danger-main';
                                        } elseif ($percentage < 51) {
                                            $progressClass = 'bg-warning-main';
                                        } elseif ($percentage < 76) {
                                            $progressClass = 'bg-info-main';
                                        } else {
                                            $progressClass = 'bg-success-main';
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $item->name ?? '-' }}</td>
                                        <td>
                                            <div class="max-w-112 mx-auto">
                                                <div class="w-100">
                                                    <div class="progress progress-sm rounded-pill" role="progressbar"
                                                        aria-valuenow="{{ (int) $percentage }}" aria-valuemin="0"
                                                        aria-valuemax="100">
                                                        <div class="progress-bar {{ $progressClass }} rounded-pill"
                                                            style="width: {{ $percentage }}%;"></div>
                                                    </div>
                                                </div>
                                                <span class="mt-12 text-secondary-light text-sm fw-medium">
                                                    {{ $stock }} stok
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">Belum ada data produk stok rendah.</td>
                                    </tr>
                                @endforelse

                            </table>
                        </div>
                    </div>
                </div>
            </div>




            {{-- Produk Hampir Habis --}}
            {{-- <div class="mb-5">
            <h4>Produk Hampir Habis</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lowStockProducts as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->stock }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">Tidak ada produk hampir habis.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div> --}}

            {{-- Produk Terlaris --}}
            {{-- <div class="mb-5">
            <h4>Produk Terlaris</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Total Terjual</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($topProducts as $item)
                        <tr>
                            <td>{{ $item->product_name ?? '-' }}</td>
                            <td>{{ $item->total_sold }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">Belum ada data produk terlaris.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div> --}}


            {{-- <h3>Operational Costs by Category</h3>
        <table>
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th>Biaya</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($operations as $operation)
                    <tr>
                        <td>{{ $operation->date->format('Y-m-d') }}</td>
                        <td>{{ $operation->category ? $operation->category->name : 'Tidak ada kategori' }}</td>
                        <td>{{ $operation->cost }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table> --}}




        </div>
    @endsection
