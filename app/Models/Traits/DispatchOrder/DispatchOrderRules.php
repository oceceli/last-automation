<?php 

namespace App\Models\Traits\DispatchOrder;

trait DispatchOrderRules
{
    // !! eksik

    public function isDeletable() : bool
    {
        return ! ($this->isInProgress() || $this->isCompleted() || $this->isApproved());
    }
    
    /**
     * @override
     */
    public static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            return true;
        });

        static::deleting(function ($model) {
            return $model->isDeletable();
        });
    }
}