<div x-data="{categoryModal: false}">
    <x-page-header icon="box" header="sections/products.create.header" subheader="sections/products.create.subheader" />

    <x-content buttons>
        <form class="ui small form p-6" wire:submit.prevent="submit" >
            <div class="equal width fields">
                <x-input model="name" label="sections/products.name" placeholder="sections/products.name" class="required field" />
            </div>
            <div class="equal width fields">
                <x-input model="code" label="sections/products.code" placeholder="sections/products.code" class="required field" />                
                <x-input model="barcode" label="sections/products.barcode" placeholder="EAN13" class="required field" />

                <x-dropdown model="unit_id" dataSourceFunction="getUnitsProperty" value="id" text="name" sId="units"
                    label="sections/units.unit" placeholder="sections/units.unit" transition="slide down" class="required field"
                />

            </div>
            
    
            <div class="equal width fields">
                <x-input model="min_threshold" label="sections/products.min_threshold" placeholder="sections/products.min_threshold"  class="required field" />
                <x-input model="shelf_life" label="sections/products.shelf_life" placeholder="sections/products.shelf_life" class="required field" />
            </div>
            
            <div class="equal width fields">
                <x-dropdown model="category_id" dataSourceFunction="getCategoriesProperty" value="id" text="name" sId="categories" sClass="search" triggerOnEvent="categoryUpdated"
                    label="modelnames.category" placeholder="sections/categories.select_a_category" transition="slide down">
                    <div class="pt-1 text-blue-400 text-sm font-semibold">
                        <span class="cursor-pointer hover:text-blue-600" @click="categoryModal = true">{{ __('sections/categories.add_new_category') }}</span>
                    </div>
                </x-dropdown>
            </div>
            

            
            <div class="fields">
                <div class="sixteen wide field">
                    <label>Açıklama</label>
                    <textarea wire:model.lazy="note" rows="2"></textarea>
                </div>
            </div>
    
            <div class="fields">
                @if ($editMode)
                <div class="field">
                    <div class="ui toggle checkbox">
                        <input wire:model.lazy="is_active" type="checkbox">
                        <label>Aktif</label>
                    </div>
                </div>
                @endif
                <div class="field">
                    <div class="ui toggle checkbox" data-tooltip="Fabrikada üretimi gerçekleştirilecek ürünü belirtir." data-position="top center" data-variation="mini">
                        <input wire:model.lazy="producible" type="checkbox">
                        <label>Üretim yapılacak</label>
                    </div>
                </div>
            </div>

        </form>
    </x-content>    

    <x-custom-modal active="categoryModal" theme="green">
        <x-slot name="header">
            <x-page-header icon="small layer group" header="sections/categories.create_category" />
        </x-slot>
        <livewire:sections.categories.form />
    </x-custom-modal>
</div>