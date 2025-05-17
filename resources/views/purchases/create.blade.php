@extends('layouts.app')

@push('styles')
@endpush

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Transactions Purchases</h6>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Transactions Purchases</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('purchases.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="product_id" class="form-label">Produk</label>
                        <select class="form-select" id="product_id" name="product_id" required>
                            <option value="">Pilih Produk</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->sale_price }}"
                                    data-stock="{{ $product->stock }}">
                                    {{ $product->name }} (Harga Beli: Rp {{ number_format($product->sale_price, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Harga per Unit</label>
                            <input type="text" class="form-control" id="price_display" readonly>
                            <input type="hidden" id="price_per_unit" name="price_per_unit">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="purchase_date" class="form-label">Tanggal Pembelian</label>
                        <input type="date" class="form-control" id="purchase_date" name="purchase_date" required>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Pembelian</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function () {
            function formatRupiah(number) {
                return 'Rp ' + Number(number).toLocaleString('id-ID');
            }

            function updatePrice() {
                const productSelect = document.getElementById('product_id');
                const priceDisplay = document.getElementById('price_display');
                const priceInput = document.getElementById('price_per_unit');

                if (!productSelect || !priceDisplay || !priceInput) return;

                const selectedOption = productSelect.options[productSelect.selectedIndex];
                const priceAttr = selectedOption.getAttribute('data-price');

                if (selectedOption.value && priceAttr !== null) {
                    const price = parseFloat(priceAttr);
                    if (!isNaN(price)) {
                        priceDisplay.value = formatRupiah(price);
                        priceInput.value = price;
                    } else {
                        priceDisplay.value = '';
                        priceInput.value = '';
                    }
                } else {
                    priceDisplay.value = '';
                    priceInput.value = '';
                }
            }

            function initPriceUpdate() {
                const productSelect = document.getElementById('product_id');
                if (productSelect) {
                    productSelect.addEventListener('change', updatePrice);
                    updatePrice(); // Jalankan sekali saat halaman pertama kali dimuat
                }
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initPriceUpdate);
            } else {
                initPriceUpdate();
            }
        })();
    </script>
@endpush
