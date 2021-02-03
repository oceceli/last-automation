<?php

namespace App\Http\Livewire\DispatchOrders;

use App\Http\Livewire\Traits\DispatchOrders\SpecifyProducts;
use App\Models\Company;
use App\Models\DispatchOrder;
use Carbon\Carbon;
use Livewire\Component;

class Form extends Component
{
    use SpecifyProducts;
    
    // dispatchorders attributes
    public $company_id;
    public $address_id;
    public $do_number;
    public $do_datetime;
    public $do_note; // !! note alanı forma eklenecek

    public $selectedCompany;

    private $dispatchOrder; // ?? kullanılmıyor şu an
    private $editMode = true;

    protected function rules()
    {
        return [
            'company_id' => 'required|integer',
            'address_id' => 'required|integer',
            'do_number' => 'required|numeric',
            'do_datetime' => 'required|date',
            'do_note' => 'nullable',
        ];
    }




    protected function validationAttributes() 
    {
        $array = [];
        $array = array_merge($array, $this->spValidationAttributes);
        return $array;
    }

    

    
    public function mount($dispatchOrder = null)
    {
        if($dispatchOrder) {
            $this->dispatchOrder = $dispatchOrder;
            $this->setEditMode($dispatchOrder);
        } else {
            $this->do_datetime = Carbon::today();
            $this->addCard();
        }
    }
    



    public function updatedCompanyId($id)
    {
        $this->selectedCompany = Company::findOrFail($id);
        $this->emit('do_company_selected');
    }




    public function getCompanyAddressesProperty()
    {
        return $this->selectedCompany->addresses->toArray();
    }

    


    public function getCompaniesProperty()
    {
        return Company::all();
    }


    

    public function submit()
    {
        $validatedDoData = $this->validate();

        // spRules refers to SpecifyProduct trait's rules
        $this->validate($this->spRules);
        
        $dispatchOrder = DispatchOrder::create($validatedDoData);

        if($this->spSubmit($dispatchOrder)) {
            session()->flash('success', __('dispatchorders.dispatchorder_created'));
            return redirect()->route('dispatchorders.index');
        }
    }




    private function setEditMode($dispatchOrder)
    {
        $this->editMode = true;

        $this->company_id = $dispatchOrder->company_id;
        $this->address_id = $dispatchOrder->address_id;
        $this->do_number = $dispatchOrder->do_number;
        $this->do_datetime = $dispatchOrder->do_datetime;
        $this->do_note = $dispatchOrder->do_note;

        $this->spProductsEditMode($dispatchOrder);
    }



    public function render()
    {
        return view('livewire.dispatch-orders.form');
    }
}
