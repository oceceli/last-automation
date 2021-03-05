<?php 

namespace App\Models\Traits\DispatchOrder;

use App\Stocks\DispatchTotalMove;

/**
 * Used by App\Models\DispatchOrder
 */
trait DispatchStates
{
    public static function states()
    {
        return [
            'approved',
            'completed',
            'in_progress',
            'active',
            'suspended',
        ];
    }


    public function isApproved()
    {
        return $this->checkStatus('approved');
    }


    public function isNotApproved()
    {
        return $this->isApproved();
    }


    public function isCompleted()
    {
        return $this->checkStatus('completed');
    }




    public function isFinalized() 
    {
        return $this->isCompleted() || $this->isApproved();
    }



    /**
     * finalize means completed or approved
     */
    public function isNotFinalized()
    {
        return ! $this->isFinalized();
        // return ! $this->isCompleted() && ! $this->isApproved();
    }



    /**
     * At least one of the products has started to load on a vehicle, that means this dispatch order is in progress
     * Keep database column in line by set it as in_progress
     */
    public function detectIsInProgress()
    {
        if($this->dispatchProducts()->where('dp_is_ready', true)->get()->isNotEmpty()) {
            $this->setInProgress();
            return true;
        } else {
            $this->activate();
            return false;
        }
    }


    public function isInProgress()
    {
        return $this->checkStatus('in_progress');
    }



    public function isActive()
    {
        return $this->checkStatus('active');
    }



    public function isSuspended()
    {
        return $this->checkStatus('suspended');
    }
    

    

    /**
     * Set status as approved and deduct reserved lots from stock
     */
    public function approve()
    {
        if($this->checkStatus('completed')) {
            (new DispatchTotalMove($this))->saveReserveds();
            $this->setStatus('approved');
            $this->markActualDispatchDate();
            $this->markReservationsAsArchived();
        }
    }


    public function deny()
    {
        if($this->checkStatus('completed')) {
            $this->setStatus('in_progress');
        }
    }


    public function setInProgress()
    {
        if($this->isActive())
            $this->setStatus('in_progress');
    }


    private function activate()
    {
        if($this->isSuspended() || $this->isInProgress())
            $this->setStatus('active');
    }


    public function suspend()
    {
        if($this->isActive())
            $this->setStatus('suspended');
    }


    public function markAsCompleted()
    {
        if($this->isAllReady() && $this->checkStatus('in_progress')) {
            $this->setStatus('completed');
        }
    }


    private function markActualDispatchDate()
    {
        $this->updateQuietly('do_actual_datetime', now());
    }






    private function setStatus($state)
    {
        if(in_array($state, self::states()))
            $this->updateQuietly('do_status', $state);
    }


    private function checkStatus($state)
    {
        return $this->do_status === $state;
    }


    private function markReservationsAsArchived()
    {
        foreach($this->reservedStocks as $reservation) {
            $reservation->update(['reserved_is_archived' => true]);
        }
    }

    private function updateQuietly($column, $value)
    {
        $this->$column = $value;
        $this->saveQuietly();
    }


    public function getStatusLookupAttribute()
    {
        return [
            'approved' => ['icon' => 'green double check icon', 'explanation' => __('dispatchorders.approved'), 'textColor' => 'text-green-600'],
            'completed' => ['icon' => 'red checkmark icon', 'explanation' => __('dispatchorders.completed'), 'textColor' => 'text-red-600'],
            'in_progress' => ['icon' => 'yellow loading cog icon', 'explanation' => __('dispatchorders.in_progress'), 'textColor' => 'text-yellow-500'],
            'active' => ['icon' => 'blue clock icon', 'explanation' => __('dispatchorders.active'), 'textColor' => 'text-blue-600'],
            'suspended' => ['icon' => 'grey ban icon', 'explanation' => __('dispatchorders.suspended'), 'textColor' => 'text-gray-600'],
        ][$this->do_status] ?? ['icon' => '', 'explanation' => '', 'textColor' => ''];
    }

}