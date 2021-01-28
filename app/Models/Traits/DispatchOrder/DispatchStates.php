<?php 

namespace App\Models\Traits\DispatchOrder;


/**
 * Used by App\Models\DispatchOrder
 */
trait DispatchStates
{
    private $states = [
        'active',
        'suspended',
        'in_progress', // not in database
        'completed',
        'approved',
    ];



    public function isActive()
    {
        return $this->do_status === 'active';
    }

    public function isSuspended()
    {
        return $this->do_status === 'suspended';
    }
    

    /**
     * At least one of the products has started to load on a vehicle, that means this dispatch order is in progress
     */
    public function isInProgress()
    {
        // if($this->dispatchProducts()->where('dp_is_ready', true)->get()->isNotEmpty()) {
        //     $this->setStatus('in_progress');
        //     return true;
        // }
        return $this->dispatchProducts()
            ->where('dp_is_ready', true)
            ->get()
            ->isNotEmpty();
    }

    public function isCompleted()
    {
        return $this->do_status === 'completed';
    }

    public function isNotCompleted()
    {
        return ! $this->isCompleted();
    }
    

    public function isApproved()
    {
        return $this->do_status === 'approved';
    }




    public function suspend()
    {
        $this->setStatus('suspended');
    }


    public function markAsCompleted()
    {
        $this->setStatus('completed');
    }







    private function setStatus($state)
    {
        if(in_array($state, $this->states))
            $this->update(['do_status' => $state]);
    }


}