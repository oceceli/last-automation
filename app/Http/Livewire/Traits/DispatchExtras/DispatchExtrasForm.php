<?php


namespace App\Http\Livewire\Traits\DispatchExtras;


trait DispatchExtrasForm
{
    // public $dispatch_order_id;
    public $de_license_plate;
    public $de_driver_name;
    public $de_driver_phone;
    public $de_dispatch_expense;
    public $de_handling_expense;

    public $extrasField = false;
    
    protected function deRules()
    {
        return [
            // 'dispatch_order_id' => 'required',
            'de_license_plate' => 'nullable|max:20',
            'de_driver_name' => 'nullable|max:30',
            'de_driver_phone' => 'nullable|digits_between:10,14',
            'de_dispatch_expense' => 'nullable',
            'de_handling_expense' => 'nullable',
        ];
    }


    private function deSubmit($dispatchOrder)
    {
        if($this->deShouldBeCreated()) {
            $data = $this->validate($this->deRules());
            $dispatchOrder->dispatchExtra()->create($data);
        }
    }



    private function deUpdate($dispatchExtra)
    {
        if($dispatchExtra) {
            if($this->deShouldBeCreated()) {
                $data = $this->validate($this->deRules());
                $dispatchExtra->update($data);
            } else { // if all empty, remove one to one related dispatchextra
                $dispatchExtra->delete();
            }
        } else {
            $this->deSubmit($this->dispatchOrder);
        }
    }



    /**
     * If any property is filled then it should be created
     */
    public function deShouldBeCreated() : bool
    {
        return ($this->de_license_plate || $this->de_driver_name || $this->de_driver_phone || $this->de_dispatch_expense || $this->de_handling_expense);
    }

    
    public function deSetEditMode($dispatchExtra)
    {
        if(!$dispatchExtra) return;
        $this->extrasField = true;
        // $this->dispatch_order_id = $dispatchExtra->dispatch_order_id;
        $this->de_license_plate = $dispatchExtra->de_license_plate;
        $this->de_driver_name = $dispatchExtra->de_driver_name;
        $this->de_driver_phone = $dispatchExtra->de_driver_phone;
        $this->de_dispatch_expense = $dispatchExtra->de_dispatch_expense;
        $this->de_handling_expense = $dispatchExtra->de_handling_expense;
    }

}
