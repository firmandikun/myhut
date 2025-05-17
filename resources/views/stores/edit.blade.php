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
            <h6 class="fw-semibold mb-0">Edit Store</h6>
        </div>

        <div class="card basic-data-table">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Edit Store</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('stores.update', $store->id) }}" method="POST" class="row gy-3">
                            @csrf
                            @method('PUT')

                            <div class="col-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $store->name) }}" placeholder="Enter Name">
                            </div>

                            <div class="col-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $store->email) }}" placeholder="Enter Email">
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="address">Address</label>
                                <textarea name="address" class="form-control" placeholder="Enter Address">{{ old('address', $store->address) }}</textarea>
                            </div>

                            <div class="col-12">
                                <label for="phone_number" class="form-label">Phone Number</label>
                                <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $store->phone_number) }}" placeholder="Enter Phone Number">
                            </div>

                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary-600">Update</button>
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
