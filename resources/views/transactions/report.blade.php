@extends('layouts.app')

<style>
    .dt-column-title {
        margin-right: 20px
    }

    th div.dt-column-title {
        flex: 1;
    }

    @media (min-width: 768px) {

        td:nth-child(3),
        th:nth-child(3) {
            max-width: 300px;
            word-break: break-word;
            white-space: normal;
        }
    }
</style>

@section('content')
    <div class="dashboard-main-body">
 <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Dashboard</h6>
            <ul class="d-flex align-items-center gap-2">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('transactions.create') }}" class="btn btn-primary">
                       Create Transactions
                    </a>
                </div>
            </ul>
        </div>
        <div class="card mb-4 basic-data-table">
            <div class="card-header">
                <h5 class="card-title mb-0" >Filter Laporan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('transactions.report') }}" method="GET">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="period">Periode</label>
                                <select name="period" id="period" class="form-control">
                                    <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Hari Ini
                                    </option>
                                    <option value="this_week" {{ request('period') == 'this_week' ? 'selected' : '' }}>
                                        Minggu Ini</option>
                                    <option value="this_month" {{ request('period') == 'this_month' ? 'selected' : '' }}>
                                        Bulan Ini</option>
                                    <option value="custom" {{ request('period') == 'custom' ? 'selected' : '' }}>
                                        Kustom</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>
                                        Processing</option>
                                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped
                                    </option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                        Completed</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="store_id">Toko</label>
                                <select name="store_id" id="store_id" class="form-control">
                                    <option value="">Semua Toko</option>
                                    @foreach ($stores as $store)
                                        <option value="{{ $store->id }}"
                                            {{ request('store_id') == $store->id ? 'selected' : '' }}>
                                            {{ $store->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3" id="start_date_group"
                            style="{{ request('period') == 'custom' ? '' : 'display:none;' }}">
                            <div class="form-group">
                                <label for="start_date">Dari Tanggal</label>
                                <input type="date" name="start_date" id="start_date" class="form-control"
                                    value="{{ request('start_date') }}">
                            </div>
                        </div>
                        <div class="col-md-3" id="end_date_group"
                            style="{{ request('period') == 'custom' ? '' : 'display:none;' }}">
                            <div class="form-group">
                                <label for="end_date">Sampai Tanggal</label>
                                <input type="date" name="end_date" id="end_date" class="form-control"
                                    value="{{ request('end_date') }}">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Filter</button>
                    <a href="{{ route('transactions.report') }}" class="btn btn-secondary mt-2">Reset</a>
                </form>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row " style="margin-bottom: 24px; margin-top: 24px;">
            <div class="col-md-4">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Total Transaksi</h5>
                        <p class="card-text h4">{{ $transactions->total() }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Total Kuantitas</h5>
                        <p class="card-text h4">{{ $totalQuantity }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <h5 class="card-title">Total Pendapatan</h5>
                        <p class="card-text h4">Rp {{ number_format($netRevenue, 2, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaction Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Data Transaksi</h5>
                <a href="{{ route('transactions.export') }}?{{ http_build_query(request()->query()) }}"
                    class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover"  id="dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Produk</th>
                                <th>Kuantitas</th>
                                <th>Harga Satuan</th>
                                <th>Total Harga</th>
                                <th>Toko</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $key => $transaction)
                                <tr>
                                    <td>{{ $transactions->firstItem() + $key }}</td>
                                    <td>{{ Carbon\Carbon::parse($transaction->date_sale)->format('d/m/Y') }}</td>
                                    <td>{{ $transaction->product->name }}</td>
                                    <td>{{ $transaction->quantity }}</td>
                                    <td>Rp {{ number_format($transaction->product->sale_price, 2, ',', '.') }}</td>
                                    <td>Rp {{ number_format($transaction->total_price, 2, ',', '.') }}</td>
                                    <td>{{ $transaction->store->name ?? '-' }}</td>
                                    <td>
                                        <span
                                            class="badge
                                        {{ $transaction->status == 'completed'
                                            ? 'bg-success'
                                            : ($transaction->status == 'shipped'
                                                ? 'bg-info'
                                                : 'bg-warning') }}">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const periodSelect = document.getElementById('period');
                const startDateGroup = document.getElementById('start_date_group');
                const endDateGroup = document.getElementById('end_date_group');

                periodSelect.addEventListener('change', function() {
                    if (this.value === 'custom') {
                        startDateGroup.style.display = 'block';
                        endDateGroup.style.display = 'block';
                    } else {
                        startDateGroup.style.display = 'none';
                        endDateGroup.style.display = 'none';
                    }
                });
            });
        </script>
          <script>
            let table = new DataTable('#dataTable', {
                responsive: true // aktifkan fitur responsif
            });
        </script>
    @endpush
@endsection
