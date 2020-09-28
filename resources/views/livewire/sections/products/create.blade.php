<div class="p-4 bg-white shadow rounded-lg">
    <form class="ui form p-3" wire:submit.prevent="submit" wire:loading.class="loading">
        <div class="three fields">
            <div class="four wide required field">
                <label>Kod</label>
                <input wire:model="code" type="text" placeholder="Ürün Kodu">
                @error('code')
                    <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
                @enderror
            </div>
            <div class="nine wide required field">
                <label>İsim</label>
                <input wire:model="name" type="text" placeholder="Ürün Adı">
                @error('name')
                    <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
                @enderror
            </div>
            <div class="three wide required field">
                <label>Barkod</label>
                <input wire:model="barcode" type="text" placeholder="EAN13">
                @error('barcode')
                    <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
                @enderror
            </div>			  
        </div>

        <div class="equal width fields">
            <div class="field">
                <label>Minimum Stok</label>
                <input wire:model="min_threshold" type="text" placeholder="Minimum Stok">
                @error('min_threshold')
                    <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
                @enderror
            </div>
            <div class="field">
                <label>Raf Ömrü</label>
                <input wire:model="shelf_life" type="text" placeholder="Raf Ömrü">
                @error('shelf_life')
                    <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
                @enderror
            </div>
        </div>
        
        
        <div class="fields">
            <div class="sixteen wide field">
                <label>Açıklama</label>
                <textarea wire:model="note" rows="2"></textarea>
            </div>
        </div>

        <div class="fields">
            <div class="field">
                <div class="ui toggle checkbox">
                    <input wire:model="is_active" type="checkbox">
                    <label>Aktif</label>
                </div>
            </div>
            <div class="field">
                <div class="ui toggle checkbox" data-tooltip="Fabrikada üretimi gerçekleştirilecek ürünü belirtir." data-position="top center" data-variation="mini">
                    <input wire:model="producible" type="checkbox">
                    <label>Üretim yapılacak</label>
                </div>
            </div>
        </div>
        
        <hr>
        
        <div>
            <p class="text-green-500 w-full">Başarılı!</p>
            @if ($success)
            @endif
        </div>
        <div class="mt-8 flex justify-between items-center">
            <div></div>
            <div class="ui buttons w-full xl:w-3/12">
                <button class="ui basic button labeled icon" type="reset">
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
