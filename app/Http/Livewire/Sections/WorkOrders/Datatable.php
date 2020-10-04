<?php

namespace App\Http\Livewire\Sections\WorkOrders;

use App\Http\Livewire\Datatable as BaseDatatable;
use App\Models\WorkOrder;

class Datatable extends BaseDatatable
{

    protected $view = 'livewire.sections.workorders.datatable';

    public $model = WorkOrder::class;




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
