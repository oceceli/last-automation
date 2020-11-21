
<form class="ui small form" wire:submit.prevent="submit" >
    <x-form-divider>

        <x-slot name="left">
            <x-input model="name" label="sections/products.name" placeholder="sections/products.name" class="required field" />
            <x-input model="code" label="sections/products.code" placeholder="sections/products.code" class="required field" />                
            <x-input model="barcode" label="sections/products.barcode" placeholder="EAN13" class="required field" />

            
            <div x-data="{categoryModal: false}" class="equal width fields">
                <x-dropdown model="category_id" dataSourceFunction="getCategoriesProperty" value="id" text="name" sId="categories" sClass="search" triggerOnEvent="categoryUpdated"
                    label="modelnames.category" placeholder="sections/categories.select_a_category" transition="slide down">
                    <div class="pt-0.5">
                        <span class="cursor-pointer pt-1 text-blue-400 text-sm font-bold ease-in-out duration-200 hover:text-blue-600" @click="categoryModal = true">{{ __('sections/categories.add_new_category') }}</span>
                    </div>
                </x-dropdown>
                <x-custom-modal active="categoryModal" theme="green">
                    <x-slot name="header">
                        <x-page-header icon="small layer group" header="sections/categories.create_category" />
                    </x-slot>
                    <livewire:sections.categories.form />
                </x-custom-modal>
            </div>
        </x-slot>


        <x-slot name="right">
            <x-dropdown model="unit_id" dataSourceFunction="getUnitsProperty" value="id" text="name" sId="units"
                label="sections/units.unit" placeholder="sections/units.unit" transition="slide down" class="required field"
            />
            <x-input model="shelf_life" label="sections/products.shelf_life" placeholder="sections/products.shelf_life" class="required field" />
            <x-input model="min_threshold" label="sections/products.min_threshold" placeholder="sections/products.min_threshold"  class="field" />

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
                    <div class="ui toggle checkbox" data-tooltip="Fabrikada üretimi gerçekleştirilecek ürünü belirtir." data-position="top right" data-variation="mini">
                        <input wire:model.lazy="producible" type="checkbox">
                        <label>Üretim yapılacak</label>
                    </div>
                    @if ($editMode)
                        <div class="ui toggle checkbox">
                            <input wire:model.lazy="is_active" type="checkbox">
                            <label>Aktif</label>
                        </div>
                    @endif
                </div>
            </div>
        </x-slot>

    </x-form-divider>

</form>

