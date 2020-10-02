<?php

namespace App\Http\Livewire\Sections\Workorders;

use App\Http\Livewire\Datatable as BaseDatatable;

class Datatable extends BaseDatatable
{

    protected $view = 'livewire.sections.workorders.index';

    public $attributes = [
        'recipe_id', 
        'lot_no', 
        'amount', 
        'datetime', 
        'code', 
        'queue', 
        'is_active', 
        'in_progress', 
        'note', 
    ];


}
