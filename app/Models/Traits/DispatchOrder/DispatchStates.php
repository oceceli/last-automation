<?php 

namespace App\Models\Traits\DispatchOrder;


/**
 * Used by App\Models\DispatchOrder
 */
trait DispatchStates
{
    private $states = [
        'approved',
        'completed',
        'in_progress',
        'active',
        'suspended',
    ];



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


    public function isNotCompleted()
    {
        return ! $this->isCompleted() && ! $this->checkStatus('approved');
    }


    /**
     * At least one of the products has started to load on a vehicle, that means this dispatch order is in progress
     * Keep database column in line by set it as in_progress
     */
    public function isInProgress()
    {
        if($this->dispatchProducts()->where('dp_is_ready', true)->get()->isNotEmpty()) {
            $this->setInProgress();
            return true;
        } else {
            $this->activate();
            return false;
        }
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
        if($this->checkStatus('completed')) {
            $this->setStatus('approved');
            // !! Stoktan düşürme işlemi bu kısımda yapılmalı
        }
    }


    public function deny()
    {
        if($this->checkStatus('completed')) {
            $this->setStatus('in_progress');
        }
    }


    private function setInProgress()
    {
        if($this->checkStatus('is_active'))
            $this->setStatus('in_progress');
    }


    private function activate()
    {
        $this->setStatus('active');
    }


    public function suspend()
    {
        if($this->checkStatus('active'))
            $this->setStatus('suspended');
    }


    public function markAsCompleted()
    {
        if($this->isAllReady()) {
            $this->setStatus('completed');
        }
    }







    private function setStatus($state)
    {
        if(in_array($state, $this->states))
            $this->update(['do_status' => $state]);
    }


    private function checkStatus($state)
    {
        return $this->do_status === $state;
    }


}