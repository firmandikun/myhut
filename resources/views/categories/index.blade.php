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

             @if (Auth::user()->role == 'admin')
                    <ul class="d-flex align-items-center gap-2">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('stores.create') }}" class="btn btn-primary">
                        Create Store
                    </a>
                </div>
            </ul>
                @endif
        </div>
        <div class="card basic-data-table">
            <div class="card-header">
                <h5 class="card-title mb-0">Default Datatables</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                              @if (Auth::user()->role == 'admin')
                                <th scope="col">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($categories as $category)
                            <tr>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <h6 class="text-md mb-0 fw-medium flex-grow-1">{{ $category->name }}</h6>
                                    </div>
                                </td>
                                <td>
                                    <h6 class="text-md mb-0 fw-medium flex-grow-1">{{ $category->description }}</h6>
                                </td>
                                @if (Auth::user()->role == 'admin')
                                    <td>
                                        <h6 class="text-md mb-0 fw-medium flex-grow-1">{{ $category->description }}</h6>
                                <td class=" d-flex align-items-center justify-content-center gap-2">
                                    <a href="{{ route('categories.edit', $category->id) }}"
                                        class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                        <iconify-icon icon="lucide:edit"></iconify-icon>
                                    </a>

                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-delete w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                            <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                        </button>
                                    </form>

                                </td>
                                @endif
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        @push('scripts')
            <script>
                let table = new DataTable('#dataTable', {
                    responsive: true // aktifkan fitur responsif
                });
            </script>

            <script>
                // Konfirmasi delete
                document.querySelectorAll('.btn-delete').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const form = this.closest('.delete-form');

                        Swal.fire({
                            title: 'Are you sure?',
                            text: "This action cannot be undone!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });
            </script>
        @endpush
    @endsection
