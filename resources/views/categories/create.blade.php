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
            <h6 class="fw-semibold mb-0">Create Category Product</h6>
            <ul class="d-flex align-items-center gap-2">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('categories.create') }}" class="btn btn-primary">
                        Create Category Product
                    </a>
                </div>
            </ul>
        </div>

        <div class="card basic-data-table">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Category Product</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('categories.store') }}" method="POST" class="row gy-3">
                            @csrf
                            <div class="col-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Name">
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="description">Description</label>
                                <textarea type="text" name="description" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary-600">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @push('scripts')
            <script>
                @if (session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: "{{ session('success') }}",
                        timer: 2000,
                        showConfirmButton: false
                    });
                @endif
            </script>
        @endpush
    @endsection
