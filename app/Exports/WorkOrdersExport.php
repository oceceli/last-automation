<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class WorkOrdersExport extends BaseExport implements FromQuery, WithMapping, WithHeadings
{

    public $fileName = 'İş Emirleri';
    
    public function __construct(Builder $injectedQuery)
    {
        $this->injectedQuery = $injectedQuery;
    }


    protected function title() : string
    {
        return 'İş emirleri - Çıktı tarihi: ' . now()->format('d.m.Y');
    }

    
    public function headings() : array
    {
        return [
            __('validation.attributes.wo_code'), '',
            __('validation.attributes.wo_queue'), '',
            __('products.name'), '',
            __('validation.attributes.wo_amount'), '',
            __('validation.attributes.wo_lot_no'), '',
            __('validation.attributes.wo_datetime'), '',
            __('validation.attributes.wo_completed_at'), '',
            __('validation.attributes.wo_status'), '',
        ];
    }
    

    public function map($workOrder) : array
    {
        return [
            $workOrder->wo_code,  '',
            $workOrder->wo_queue,  '',
            $workOrder->product->prd_name,  '',
            $workOrder->wo_amount . ' ' . $workOrder->unit->name,  '',
            $workOrder->wo_lot_no,  '',
            $workOrder->wo_datetime->format('d.m.Y'),  '',
            optional($workOrder->wo_completed_at)->format('d.m.Y H:i:s'),  '',
            __('workorders.' . $workOrder->wo_status), '',
        ];
    }


    
    public function query()
    {
        return $this->injectedQuery;
    }

}
