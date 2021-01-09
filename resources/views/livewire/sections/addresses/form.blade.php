<div>
    <x-content>
        <x-slot name="header">
            <x-page-header icon="book" header="{{ __('addresses.create_address') }}">

            </x-page-header>

        </x-slot>
        <form wire:submit.prevent="submit" class="ui tiny form">
            <x-form-divider>


                <x-slot name="left">
                    <x-input model="adr_name" label="validation.attributes.adr_name" placeholder="validation.attributes.adr_name" class="required" />

                    <x-dropdown model="adr_country" :collection="$this->countries" value="id" text="name" sId="countries" sClass="search"
                        label="validation.attributes.adr_country" placeholder="validation.attributes.adr_country" class="required field"
                    />

                    <x-dropdown model="adr_province" initnone dataSourceFunction="getCitiesProperty" value="id" text="name" sId="cities" sClass="search" triggerOnEvent="address_countryChanged"
                        label="validation.attributes.adr_province" placeholder="validation.attributes.adr_province" class="required field"
                    />

                    <x-dropdown model="adr_district" initnone dataSourceFunction="getCityDistrictProperty" value="id" text="ilce,mahalle,posta_kodu,semt" sId="districts" sClass="search" triggerOnEvent="address_provinceChanged"
                        label="validation.attributes.adr_district" placeholder="validation.attributes.adr_district" class="required field"
                    />
                </x-slot>
                
                
                <x-slot name="right">
                    <x-input model="adr_phone" label="validation.attributes.adr_phone" placeholder="validation.attributes.adr_phone"  />
                    {{-- <x-input model="adr_note" label="validation.attributes.adr_note" placeholder="validation.attributes.adr_note"  /> --}}
                    <div class="field">
                        <label><i class="write icon"></i>{{ __('validation.attributes.adr_body' )}}</label>
                        <textarea wire:model.lazy="adr_body" rows="3"></textarea>
                    </div>
                    
                </x-slot>

                <x-slot name="bottom">
                    <div x-data="{addNote: false}">
                        <div x-show="!addNote">
                            <i class="write icon"></i>
                            <span class="cursor-pointer pt-1 text-gray-400 text-sm font-bold ease-in-out duration-200 hover:text-gray-600" @click="addNote = true">{{ __('common.add_explanation') }}</span>
                        </div>
                        <div x-show="addNote" class="field">
                            <label><i class="write icon"></i>{{ __('validation.attributes.adr_note' )}}</label>
                            <textarea wire:model.lazy="adr_note" rows="3"></textarea>
                        </div>
                    </div>
                </x-slot>
                
            </x-form-divider>
        </form>
    </x-content>
</div>
