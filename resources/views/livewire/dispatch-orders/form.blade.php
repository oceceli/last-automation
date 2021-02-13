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

                    {{-- <x-input defer model="do_planned_datetime" label="{{ __('validation.attributes.do_planned_datetime') }}" placeholder="{{ __('validation.attributes.do_planned_datetime') }}" class="required" /> --}}
                    <x-datepicker model="do_planned_datetime" initialDate="{{ $do_planned_datetime }}" label="{{ __('validation.attributes.do_planned_datetime') }}" class="required field" />
                
                    
                    <div x-data="{salesTypeModal: false}" class="equal width fields">
                        <x-dropdown model="sales_type_id" triggerOnEvent="st_updated" dataSourceFunction="getSalesTypesProperty" value="id" text="st_abbr,st_name" sClass="search" class="required" 
                                    label="{{ __('validation.attributes.sales_type_id') }}" placeholder="{{ __('validation.attributes.sales_type_id') }}" sId="sales_type_id" noErrors>
                            <x-slot name="right">
                                <div class="pt-0.5 flex justify-end gap-2 items-center" id="BUTTONS">
                                    @if ($sales_type_id)
                                        <span wire:key="stDelete" wire:click.prevent="stDelete({{ $sales_type_id }})" class="cursor-pointer text-red-400 hover:text-red-600 " data-tooltip="{{ __('common.delete') }}" data-variation="mini">
                                            <i class="trash icon"></i>
                                        </span>
                                        <span wire:key="stEdit" wire:click.prevent="stEdit({{ $sales_type_id }})" @click="salesTypeModal = true" class="cursor-pointer text-yellow-400 hover:text-yellow-600 " data-tooltip="{{ __('common.edit') }}" data-variation="mini">
                                            <i class="edit icon"></i>
                                        </span>
                                    @endif
                                    <span wire:key="stAdd" @click="salesTypeModal = true" class=" cursor-pointer text-blue-400 ease-in-out duration-200 hover:text-blue-600" data-tooltip="{{ __('common.add') }}" data-variation="mini">
                                        <i class="plus icon"></i>
                                    </span>
                                </div>
                            </x-slot>
                        </x-dropdown>
                        
                        <x-custom-modal active="salesTypeModal" theme="green" header="{{ __('dispatchorders.add_sales_type') }}">
                            @include('web.sections.salestype.baseform')
                        </x-custom-modal>
                    </div>

                    
                </x-slot>
                

                <x-slot name="right">
                    <div x-data="{extrasField: @entangle('extrasField')}" class="h-full">

                        <div class="w-full h-full border bg-gray-100 rounded flex items-center justify-center" x-show="!extrasField">
                            <div class="text-center">
                                <button wire:click.prevent @click="extrasField = true" class="ui primary label button">
                                    {{ __('dispatchorders.enter_extra_information') }}
                                </button>
                                <div class="pt-2 text-xs text-ease">{{ __('dispatchorders.plate_number_driver_expenses_etc')}}</div>
                            </div>
                        </div>
                        

                        <div x-show="extrasField">
                            <x-input defer model="de_license_plate" label="{{ __('validation.attributes.de_license_plate') }}" placeholder="{{ __('validation.attributes.de_license_plate') }}" noErrors />
                            <x-input defer model="de_driver_name" label="{{ __('validation.attributes.de_driver_name') }}" placeholder="{{ __('validation.attributes.de_driver_name') }}" noErrors />
                            <x-input defer model="de_driver_phone" label="{{ __('validation.attributes.de_driver_phone') }}" placeholder="{{ __('validation.attributes.de_driver_phone') }}" noErrors />
                            <x-input defer model="de_dispatch_expense" label="{{ __('validation.attributes.de_dispatch_expense') }}" placeholder="{{ __('validation.attributes.de_dispatch_expense') }}" noErrors />
                            <x-input defer model="de_handling_expense" label="{{ __('validation.attributes.de_handling_expense') }}" placeholder="{{ __('validation.attributes.de_handling_expense') }}" noErrors />
                            <div x-data="{addNote: false}" class="pt-2">
                                <div x-show="!addNote">
                                    <i class="write icon"></i>
                                    <span class="cursor-pointer pt-1 text-gray-400 text-sm font-bold ease-in-out duration-200 hover:text-gray-600" @click="addNote = true">{{ __('common.add_note') }}</span>
                                </div>
                                <div x-show="addNote" class="field" x-cloak>
                                    <label><i class="write icon"></i>{{ __('validation.attributes.do_note' )}}</label>
                                    <textarea wire:model.lazy="do_note" rows="1"></textarea>
                                </div>
                            </div>
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