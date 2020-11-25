<?php

namespace App\Http\Livewire\Sections\Inventory;

use App\Http\Livewire\Datatable as BaseDatatable;
use App\Models\StockMove;

class Datatable extends BaseDatatable
{
    public $model = StockMove::class;
    protected $view = 'livewire.sections.inventory.datatable';

    
}
