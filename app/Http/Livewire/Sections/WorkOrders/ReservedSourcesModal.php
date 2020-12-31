<?php

namespace App\Http\Livewire\Sections\WorkOrders;


trait ReservedSourcesModal
{
    public $reservedSourcesModal = false;
    public $reservedSourcesData;

    public function showReservedSources($id)
    {
        $this->reservedSourcesModal = true;
        $this->reservedSourcesData = $this->workOrders->find($id);
    }
}