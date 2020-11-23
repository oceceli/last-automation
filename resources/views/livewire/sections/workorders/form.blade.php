
<form class="ui small form"  wire:submit.prevent="submit">

    <x-form-divider>

        <x-slot name="left">
            <x-dropdown model="product_id" dataSourceFunction="getProductsProperty" class="required" sClass="search" sId="selectProduct"
                value="id" text="name" label="sections/products.name" placeholder="{{ __('sections/units.unit') }}"  
            />
            <x-input model="lot_no" label="sections/workorders.lot_no" placeholder="sections/workorders.lot_no" class="required field" />
            <x-dropdown iModel="amount" iPlaceholder="sections/recipes.amount" label="sections/workorders.amount" class="required"
                model="unit_id" initnone triggerOnEvent="woProductChanged" dataSourceFunction="getUnitsProperty" sId="units" sClass="basic"
                value="id" text="name" placeholder="{{ __('sections/units.unit') }}" 
            />
            <x-datepicker model="datetime" initialDate="{{ $datetime }}" label="sections/workorders.datetime"   class="required field" />
            <x-input model="code" label="sections/workorders.code" placeholder="sections/workorders.code" class="required field" />                
            <x-input model="queue" label="sections/workorders.queue" placeholder="sections/workorders.queue" class="required field" /> 
        </x-slot>

        <x-slot name="right">
            <div class="p-2 border rounded shadow h-full">
                @if ($recipeOfSelectedProduct)
                Bu ürünün üretimi için
                    @foreach ($recipeOfSelectedProduct->ingredients as $ingredient)
                        {{ $ingredient->pivot->amount }} {{ \App\Models\Unit::find($ingredient->pivot->unit_id)->abbreviation }} {{ $ingredient->name }}  @if(!$loop->last) ve  @endif
                    @endforeach
                kullanılacak. Stok tercihi ekle!
                @else 
                    <x-placeholder icon="mortar pestle" header="test" />
                @endif
            </div>
        </x-slot>
        
        <x-slot name="bottom">
            <div x-data="{addNote: false}">
                <div x-show="!addNote">
                    <i class="write icon"></i>
                    <span class="cursor-pointer pt-1 text-gray-400 text-sm font-bold ease-in-out duration-200 hover:text-gray-600" @click="addNote = true">{{ __('common.add_note') }}</span>
                </div>
                <div x-show="addNote" class="field">
                    <label><i class="write icon"></i>{{ __('common.note' )}}</label>
                    <textarea wire:model.lazy="note" rows="6"></textarea>
                </div>
            </div>
        </x-slot>

    </x-form-divider>


</form>




