<div>
    <x-error-area class="mb-5" />

    <x-content>
        <x-slot name="header">
            <x-page-header icon="truck" header="{{ __('dispatchorders.create_dispatchorder') }}" />
        </x-slot>
        <form class="ui tiny form" wire:submit.prevent="submit">
            <x-form-divider>

                <x-slot name="left">
                    <x-dropdown model="company_id" :collection="$this->companies" value="id" text="cmp_name,cmp_current_code" sClass="search" class="required" noErrors
                                label="{{ __('dispatchorders.customer') }}" placeholder="{{ __('dispatchorders.customer') }}" sId="do_company" />
    
                    <x-dropdown model="address_id" initnone dataSourceFunction="getCompanyAddressesProperty" value="id" text="adr_name,adr_province,adr_phone" triggerOnEvent="do_company_selected" sClass="search" class="required" 
                                label="{{ __('dispatchorders.dispatch_address') }}" placeholder="{{ __('dispatchorders.dispatch_address') }}" sId="do_address" noErrors  />
                    
                    {{-- <x-checkbox model="do_are_lots_specified" label="{{ __('dispatchorders.specify_lot_numbers') }}" class="pt-4" /> --}}
                    
                </x-slot>
                
                <x-slot name="right">
                    <x-input defer model="do_number" label="{{ __('validation.attributes.do_number') }}" placeholder="{{ __('validation.attributes.do_number') }}" class="required" noErrors />
                    {{-- <x-input defer model="do_datetime" label="{{ __('validation.attributes.do_datetime') }}" placeholder="{{ __('validation.attributes.do_datetime') }}" class="required" /> --}}
                    <x-datepicker model="do_datetime" initialDate="{{ $do_datetime }}" label="{{ __('validation.attributes.do_datetime') }}" class="required field" />
                </x-slot>



                <x-slot name="bottom">
                    @if ($do_are_lots_specified)
                        @include('web.sections.dispatchorders.specifyLots')
                    @else
                        @include('web.sections.dispatchorders.specifyProducts')
                    @endif
                </x-slot>



            </x-form-divider>
        </form>
    </x-content>


</div>