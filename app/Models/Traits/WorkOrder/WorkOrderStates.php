<?php

namespace App\Models\Traits\WorkOrder;

use App\Services\WorkOrder\WorkOrderCompleteService;
use Carbon\Carbon;

trait WorkOrderStates
{
    // private $states = [
    //     'approved',
    //     'completed',
    //     'in_progress',
    //     'prepared',
    //     'preparing',
    //     'active',
    //     'suspended',
    // ];

    // private $permission = 'process workorders'; // !! kullanılmıyor


    public static function states()
    {
        return [
            'approved',
            'completed',
            'in_progress',
            'prepared',
            'preparing',
            'active',
            'suspended',
        ];
    }


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

    public function getStatus()
    {
        return $this->wo_status;
    }



    public function deny()
    {
        if($this->isCompleted()) {
            $this->stockMoves()->delete();
            return $this->setStatus('in_progress');
        }
    }

    public function approve()
    {
        if($this->isCompleted()) {
            $this->stockMoves()->update(['approved' => true]);
            $this->reservedStocks()->delete();
            return $this->setStatus('approved');
        }
    }

    public function complete(WorkOrderCompleteService $service)
    {
        if($this->isInProgress()) {
            $service->saveProductionResults();
            $this->updateQuietly('wo_completed_at', now());
            return $this->setStatus('completed');
        }
    }

    public function setInProgress()
    {

        if($this->isPrepared()) {
            $this->setStatus('in_progress');
            $this->updateQuietly('wo_started_at', now());
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
        if(($this->isActive() || $this->isPrepared()) && $this->anyPreparing()) {
            return $this->setStatus('preparing');
        } 
    }

    public function activate()
    {
        if(($this->isPreparing() && ! $this->anyPreparing()) || $this->isSuspended())
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
            $this->setStatus('prepared');
            $this->updateQuietly('wo_started_at', null);
            return true;
        }
    }






    public function startedAt()
    {
        return $this->isInProgress() ? $this->wo_started_at : null;
    }


    public function completedAt()
    {
        return $this->isCompleted() || $this->isApproved() ? $this->wo_completed_at : null;
    }

    public function isToday()
    {
        return $this->wo_datetime == Carbon::today()->format('d.m.Y');
    }

    private function anyPreparing()
    {
        return $this->reservedStocks()->exists();
    }






    private function checkStatus($state)
    {
        return $this->wo_status === $state;
    }

    private function setStatus($state)
    {
        // if(auth()->user()->cannot($this->permission)) abort(403); // ?? devam

        if(in_array($state, self::states())) {
            $this->updateQuietly('wo_status', $state);
            return true;
        }
        return false;
    }

    private function updateQuietly($column, $value)
    {
        $this->$column = $value;
        $this->saveQuietly();
    }




    // public function getStatusColorAttribute()
    // {
    //     return [
    //         'approved' => 'green',
    //         'completed' => 'green',
    //         'in_progress' => 'yellow',
    //         'active' => 'blue',
    //         'suspended' => 'gray',
    //     ][$this->wo_status] ?? null;
    // }


    public function getStatusLookupAttribute()
    {
        return [
            'approved' => ['icon' => 'green double check icon', 'explanation' => __('common.approved'), 'textColor' => 'text-green-600'],
            'completed' => ['icon' => 'red checkmark icon', 'explanation' => __('workorders.production_is_completed'), 'textColor' => 'text-red-600'],
            'in_progress' => ['icon' => 'yellow loading cog icon', 'explanation' => __('workorders.in_progress'), 'textColor' => 'text-yellow-500'],
            'prepared' => ['icon' => 'purple pause icon', 'explanation' => __('workorders.prepared'), 'textColor' => 'text-purple-600'],
            'preparing' => ['icon' => 'blue loading clock icon', 'explanation' => __('workorders.preparing'), 'textColor' => 'text-blue-600'],
            'active' => ['icon' => 'blue clock icon', 'explanation' => __('workorders.waiting_for_production'), 'textColor' => 'text-blue-600'],
            'suspended' => ['icon' => 'grey ban icon', 'explanation' => __('common.suspended'), 'textColor' => 'text-gray-600'],
        ][$this->wo_status] ?? ['icon' => '', 'explanation' => '', 'textColor' => ''];
    }

}