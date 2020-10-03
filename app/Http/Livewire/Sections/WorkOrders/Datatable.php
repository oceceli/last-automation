<?php

namespace App\Http\Livewire\Sections\Workorders;

use App\Http\Livewire\Datatable as BaseDatatable;
use App\Models\WorkOrder;

class Datatable extends BaseDatatable
{

    protected $view = 'livewire.sections.workorders.datatable';

    public $model = WorkOrder::class;



    public function show($id) 
    {
        redirect()->route('work-orders.show', ['work_order' => $id]);
    }

    // public $attributes = [
    //     'lot_no', 
    //     'recipe_id', 
    //     'amount', 
    //     'datetime', 
    //     'code', 
    //     'queue', 
    //     'is_active', 
    //     'in_progress', 
    //     'note', 
    // ];

}
