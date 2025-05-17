@extends('layouts.app')

<style>
    .dt-column-title {
        margin-right: 20px;
    }

    th div.dt-column-title {
        flex: 1;
    }
</style>

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">List Operational</h6>
            <ul class="d-flex align-items-center gap-2">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('operations.create') }}" class="btn btn-primary">
                        Operational Create
                    </a>
                </div>
            </ul>
        </div>

        <div class="card basic-data-table">
            <div class="card-header">
                <h5 class="card-title mb-0">Operational Datatables</h5>
            </div>
            <div class="card-body">
                <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border">Expense Category</th>
                            <th class="px-4 py-2 border">Description</th>
                            <th class="px-4 py-2 border">Cost</th>
                            <th class="px-4 py-2 border">Date</th> <!-- New Column for Date -->
                            <th class="px-4 py-2 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($operations as $operation)
                            <tr>
                                <td class="px-4 py-2 border">{{ $operation->category->name }}</td>
                                <td class="px-4 py-2 border">{{ $operation->description }}</td>
                                <td class="px-4 py-2 border">
                                    @if ($operation->category->name === 'Biaya Admin')
                                        {{ $operation->cost }}%
                                    @else
                                        {{ 'Rp' . number_format($operation->cost, 0, ',', '.') }}
                                    @endif
                                </td>
                                <td class="px-4 py-2 border">
                                    {{ $operation->date ? \Carbon\Carbon::parse($operation->date)->format('Y-m-d') : 'N/A' }}
                                </td> <!-- Display Date -->
                                <td class="d-flex align-items-center justify-content-center gap-2">
                                    <a href="{{ route('operations.edit', $operation->id) }}"
                                        class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                        <iconify-icon icon="lucide:edit"></iconify-icon>
                                    </a>
                                    <form action="{{ route('operations.destroy', $operation->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                            <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                        </button>
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
