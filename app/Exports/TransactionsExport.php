<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Produk',
            'Kuantitas',
            'Harga Satuan',
            'Total Harga',
            'Toko',
            'Status'
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->date_sale,
            $transaction->product->name,
            $transaction->quantity,
            $transaction->product->sale_price,
            $transaction->total_price,
            $transaction->store->name ?? '-',
            ucfirst($transaction->status)
        ];
    }
}
