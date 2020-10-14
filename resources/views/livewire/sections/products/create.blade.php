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
        <form class="ui form p-3" wire:submit.prevent="submit" wire:loading.class="loading">
            <div class="three fields">
                <div class="four wide required field">
                    <label>Kod</label>
                    <input wire:model.lazy="code" type="text" placeholder="Ürün Kodu">
                    @error('code')
                        <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
                    @enderror
                </div>
                <div class="nine wide required field">
                    <label>İsim</label>
                    <input wire:model.lazy="name" type="text" placeholder="Ürün Adı">
                    @error('name')
                        <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
                    @enderror
                </div>
                <div class="three wide required field">
                    <label>Barkod</label>
                    <input wire:model.lazy="barcode" type="text" placeholder="EAN13">
                    @error('barcode')
                        <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
                    @enderror
                </div>			  
            </div>
    
            <div class="equal width fields">
                <div class="field">
                    <label>Minimum Stok</label>
                    <input wire:model.lazy="min_threshold" type="text" placeholder="Minimum Stok">
                    @error('min_threshold')
                        <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
                    @enderror
                </div>
                <div class="required field">
                    <label>Raf Ömrü</label>
                    <input wire:model.lazy="shelf_life" type="text" placeholder="Raf Ömrü">
                    @error('shelf_life')
                        <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
                    @enderror
                </div>
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
            </div>
            
            <x-form-buttons />
        </form>
    </div>    
</div>