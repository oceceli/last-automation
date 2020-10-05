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
            @if ($success)
                <div class="bg-green-100 rounded-t-lg flex items-center justify-center p-3">
                    <i class="icon info circular"></i>
                    <p class="text-green-600">{{ __('common.saved_successfully') }}Ürün kaydedildi!</p>
                </div>
            @endif
            <hr>
        </div>
        
        <div class="mt-8 flex justify-between items-center">
            <div></div>
            <div class="ui buttons w-full xl:w-3/12">
                <button class="ui basic button labeled icon" type="reset" wire:click="clearFields">
                    <i class="redo icon"></i>
                    Temizle
                </button>
                <button class="ui right labeled icon positive button" wire:loading.class="disabled loading" wire:target="submit">
                    <i class="angle right icon"></i>
                    Kaydet
                </button>
            </div>
        </div>
    </form>
</div>
