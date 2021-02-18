<?php

namespace App\Models\Traits\WorkOrder;

use Carbon\Carbon;

trait WorkOrderStates
{
    private $states = [
        'approved',
        'completed',
        'in_progress',
        'prepared',
        'preparing',
        'active',
        'suspended',
    ];

    private $permission = 'process workorders'; // !! kullanılmıyor



    public function isApproved()
    {
        return $this->checkStatus('approved');
    }

    public function isCompleted()
    {
        return $this->checkStatus('completed') && $this->wo_completed_at;
    }

    public function isInProgress()
    {
        return $this->checkStatus('in_progress') && isset($this->wo_started_at);
    }

    public function isPrepared()
    {
        return $this->checkStatus('prepared');
    }

    public function isPreparing()
    {
        return $this->checkStatus('preparing');
    }

    public function isActive()
    {
        return $this->checkStatus('active');
    }

    public function isSuspended()
    {
        return $this->checkStatus('suspended');
    }




    public function approve()
    {
        if($this->isCompleted()) {
            return $this->setStatus('approved');
            // todo: stoktan düşme işlemleri
            // !! finalize traite bak
        }
    }

    public function complete()
    {
        if($this->isInProgress()) {
            $this->update(['wo_completed_at' => now()]);
            return $this->setStatus('completed');
        }
    }

    public function setInProgress()
    {

        if($this->isActive() && ! $this->isInProgress()) {
            $this->setStatus('in_progress');
            $this->update(['wo_started_at' => now()]);
            return true;
        }
    }

    public function setPrepared()
    {
        if($this->isPreparing() && $this->areAllReady()) {
            return $this->setStatus('prepared');
        }
    }

    public function setPreparing()
    {
        if(($this->isActive() || $this->isPrepared()) && $this->reservedStocks->isNotEmpty()) {
            return $this->setStatus('preparing');
        }
    }

    public function activate()
    {
        if($this->isPreparing() || $this->isSuspended())
            return $this->setStatus('active');
    }

    public function suspend()
    {
        if($this->isActive()) {
            return $this->setStatus('suspended');
        }
    }

    public function unsuspend()
    {
        if($this->isSuspended()) {
            return $this->setStatus('active');
        }
    }


    public function abort()
    {
        if($this->isInProgress()) {
            $this->setStatus('active');
            $this->update(['wo_started_at' => null]);
            $this->reservedStocks()->delete();
            return true;
        }
    }






    public function startedAt()
    {
        return $this->isInProgress() ? $this->wo_started_at : null;
    }


    public function completedAt()
    {
        return $this->isCompleted() ? $this->wo_completed_at : null;
    }

    public function isToday()
    {
        return $this->wo_datetime == Carbon::today()->format('d.m.Y');
    }






    private function checkStatus($state)
    {
        return $this->wo_status === $state;
    }

    private function setStatus($state)
    {
        if(auth()->user()->cannot($this->permission)) abort(403); // ?? devam

        if(in_array($state, $this->states)) {
            $this->update(['wo_status' => $state]);
            return true;
        }
        return false;
    }




    public function getStatusColorAttribute()
    {
        return [
            'approved' => 'green',
            'completed' => 'green',
            'in_progress' => 'yellow',
            'active' => 'blue',
            'suspended' => 'gray',
        ][$this->wo_status] ?? null;
    }


}