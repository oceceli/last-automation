<?php

namespace App\Http\Livewire\DispatchOrders;

use App\Http\Livewire\Traits\DispatchExtras\DispatchExtrasForm;
use App\Http\Livewire\Traits\DispatchOrders\SpecifyProducts;
use App\Http\Livewire\Traits\SalesTypeTrait;
use App\Models\Company;
use App\Models\DispatchOrder;
use App\Models\SalesType;
use Carbon\Carbon;
use Livewire\Component;

class Form extends Component
{
    use SpecifyProducts;
    use SalesTypeTrait;
    use DispatchExtrasForm;
    
    // dispatchorders attributes
    public $company_id;
    public $address_id;
    public $sales_type_id;
    public $do_number;
    public $do_planned_datetime;
    public $do_note;

    public $selectedCompany;
    public $companyAddresses = [];

    public $dispatchOrder;
    public $editMode = false;


    protected $listeners = ['st_updated' => 'salesTypeUpdated', 'refresh' => '$refresh'];

    protected function rules()
    {
        return [
            'company_id' => 'required|integer',
            'address_id' => 'required|integer',
            'sales_type_id' => 'required|integer',
            'do_number' => 'required|numeric|unique:dispatch_orders,do_number,' . optional($this->dispatchOrder)->id,
            'do_planned_datetime' => 'required|date',
            'do_note' => 'nullable',
        ];
    }


    public function salesTypeUpdated($salesTypeId = null)
    {
        if($salesTypeId) {
            $this->sales_type_id = $salesTypeId;
        } else {
            $this->sales_type_id = null;
        }
    }



    protected function validationAttributes() 
    {
        $array = [];
        $array = array_merge($array, $this->spValidationAttributes());
        return $array;
    }

    

    
    public function mount($dispatchOrder = null)
    {
        if($dispatchOrder) {
            $this->setEditMode($dispatchOrder);
        } else {
            $this->do_planned_datetime = Carbon::today();
            $this->addCard();
        }
    }
    



    public function updatedCompanyId($id)
    {
        $this->selectedCompany = Company::findOrFail($id);
        $this->companyAddresses = $this->selectedCompany->addresses->toArray();

        $this->emit('do_company_selected');
    }

 


    public function getCompaniesProperty()
    {
        return Company::all();
    }


    public function getSalesTypesProperty()
    {
        return SalesType::all()->toArray();
    }


    

    public function submit()
    {
        if(!$this->cards) return;
        $validatedDoData = $this->validate();
        
        // spRules refers to SpecifyProduct trait's rules
        $this->validate($this->spRules);
        
        if($this->editMode === true) {
            if( ! ($this->dispatchOrder->isSuspended() || $this->dispatchOrder->isActive())) abort(404);

            $this->dispatchOrder->dispatchProducts()->delete();
            $this->dispatchOrder->update($validatedDoData);
            
            $this->deUpdate($this->dispatchOrder->dispatchExtra); // dispatchextra
            $this->spSubmit($this->dispatchOrder);

            session()->flash('success', __('dispatchorders.do_number_dispatchorder_updated', ['do_number' => $this->dispatchOrder->do_number]));
        } 
        
        else {
            $dispatchOrder = DispatchOrder::create($validatedDoData);

            $this->deSubmit($dispatchOrder); // dispatchextra
            $this->spSubmit($dispatchOrder); // dispatchproducts
            
            session()->flash('success', __('dispatchorders.dispatchorder_created'));
        }

        return redirect()->route('dispatchorders.index');
    }




    private function setEditMode($dispatchOrder)
    {
        $this->editMode = true;
        $this->dispatchOrder = $dispatchOrder;
        
        $this->company_id = $dispatchOrder->company_id;
        $this->address_id = $dispatchOrder->address_id;
        $this->sales_type_id = $dispatchOrder->sales_type_id;
        $this->do_number = $dispatchOrder->do_number;
        $this->do_planned_datetime = $dispatchOrder->do_planned_datetime;
        $this->do_note = $dispatchOrder->do_note;
        
        // fill in the address dropdown
        $this->updatedCompanyId($dispatchOrder->company_id);
        
        $this->spProductsEditMode($dispatchOrder);
        $this->deSetEditMode($dispatchOrder->dispatchExtra);
    }



    public function render()
    {
        return view('livewire.dispatch-orders.form');
    }
}
