<?php

namespace App\Exports;

use App\Models\MasterItem;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MasterItemsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    private int $no = 0;

    public function query()
    {
        return MasterItem::query()->with('kategoris')->orderBy('id');
    }

    public function headings(): array
    {
        return ['No', 'Nama Kategori', 'Nama Items', 'Nama Supplier', 'Harga', 'Laba', 'Harga Jual'];
    }

    public function map($item): array
    {
        return [
            ++$this->no,
            $item->kategoris->pluck('nama')->implode(', '),
            $item->nama,
            $item->supplier,
            $item->harga_beli,
            $item->laba . '%',
            round($item->harga_beli + $item->harga_beli * $item->laba / 100),
        ];
    }
}
