<div>
    <form wire:submit.prevent="addressSubmit" class="ui tiny form">
        <div class="px-6 pb-6 pt-4 border-b shadow">
            <x-input defer model="adr_name" label="validation.attributes.adr_name" placeholder="validation.attributes.adr_name" class="required" />
        </div>
        <x-form-divider>
            <x-slot name="left">
                
                <x-input defer model="adr_country" label="validation.attributes.adr_country" placeholder="validation.attributes.adr_country" class="required" />
                <x-input defer model="adr_province" label="validation.attributes.adr_province" placeholder="validation.attributes.adr_province" class="required" />
                <x-input defer model="adr_district" label="validation.attributes.adr_district" placeholder="validation.attributes.adr_district" class="required" />

                {{-- <x-dropdown model="adr_country" :collection="$this->countries" value="id" text="name" sId="countries" sClass="search" 
                    label="validation.attributes.adr_country" placeholder="validation.attributes.adr_country" class="required field"
                /> --}}

                {{-- <x-dropdown model="adr_province" initnone dataSourceFunction="getCitiesProperty" value="name" text="name" sId="cities" sClass="search" triggerOnEvent="address_countryChanged"
                    label="validation.attributes.adr_province" placeholder="validation.attributes.adr_province" class="required field"
                /> --}}


                {{-- <x-dropdown model="adr_district" initnone dataSourceFunction="getCityDistrictProperty" value="id" text="ilce,mahalle,semt,posta_kodu" sId="districts" sClass="search" triggerOnEvent="address_provinceChanged"
                    label="validation.attributes.adr_district" placeholder="validation.attributes.adr_district" class="required field"
                /> --}}
            </x-slot>

            <x-slot name="right">
                <div class="field">
                    <label><i class="write icon"></i>{{ __('validation.attributes.adr_body' )}}</label>
                    <textarea wire:model.defer="adr_body" rows="3"></textarea>
                </div>
            
                {{-- <x-input defer model="adr_note" label="validation.attributes.adr_note" placeholder="validation.attributes.adr_note"  /> --}}
                
                <x-input defer model="adr_phone" label="validation.attributes.adr_phone" placeholder="validation.attributes.adr_phone"  />
            </x-slot>
            

            <x-slot name="bottom">
                <div x-data="{addAddressNote: false}">
                    <div x-show="!addAddressNote">
                        <i class="write icon"></i>
                        <span class="cursor-pointer pt-1 text-gray-400 text-sm font-bold ease-in-out duration-200 hover:text-gray-600" @click="addAddressNote = true">{{ __('common.add_note') }}</span>
                    </div>
                    <div x-show="addAddressNote" class="field">
                        <label><i class="write icon"></i>{{ __('validation.attributes.adr_note' )}}</label>
                        <textarea wire:model.defer="adr_note" rows="3"></textarea>
                    </div>
                </div>
            </x-slot>
            
        </x-form-divider>
    </form>
</div>
