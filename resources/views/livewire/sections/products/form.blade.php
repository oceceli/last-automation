<div x-data="{categoryModal: false}">
    <x-page-header icon="box" header="sections/products.create.header" subheader="sections/products.create.subheader" />

    <div class="p-4 bg-white shadow rounded-lg">
        <form class="ui small form p-3" wire:submit.prevent="submit" >
            <div class="equal width fields">
                <x-input model="name" label="sections/products.name" placeholder="sections/products.name" class="required field" />
            </div>
            <div class="equal width fields">
                <x-input model="code" label="sections/products.code" placeholder="sections/products.code" class="required field" />                
                <x-input model="barcode" label="sections/products.barcode" placeholder="EAN13" class="required field" />
                <div class="required field" wire:ignore>
                    <label>{{ ucfirst(__('sections/units.unit')) }}</label>
                    <x-dropdown.search model="unit" :collection="$this->units" placeholder="sections/units.unit" transition="slide right" class="ui selection dropdown" />
                </div>
            </div>
            
    
            <div class="equal width fields">
                <x-input model="min_threshold" label="sections/products.min_threshold" placeholder="sections/products.min_threshold"  class="required field" />
                <x-input model="shelf_life" label="sections/products.shelf_life" placeholder="sections/products.shelf_life" class="required field" />
            </div>
            
            <div class="equal width fields">
                <div class="required field" wire:ignore>
                    <label>Kategori</label>
                    <x-dropdown.search model="category_id" :collection="$this->categories" value="id" 
                    placeholder="sections/categories.select_a_category" text="name" transition="slide right" class="ui search selection dropdown" />

                    <div class="pt-1 text-blue-400 text-sm font-semibold">
                        <span class="cursor-pointer hover:text-blue-600" @click="categoryModal = true">{{ __('sections/categories.add_new_category') }}</span>
                    </div>
                </div>
                
            </div>
            
            <div class="fields">
                <div class="sixteen wide field">
                    <label>Açıklama</label>
                    <textarea wire:model.lazy="note" rows="2"></textarea>
                </div>
            </div>
    
            <div class="fields">
                <div class="field">
                    <div class="ui toggle checkbox">
                        <input wire:model.lazy="is_active" type="checkbox">
                        <label>Aktif</label>
                    </div>
                </div>
                <div class="field">
                    <div class="ui toggle checkbox" data-tooltip="Fabrikada üretimi gerçekleştirilecek ürünü belirtir." data-position="top center" data-variation="mini">
                        <input wire:model.lazy="producible" type="checkbox">
                        <label>Üretim yapılacak</label>
                    </div>
                </div>
            </div>

            
            <div>
                <x-form-buttons />
            </div>
        </form>
    </div>    

    <x-custom-modal active="categoryModal" theme="green">
        <x-slot name="header">
            <x-page-header icon="small layer group" header="sections/categories.create_category" />
        </x-slot>
        <livewire:sections.categories.form />
    </x-custom-modal>
</div>