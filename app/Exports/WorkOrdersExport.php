<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WorkOrdersExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize, WithStyles, WithProperties
{

    use Exportable, RegistersEventListeners;

    private $injectedQuery;

    
    public function __construct(Builder $injectedQuery)
    {
        $this->injectedQuery = $injectedQuery;
    }


    public function headings() : array
    {
        return [
            __('validation.attributes.wo_code'),
            __('validation.attributes.wo_queue'),
            __('products.name'),
            __('validation.attributes.wo_amount'),
            __('validation.attributes.wo_lot_no'),
            __('validation.attributes.wo_datetime'),

            __('validation.attributes.wo_completed_at'),
            // __('validation.attributes.wo_status'),
        ];
    }
    

    public function map($workOrder) : array
    {
        return [
            $workOrder->wo_code,
            $workOrder->wo_queue,
            $workOrder->product->prd_name,
            $workOrder->wo_amount . ' ' . $workOrder->unit->name,
            $workOrder->wo_lot_no,
            $workOrder->wo_datetime->format('d.m.Y'),
            optional($workOrder->wo_completed_at)->format('d.m.Y H:i:s'),
        ];
    }


    
    public function query()
    {
        return $this->injectedQuery;
    }



    public function properties(): array
    {
        return [
            'creator'        => auth()->user()->name,
            'lastModifiedBy' => auth()->user()->name,
            'title' => 'İş emirleri - Çıktı alındı: ' . now()->format('d.m.Y H:i:s'),
        ];
    }

    


    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }



}
