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
        if($this->filteredQuery()->get()->isEmpty()) return $this->informQueryEmpty();
        $export = $this->getExportablePath();
        return (new $export($this->filteredQuery()))->download();
    }

    public function exportToPDF()
    {
        if($this->filteredQuery()->get()->isEmpty()) return $this->informQueryEmpty();
        $export = $this->getExportablePath();
        return (new $export($this->filteredQuery(), 'pdf'))->download(null, \Maatwebsite\Excel\Excel::MPDF);
    }


    private function informQueryEmpty()
    {
        $this->emit('toast', '', __('common.no_results'), 'error');
    }
    
}