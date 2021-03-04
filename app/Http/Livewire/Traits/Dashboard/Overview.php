<?php

namespace App\Http\Livewire\Traits\Dashboard;

use App\Services\Dispatch\DispatchService;
use App\Services\StockMove\StockMoveService;
use App\Services\WorkOrder\WorkOrderService;
use Carbon\Carbon;

trait Overview
{
    // models
    public $woFrq = 'week';
    public $doFrq = 'week';
    public $smFrq = 'week';


    public function daysFrequency($frq)
    {
        return [
            'week' => 'week', 
            'month' => 'month',
            'year' => 'year',
        ][$frq] ?? null;
    }

    // !! hafta ay kısmını kullanıcının ayarlarına kaydet

    public function woCountOverview()
    {

        if($this->daysFrequency($this->woFrq) == 'week') {
            return WorkOrderService::getApprovedCountBetween(Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek());
        } elseif($this->daysFrequency($this->woFrq) == 'month') {
            return WorkOrderService::getApprovedCountBetween(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());
        } elseif($this->daysFrequency($this->woFrq) == 'year') {
            return WorkOrderService::getApprovedCountBetween(Carbon::now()->startOfYear(), Carbon::now()->endOfYear());
        } else return 0;

    }
    
    
    public function doCountOverview()
    {
        if($this->daysFrequency($this->doFrq) == 'week') {
            return DispatchService::getApprovedCountBetween(Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek());
        } elseif($this->daysFrequency($this->doFrq) == 'month') {
            return DispatchService::getApprovedCountBetween(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());
        } elseif($this->daysFrequency($this->doFrq) == 'year') {
            return DispatchService::getApprovedCountBetween(Carbon::now()->startOfYear(), Carbon::now()->endOfYear());
        } else return 0;
    }
    
    
    
    public function smCountOverview()
    {
        if($this->daysFrequency($this->smFrq) == 'week') {
            return StockMoveService::getApprovedCountBetween(Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek());
        } elseif($this->daysFrequency($this->smFrq) == 'month') {
            return StockMoveService::getApprovedCountBetween(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());
        } elseif($this->daysFrequency($this->smFrq) == 'year') {
            return StockMoveService::getApprovedCountBetween(Carbon::now()->startOfYear(), Carbon::now()->endOfYear());
        } else return 0;
    }
}