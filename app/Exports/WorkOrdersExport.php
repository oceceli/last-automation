<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class WorkOrdersExport implements FromQuery
{

    use Exportable;

    private $injectedQuery;

    public function __construct(Builder $injectedQuery)
    {
        $this->injectedQuery = $injectedQuery;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return $this->injectedQuery;
    }
}
