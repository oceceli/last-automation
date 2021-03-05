<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport extends BaseExport implements FromQuery, WithHeadings, WithMapping
{
    
    protected $fileName = 'Ürünler';

    public function __construct(Builder $injectedQuery)
    {
        $this->injectedQuery = $injectedQuery;
    }

    protected function title() : string
    {
        return 'Ürün listesi - Çıktı tarihi: ' . now()->format('d.m.Y');
    }


    public function headings() : array
    {
        return [
            __('validation.attributes.prd_code'), '',
            __('validation.attributes.prd_name'), '',
            __('modelnames.category'), '',
            __('validation.attributes.prd_barcode'), '',
            __('validation.attributes.prd_shelf_life'), '',
            __('validation.attributes.prd_cost'), '',
            __('inventory.in_stock'), '',
            __('common.status'),
        ];
    }

    public function map($product) : array
    {
        return [
            $product->prd_code, '',
            $product->prd_name, '',
            optional($product->category)->ctg_name ?? __('products.category_not_defined'), '',
            $product->prd_barcode, '',
            $product->prd_shelf_life, '',
            $product->prd_cost, '',
            $product->totalStock['amount'], '',
            $product->prd_is_active ? 'Aktif' : 'Disaktif',
        ];
    }


    public function query()
    {
        return $this->injectedQuery;
    }
}
