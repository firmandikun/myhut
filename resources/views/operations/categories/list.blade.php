@extends('layouts.app')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">List Categories Operasional</h6>

         @if (Auth::user()->role == 'admin')
                               <ul class="d-flex align-items-center gap-2">
            <div class="card-header d-flex justify-content-between align-items-center">
                <a href="{{ route('operations.categories.create') }}" class="btn btn-primary">
                    Create tegories Operasional
                </a>
            </div>
        </ul>
                            @endif
    </div>

    <div class="card basic-data-table" >
        <div class="card-header">
            <h5 class="card-title mb-0">List Category Operational Datatables</h5>
        </div>
        <div class="card-body">
            <table class="table bordered-table mb-0"  id="dataTable" >
                <thead>
                    <tr>
                        <th>Name Category</th>
                           @if (Auth::user()->role == 'admin')
                                <th scope="col">Action</th>
                            @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $i => $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                              @if (Auth::user()->role == 'admin')
                                 <td class=" d-flex align-items-center justify-content-center gap-2">
                                <a href="{{ route('operations.categories.edit', $category->id) }}"
                                    class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                </a>
                                <form action="{{ route('operations.categories.destroy', $category->id) }}" method="POST"
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
        </div>
    </div>
    </div>
    @push('scripts')
    <script>
        let table = new DataTable('#dataTable');
    </script>
@endpush
@endsection
