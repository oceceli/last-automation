<?php

namespace App\Http\Livewire\DispatchOrders;

use App\Http\Livewire\Traits\Dispatchorders\SpecifyProducts;
use App\Models\Company;
use App\Models\DispatchOrder;
use Carbon\Carbon;
use Livewire\Component;

class Form extends Component
{
    use SpecifyProducts;
    // use SpecifyLots;
    
    // public $do_are_lots_specified = false; // sevk emri oluştururken lotları seçmek istersen bunu true yap, ekstra bir form gerekecek muhtemelen

    // dispatchorders attributes
    public $company_id;
    public $address_id;
    public $do_number;
    public $do_datetime;
    public $do_note; // !! note alanı forma eklenecek

    public $selectedCompany;

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

    
    public function mount()
    {
        $this->do_datetime = Carbon::today();
        $this->addCard();
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


    public function render()
    {
        return view('livewire.dispatch-orders.form');
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
        // else {
        //     $this->emit('toast', __('common.error_occurred'), __('dispatchorders.an_error_occurred_while_creating_dispatchorder_please_reload_page_and_try_again'), 'error'); 
        //     $dispatchOrder->delete();
        // }

    }
}
