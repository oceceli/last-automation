<div>
    <x-error-area></x-error-area>
    <form class="ui tiny form" wire:submit.prevent="submit">
        <x-form-divider>
            
            <x-slot name="left">
                <x-input noErrors model="prd_name" label="{{ __('validation.attributes.prd_name') }}" placeholder="{{ __('validation.attributes.prd_name') }}" class="required field" />
                <x-input noErrors model="prd_code" label="{{ __('validation.attributes.prd_code') }}" placeholder="{{ __('validation.attributes.prd_code') }}" class="required field" />                
                <x-input noErrors model="prd_barcode" label="{{ __('validation.attributes.prd_barcode') }}" placeholder="EAN13" class="required field" />

                
                <div x-data="{categoryModal: @entangle('categoryModal')}" class="equal width fields">
                    <x-dropdown model="category_id" dataSourceFunction="getCategoriesProperty" value="id" text="ctg_name" sId="categories" sClass="search" triggerOnEvent="categoryUpdated"
                        label="{{ __('modelnames.category') }}" placeholder="{{ __('categories.select_a_category') }}" transition="slide down">
                        <x-slot name="right">
                            <div class="pt-1 flex gap-2 justify-end items-center" id="BUTTONS">
                                @if ($selectedCategory)
                                    <span wire:key="ctg-delete" wire:click.prevent="ctgDelete()" class="cursor-pointer text-red-400 hover:text-red-600 " data-tooltip="{{ __('common.delete') }}" data-variation="mini">
                                        <i class="trash icon"></i>
                                    </span>
                                    <span  wire:key="ctg-edit" wire:click.prevent="ctgEdit()"  class="cursor-pointer text-yellow-400 hover:text-yellow-600 " data-tooltip="{{ __('common.edit') }}" data-variation="mini">
                                        <i class="edit icon"></i>
                                    </span>
                                @endif
                                <span wire:click="ctgAdd()" class="cursor-pointer text-blue-400 ease-in-out duration-200 hover:text-blue-600" data-tooltip="{{ __('categories.add_new_category') }}" data-variation="mini">
                                    <i class="green plus icon"></i>
                                </span>
                            </div>
                        </x-slot>
                    </x-dropdown>
                    <x-custom-modal active="categoryModal" theme="green">
                        <x-slot name="header">
                            <x-page-header icon="small layer group" header="categories.create_category" />
                        </x-slot>
                        {{-- <livewire:categories.form /> --}}
                        <x-custom-modal active="categoryModal" theme="green" header="{{ __('categories.add_category') }}">
                            @include('web.sections.categories.ctg-baseform')
                        </x-custom-modal>
                    </x-custom-modal>
                </div>
            </x-slot>


            <x-slot name="right">
                <x-dropdown model="unit_id" dataSourceFunction="getUnitsProperty" value="id" text="name" sId="units"
                    label="units.unit" placeholder="units.unit" transition="slide down" class="required field"
                />
                <x-input noErrors model="prd_shelf_life" label="{{ __('validation.attributes.prd_shelf_life') }}" placeholder="{{ __('validation.attributes.prd_shelf_life') }}" class="required field" />
                <x-input noErrors model="prd_min_threshold" label="{{ __('validation.attributes.prd_min_threshold') }}" placeholder="{{ __('validation.attributes.prd_min_threshold') }}"  class="field" />
                <x-input noErrors model="prd_cost" label="{{ __('validation.attributes.prd_cost') }}" placeholder="{{ __('validation.attributes.prd_cost') }}"  class="field" />

            </x-slot>

            <x-slot name="bottom">
                <div class="grid md:grid-cols-2 items-center gap-10">
                    <div x-data="{addNote: false}">
                        <div x-show="!addNote">
                            <i class="write icon"></i>
                            <span class="cursor-pointer pt-1 text-gray-400 text-sm font-bold ease-in-out duration-200 hover:text-gray-600" @click="addNote = true">{{ __('common.add_note') }}</span>
                        </div>
                        <div x-show="addNote" class="field">
                            <label><i class="write icon"></i>{{ __('common.note' )}}</label>
                            <textarea wire:model.lazy="note" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="flex gap-10 md:justify-end">
                        <div class="ui toggle checkbox" data-tooltip="{{ __('products.expresses_the_product_will_be_produced') }}" data-position="top right" data-variation="mini">
                            <input wire:model.lazy="prd_producible" type="checkbox">
                            <label>{{ __('validation.attributes.prd_producible') }}</label>
                        </div>
                        @if ($editMode)
                            <div class="ui toggle checkbox">
                                <input wire:model.lazy="prd_is_active" type="checkbox">
                                <label>{{ __('validation.attributes.prd_is_active') }}</label>
                            </div>
                        @endif
                    </div>
                </div>
            </x-slot>

        </x-form-divider>

    </form>

    

</div>