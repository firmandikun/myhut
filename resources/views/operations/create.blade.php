@extends('layouts.app')

@section('content')
<div class="dashboard-main-body">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('operations.store') }}" method="POST" class="row gy-3">
                @csrf

                <div class="col-12">
                    <label for="date" class="form-label">Date</label>
                    <input type="date"
                        name="date"
                        id="date"
                        class="form-control @error('date') is-invalid @enderror"
                        value="{{ old('date', now()->toDateString()) }}"
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
                           value="{{ old('description') }}"
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
                           value="{{ old('cost') }}"
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
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        Save Operation
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
