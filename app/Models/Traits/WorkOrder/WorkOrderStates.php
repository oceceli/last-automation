<?php

namespace App\Models\Traits\WorkOrder;


trait WorkOrderStates
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

    public function isCompleted()
    {
        return $this->checkStatus('completed') && $this->wo_completed_at;
    }

    public function isInProgress()
    {
        return $this->checkStatus('in_progress') && isset($this->wo_started_at);
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
        $this->setStatus('approved');
    }

    public function complete()
    {
        $this->setStatus('completed');
    }

    public function setInProgress()
    {
        $this->setStatus('in_progress');
    }

    public function activate()
    {
        $this->setStatus('active');
    }

    public function suspend()
    {
        $this->setStatus('suspended');
    }




    public function checkStatus($state)
    {
        return $this->wo_status === $state;
    }

    public function setStatus($state)
    {
        if(in_array($state, $this->states))
            $this->update(['wo_status' => $state]);
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