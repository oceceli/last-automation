<?php

namespace App\Http\Livewire;

trait Refresh
{
    protected function refresh()
    {
        $this->emitSelf('refresh');
    }
    
}