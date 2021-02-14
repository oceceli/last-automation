<?php

namespace App\Http\Livewire;

trait RefreshSil
{
    protected function refresh()
    {
        $this->emitSelf('refresh');
    }
    
}