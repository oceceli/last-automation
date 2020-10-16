<div class="bg-white p-5 rounded-lg">
    <div class="ui form">
        <div class="equal width fields">
            <div class="field" wire:ignore>
                <label>Ürünler</label>
                    <x-dropdown.search model="product_id" :collection="$this->products" value="id" text="name" transition="slide right" class="ui search selection dropdown" />                    
                    {{$product_id}}
            </div>        
        </div>
    </div>
</div>
