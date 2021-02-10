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
    
    protected function rules()
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


    public function deSubmit($dispatchOrder)
    {
        if($this->shouldBeCreated()) {
            $data = $this->validate();
            $dispatchOrder->dispatchExtra()->create($data);
        }
    }

    private function deUpdate($dispatchExtra)
    {
        if($dispatchExtra) {
            $data = $this->validate();
            $dispatchExtra->update($data);
        } else {
            $this->deSubmit($dispatchExtra->dispatchOrder);
        }
    }

    private function shouldBeCreated() : bool
    {
        return true;
    }

    public function deSetEditMode($dispatchExtra)
    {
        // $this->dispatch_order_id = $dispatchExtra->dispatch_order_id;
        $this->de_license_plate = $dispatchExtra->de_license_plate;
        $this->de_driver_name = $dispatchExtra->de_driver_name;
        $this->de_driver_phone = $dispatchExtra->de_driver_phone;
        $this->de_dispatch_expense = $dispatchExtra->de_dispatch_expense;
        $this->de_handling_expense = $dispatchExtra->de_handling_expense;
    }

}
