<div>
    <div class="p-2 pb-5">
        <h3 class="ui horizontal left aligned divider header">
            <i class="box icon"></i>
            <div class="content">
              {{ __('sections/products.header') }}
              <div class="sub header">{{ __('sections/products.subheader') }}</div>
            </div>
        </h3>
    </div>
    <div class="p-4 bg-white shadow rounded-lg">
        <form class="ui small form p-3" wire:submit.prevent="submit" wire:loading.class="loading">
            <div class="three fields">
                <x-input model="code" label="sections/products.code" placeholder="sections/products.code" class="four wide required field" />                
                <x-input model="name" label="sections/products.name" placeholder="sections/products.name" class="nine wide required field" />
                <x-input model="barcode" label="sections/products.barcode" placeholder="EAN13" class="three wide required field" />
            </div>
    
            <div class="equal width fields">
                <x-input model="min_threshold" label="sections/products.min_threshold" placeholder="sections/products.min_threshold"  class="required field" />
                <x-input model="shelf_life" label="sections/products.shelf_life" placeholder="sections/products.shelf_life" class="required field" />
            </div>
            
            <div class="equal width fields">
                <div class="field" wire:ignore>
                    <label>Kategori</label>
                    <x-dropdown.search model="category_id" :collection="$this->categories" value="id" 
                        placeholder="sections/categories.select_a_category" text="name" transition="slide right" class="ui search selection dropdown" />
                    <a href="">create_category</a>
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

            @if ($producible)
                <livewire:sections.recipes.form />
            @endif
            
            <div>
                @if ($success)
                    <div class="ui positive icon message">
                        <i class="checkmark  icon"></i>
                        <div class="content">
                            <div class="header">
                                <p>{{ __('common.saved_successfully') }}</p>
                            </div>
                            <p>{{ __('common.saved_successfully') }}</p>
                        </div>
                    </div>
                @endif
                <hr>

            <x-form-buttons />
            
        </form>
    </div>    
</div>