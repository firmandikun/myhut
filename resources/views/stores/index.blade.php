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
                    <a href="{{ route('stores.create') }}" class="btn btn-primary">
                        Create Store
                    </a>
                </div>
            </ul>
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
                            <th scope="col">Email</th>
                            <th scope="col">Address</th>
                            <th scope="col"> Phone Number </th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($stores as $store)
                            <tr>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <h6 class="text-md mb-0 fw-medium flex-grow-1">{{ $store->name }}</h6>
                                    </div>
                                </td>
                                <td>
                                    <h6 class="text-md mb-0 fw-medium flex-grow-1">{{ $store->email }}</h6>
                                </td>
                                <td>
                                    <h6 class="text-md mb-0 fw-medium flex-grow-1">{{ $store->address }}</h6>
                                </td>
                                <td>
                                    <h6 class="text-md mb-0 fw-medium flex-grow-1">{{ $store->phone_number }}</h6>
                                </td>

                                <td class=" d-flex align-items-center justify-content-center gap-2">
                                    <a href="{{ route('stores.edit', $store->id) }}"
                                        class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                        <iconify-icon icon="lucide:edit"></iconify-icon>
                                    </a>
                                    <form action="{{ route('stores.destroy', $store->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-delete w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
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
