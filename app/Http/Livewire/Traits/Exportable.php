<?php

namespace App\Http\Livewire\Traits;

use App\Common\Helpers\Generic;

trait Exportable
{ 

    private function getExportablePath()
    {
        return 'App\\Exports\\' . Generic::removePath(Generic::plural($this->model)).'Export';
    }

    public function exportToExcel()
    {
        $export = $this->getExportablePath();
        return (new $export($this->filteredQuery()))->download();
    }

    public function exportToPDF()
    {
        $export = $this->getExportablePath();
        return (new $export($this->filteredQuery(), 'pdf'))->download(null, \Maatwebsite\Excel\Excel::MPDF);
    }

    
}