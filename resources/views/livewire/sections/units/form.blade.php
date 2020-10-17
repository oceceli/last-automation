<div>
    <x-page-title icon="weight" header="sections/units.header" subheader="sections/units.subheader" />
    <div class="bg-white p-5 rounded-lg shadow">

        <div class="ui form">
            <div class="equal width fields">
                <div class="field" wire:ignore>
                    <label>Ürün</label>
                    <x-dropdown.search model="product_id" :collection="$this->products" value="id" text="name" transition="slide right" class="ui search selection dropdown" />                    
                </div>
            </div>

            
            <div class="border rounded">
                {{-- BAŞLIK VE BUTONLAR --}}
                <x-title-and-buttons title="Birimler" icon="red weight" class="py-4 px-3 bg-cool-gray-50" >
                    <x-slot name="buttons">
                        <button wire:click.prevent @click="materials = true" class="ui icon small teal button" data-tooltip="{{ __('common.add_new') }}">
                            <i class="plus icon"></i>
                        </button>
                        <button wire:click.prevent="clearIngredients" class="ui icon small gray basic button" data-tooltip="{{ __('common.remove_all') }}">
                            <i class="red trash icon"></i>
                        </button>
                    </x-slot>
                </x-title-and-buttons>


                <div class="p-4">

                    <div class="fields">
                        <x-input model="product_id" label="sections/units.unit" placeholder="Birim adı" class="required field"/>
                        <x-input model="product_id" label="sections/units.unit" placeholder="Birim adı" class="required field"/>
                    </div>                    

                </div>
            </div>

        </div>
    </div>

</div>