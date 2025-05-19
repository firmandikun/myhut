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
    {{-- <a href="{{ route('transactions.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">+ New Transaction</a> --}}
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Dashboard</h6>
             @if (Auth::user()->role == 'admin')
                                <ul class="d-flex align-items-center gap-2">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('transactions.create') }}" class="btn btn-primary">
                       Create Transactions
                    </a>
                </div>
            </ul>
                            @endif

        </div>
        <div class="card basic-data-table">
            <div class="card-header">
                <h5 class="card-title mb-0">Transactions</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('transactions.index') }}" method="GET" class="row gy-3 mb-4">
                    <div class="col-3">
                        <label for="status" class="form-label fw-semibold">Status</label>
                        <select class="form-control radius-8 form-select" id="status" name="status">
                            <option value="">All</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <div class="col-3">
                        <label for="store_id" class="form-label fw-semibold">Store</label>
                        <select class="form-control radius-8 form-select" id="store_id" name="store_id">
                            <option value="">All</option>
                            @foreach ($stores as $store)
                                <option value="{{ $store->id }}" {{ request('store_id') == $store->id ? 'selected' : '' }}>
                                    {{ $store->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-3">
                        <label for="date_sale" class="form-label fw-semibold">Date Sale</label>
                        <input type="date" name="date_sale" class="form-control" value="{{ request('date_sale') }}">
                    </div>

                    <div class="col-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary-600">Filter</button>
                    </div>
                </form>

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

                <table class="table table-striped" id="dataTable" >
                    <thead>
                        <tr>
                            <th>Date Sale</th>
                            <th>Product</th>
                            <th>Store</th>
                            <th>Quantity</th>
                            <th>Total Transaction</th>
                            <th>Status</th>
                             @if (Auth::user()->role == 'admin')
                                <th scope="col">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $trx)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($trx->date_sale)->format('d-m-Y') }}</td>
                                <td>{{ $trx->product->name }}</td>
                                <td>{{ $trx->store ? $trx->store->name : 'No Store' }}</td>
                                <td>{{ $trx->quantity }}</td>
                                <td>{{ $trx->total_price }}</td>
                                <td>{{ ucfirst($trx->status) }}</td>
                                  @if (Auth::user()->role == 'admin')
                                  <td class=" d-flex align-items-center justify-content-center gap-2">
                                    <a href="{{ route('transactions.edit', $trx->id) }}"
                                        class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                        <iconify-icon icon="lucide:edit"></iconify-icon>
                                    </a>
                                    <form action="{{ route('transactions.destroy', $trx->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                            <iconify-icon icon="mingcute:delete-2-line"></iconify-icon></button>
                                    </form>

                                </td>
                            @endif

                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                {{ $transactions->links() }}
            </div>
        </div>
        </div>

        @push('scripts')
        <script>
            let table = new DataTable('#dataTable', {
                responsive: true // aktifkan fitur responsif
            });
        </script>
    @endpush

    @endsection
