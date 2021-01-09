<?php

namespace App\Http\Livewire\Sections\Addresses;

use Epigra\TrGeoZones\Models\Country;
use App\Models\Address;
use Epigra\TrGeoZones\Models\City;
use Livewire\Component;

class Form extends Component
{

    public $adr_name;
    public $adr_country;
    public $adr_province;
    public $adr_district;
    public $adr_body;
    
    public $adr_phone;
    public $adr_note;



    protected $rules = [
        'adr_name' => 'required|max:25',
        'adr_country' => 'required',
        'adr_province' => 'required', 
        'adr_district' => 'required',
        'adr_body' => 'required',

        'adr_phone' => 'nullable',
        'adr_note' => 'nullable',
    ];


    public function updatingAdrCountry() 
    {
        $this->resetAfterCountry();
        $this->emit('address_countryChanged');
        $this->updatedAdrProvince();
    }

    public function updatedAdrProvince()
    {
        $this->resetAfterProvince();
        $this->emit('address_provinceChanged');
    }

    
    
    public function getCountriesProperty()
    {
        return Country::all();
    }
    
    public function getCitiesProperty()
    {   
        if($this->adr_country)
            return Country::find($this->adr_country)->cities->toArray();
        return [];
    }

    public function getCityDistrictProperty()
    {
        if($this->adr_province)
            return City::find($this->adr_province)->districts->toArray();
        return [];
    }


    private function resetAfterCountry()
    {
        $this->reset('adr_province', 'adr_district');
    }

    private function resetAfterProvince()
    {
        $this->reset('adr_district');
    }


    public function render()
    {
        return view('livewire.sections.addresses.form');
    }

    public function submit()
    {
        Address::create($this->validate());
        $this->emit('toast','', __('addresses.address_added'), 'success');
    }


}
