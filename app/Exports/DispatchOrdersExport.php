<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DispatchOrdersExport extends BaseExport implements FromQuery, WithHeadings, WithMapping
{
    protected $fileName = 'Sevkiyat';

    
    public function __construct(Builder $query)
    {
        $this->injectedQuery = $query;
    }

    protected function title() : string
    {
        return 'Sevkiyat - Çıktı tarihi: ' . now()->format('d.m.Y');
    }



    public function headings() : array
    {
        return [
            __('validation.attributes.do_number'), ' ',
            __('validation.attributes.company_id'), ' ',
            __('dispatchorders.dispatch_address'), ' ',
            __('validation.attributes.sales_type_id'), ' ',
            __('validation.attributes.do_planned_datetime'), ' ',
            __('validation.attributes.do_actual_datetime'), ' ',
            __('validation.attributes.do_status'), ' ',
        ];
    }


    public function map($do) : array
    {
        return [
            $do->do_number, ' ',
            $do->company->cmp_commercial_title, ' ',
            $do->address->adr_name, ' ',
            // $do->salesType->st_name . ' - ' . $do->salesType->st_abbr, ' ',
            $do->salesType->st_abbr . ' - ' . $do->salesType->st_name, ' ',
            $do->do_planned_datetime, ' ',
            $do->do_actual_datetime, ' ',
            __('dispatchorders.' . $do->do_status), ' ',
        ];
    }



    public function query()
    {
        return $this->injectedQuery;
    }
}
