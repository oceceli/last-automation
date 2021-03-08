<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DispatchOrderDetailedExport extends BaseExport implements FromQuery, WithHeadings, WithMapping
{

    protected $fileName = 'Sevkiyat';


    public function __construct(Builder $query)
    {
        $this->injectedQuery = $query;
    }


    public function headings() : array
    {
        return [
            __('validation.attributes.do_number'),
            __('validation.attributes.company_id'),
            __('dispatchorders.dispatch_address'),
            __('validation.attributes.sales_type_id'),
            __('validation.attributes.do_planned_datetime'),
            __('validation.attributes.do_actual_datetime'),
            __('validation.attributes.do_status'),

            __('validation.attributes.de_license_plate'),
            __('validation.attributes.de_driver_name'),
            __('validation.attributes.de_driver_phone'),
            __('validation.attributes.de_dispatch_expense'),
            __('validation.attributes.de_handling_expense'),
        ];
    }


    public function map($do) : array
    {
        $arr = [
            $do->do_number,
            $do->company->cmp_commercial_title,
            $do->address->fullAddress,
            $do->salesType->st_abbr . ' - ' . $do->salesType->st_name,
            $do->do_planned_datetime,
            $do->do_actual_datetime,
            __('dispatchorders.' . $do->do_status),
        ];

        if($do->dispatchExtra()->exists()) {
            $arr = array_merge($arr, [
                $do->dispatchExtra->de_license_plate ?? __('common.not_specified'),
                $do->dispatchExtra->de_driver_name ?? __('common.not_specified'),
                $do->dispatchExtra->de_driver_phone ?? __('common.not_specified'),
                $do->dispatchExtra->de_dispatch_expense ?? __('common.not_specified'),
                $do->dispatchExtra->de_handling_expense ?? __('common.not_specified'),
            ]);
        }

        return $arr;

    }


    
    public function query()
    {
        return $this->injectedQuery;
    }



    // public function styles(Worksheet $sheet)
    // {
    //     // $sheet->mergeCells('A1:O1');
    //     return [
    //         1 => ['font' => ['bold' => true]],
    //     ];
    // }
}
