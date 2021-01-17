



{{-- AN İTİBARİYLE KULLANILMIYOR!!! ...................................................... --}}

{{-- CARD --}}
{{-- <div class="pt-2"> 
    <x-card>
        <x-slot name="square">
            test
        </x-slot>
        <div class="flex gap-3 items-center px-4 flex-1">
            <div class="pt-2 equal width fields w-6/12">
                <x-dropdown model="product_id" :collection="$this->products" value="id" text="name" sClass="search" class=""
                    placeholder="{{ __('sections/products.product') }}" sId="dp_product" />
                    
                <x-dropdown model="dp_lot_number" initnone triggerOnEvent="dp_product_selected" dataSourceFunction="getLotsProperty" value="lot_number" text="lot_number,available_amount_string" sClass="search" 
                        placeholder="{{ __('inventory.lot_number') }}" sId="dp_lot" />

                
                <x-input defer model="do_number" placeholder="{{ __('validation.attributes.do_number') }}" />
                
            </div>
            <div class="">
                asdfj
            </div>
        </div>
    </x-card>
</div> --}}