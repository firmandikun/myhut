@extends('layouts.app')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Edit Operation</h6>
        <ul class="d-flex align-items-center gap-2">
            <div class="card-header d-flex justify-content-between align-items-center">
                <a href="{{ route('operations.index') }}" class="btn btn-secondary me-2">
                    Back to Operations
                </a>
            </div>
        </ul>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('operations.update', $operation->id) }}" method="POST" class="row gy-3">
                @csrf
                @method('PUT')

                 <div class="col-12">
                    <label for="date" class="form-label">Date</label>
                    <input type="date"
                           name="date"
                           id="date"
                           class="form-control @error('date') is-invalid @enderror"
                           value="{{ old('date', $operation->date ? $operation->date->toDateString() : '') }}"
                           required>
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <input type="text"
                           name="description"
                           id="description"
                           class="form-control @error('description') is-invalid @enderror"
                           value="{{ old('description', $operation->description) }}"
                           required>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="cost" class="form-label">Cost</label>
                    <input type="number"
                           name="cost"
                           id="cost"
                           step="0.01"
                           class="form-control @error('cost') is-invalid @enderror"
                           value="{{ old('cost', $operation->cost) }}"
                           required>
                    @error('cost')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="category_id" class="form-label">Category</label>
                    <select name="category_id"
                            id="category_id"
                            class="form-control @error('category_id') is-invalid @enderror"
                            required>
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $operation->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        Update Operation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .dt-column-title {
        margin-right: 20px;
    }

    th div.dt-column-title {
        flex: 1;
    }
</style>
@endpush
