<?php

namespace App\Http\Livewire\Traits\Polymorphic;


trait AddressForm
{

    public $adr_name;
    public $adr_country;
    public $adr_province;
    public $adr_district;
    public $adr_body;
    
    public $adr_phone;
    public $adr_note;

    // public $addressable_type;
    public $addressable_id;


    protected $rules = [
        'adr_name' => 'required|max:25',
        'adr_country' => 'required',
        'adr_province' => 'required',
        'adr_district' => 'required',
        'adr_body' => 'required|max:255',

        'adr_phone' => 'nullable|digits_between:10,14',
        'adr_note' => 'nullable|max:255',
    ];

    private function clearFields()
    {
        $this->reset('adr_name', 'adr_country', 'adr_province', 'adr_district', 'adr_body', 'adr_phone', 'adr_note');
    }

    public function addressSubmit()
    {
        // $this->adr_country = $this->getCountriesProperty()->find($this->adr_country)->name;
        $model = $this->model::find($this->addressable_id);

        $model->addresses()->create($this->validate());

        $this->emit('toast','', __('addresses.address_added'), 'success');
        $this->reset();
    }


    // public function updatingAdrCountry() 
    // {
    //     $this->resetAfterCountry();
    //     $this->emit('address_countryChanged');
    //     $this->updatedAdrProvince();
    // }

    // public function updatedAdrProvince()
    // {
    //     $this->reset('adr_district');
    // }
    
    
    
    // public function getCountriesProperty()
    // {
    //     return Country::all();
    // }
    
    // public function getCitiesProperty()
    // {   
    //     if($this->adr_country)
    //         return Country::find($this->adr_country)->cities->toArray();
    //     return [];
    // }

    // public function getCityDistrictProperty()
    // {
    //     if($this->adr_province)
    //         return City::find($this->adr_province)->districts->toArray();
    //     return [];
    // }


    // private function resetAfterCountry()
    // {
    //     $this->reset('adr_province', 'adr_district');
    // }


    


}
