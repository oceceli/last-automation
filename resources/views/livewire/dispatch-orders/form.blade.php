<div>
    <x-error-area class="mb-5" />
    

    <x-content>
        <x-slot name="header">
            @if ($editMode)
                <x-page-header icon="truck" header="{{ __('dispatchorders.edit_dispatchorder') }}" />
            @else
                <x-page-header icon="truck" header="{{ __('dispatchorders.create_dispatchorder') }}" />
            @endif
        </x-slot>
        <form class="ui mini form" wire:submit.prevent="submit">
            <x-form-divider bottomClass="bg-gray-100 shadow-inner">

                <x-slot name="left">
                    <x-dropdown model="company_id" :collection="$this->companies" value="id" text="cmp_name,cmp_current_code" sClass="search" class="required" noErrors
                                label="{{ __('dispatchorders.customer') }}" placeholder="{{ __('dispatchorders.customer') }}" sId="do_company" />
    
                    <x-dropdown model="address_id" dataSource="companyAddresses" value="id" text="adr_name,adr_province,adr_phone" triggerOnEvent="do_company_selected" sClass="search" class="required" 
                                label="{{ __('dispatchorders.dispatch_address') }}" placeholder="{{ __('dispatchorders.dispatch_address') }}" sId="do_address" noErrors  />
                    
                    {{-- <x-checkbox model="do_are_lots_specified" label="{{ __('dispatchorders.specify_lot_numbers') }}" class="pt-4" /> --}}
                    
                    <x-input defer model="do_number" label="{{ __('validation.attributes.do_number') }}" placeholder="{{ __('validation.attributes.do_number') }}" class="required" noErrors />
                </x-slot>
                
                <x-slot name="right">
                    {{-- <x-input defer model="do_planned_datetime" label="{{ __('validation.attributes.do_planned_datetime') }}" placeholder="{{ __('validation.attributes.do_planned_datetime') }}" class="required" /> --}}
                    <x-datepicker model="do_planned_datetime" initialDate="{{ $do_planned_datetime }}" label="{{ __('validation.attributes.do_planned_datetime') }}" class="required field" />
                
                    
                    <div x-data="{salesTypeModal: false}" class="equal width fields">
                        <x-dropdown model="sales_type_id" :collection="$this->salesTypes" value="id" text="st_abbr,st_name" sClass="search" class="required" 
                                    label="{{ __('validation.attributes.sales_type_id') }}" placeholder="{{ __('validation.attributes.sales_type_id') }}" sId="sales_type_id" noErrors>
                            <div class="pt-0.5">
                                <span class="cursor-pointer pt-1 text-blue-400 text-xs font-semibold ease-in-out duration-200 hover:text-blue-600" @click="salesTypeModal = true">{{ __('dispatchorders.add_sales_type') }}</span>
                            </div>
                        </x-dropdown>
                        
                        <x-custom-modal active="salesTypeModal" theme="green" header="{{ __('dispatchorders.add_sales_type') }}">
                            component
                        </x-custom-modal>
                    </div>

                    {{-- <div class="field">
                        <label><i class="write icon"></i>{{ __('validation.attributes.do_note' )}}</label>
                        <textarea wire:model.lazy="do_note" rows="5"></textarea>
                    </div> --}}

                    <div x-data="{addNote: false}">
                        <div x-show="!addNote">
                            <i class="write icon"></i>
                            <span class="cursor-pointer pt-1 text-gray-400 text-sm font-bold ease-in-out duration-200 hover:text-gray-600" @click="addNote = true">{{ __('common.add_note') }}</span>
                        </div>
                        <div x-show="addNote" class="field">
                            <label><i class="write icon"></i>{{ __('validation.attributes.do_note' )}}</label>
                            <textarea wire:model.lazy="do_note" rows="1"></textarea>
                        </div>
                    </div>

                </x-slot>



                <x-slot name="bottom">
                    @include('web.sections.dispatchorders.create.specify-products')
                </x-slot>



            </x-form-divider>
        </form>

    </x-content>
    


</div>