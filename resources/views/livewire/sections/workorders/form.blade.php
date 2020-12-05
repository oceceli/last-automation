
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
            <div class="border rounded shadow h-full bg-smoke-lightest">
                @if ($this->productSelected())
                    {{-- Bu ürünün üretimi için
                        @foreach ($selectedProduct->recipe->ingredients as $ingredient)
                            {{ $ingredient->pivot->amount }} {{ \App\Models\Unit::find($ingredient->pivot->unit_id)->abbreviation }} {{ $ingredient->name }}  @if(!$loop->last) ve  @endif
                        @endforeach
                    kullanılacak. Stok tercihi ekle! --}}

                    <div class="flex flex-col gap-4 p-3 h-full">
                        @foreach ($selectedProduct->recipe->ingredients as $ingredient)
                            <div wire:key="{{ $loop->index }}" class="p-3 shadow-md rounded font-bold border border-red-300 bg-white">

                                <div class="flex justify-between gap-3 text-ease">
                                    <div class="field flex gap-1 items-center">
                                        <span class="">{{ $ingredient->name }}</span>
                                        <span class="text-xs"> ({{ $ingredient->code }})</span> 
                                    </div>
                                    <div class="text-xs">
                                        Gerekli miktar: şu kadar
                                    </div>
                                </div>

                                <div>
                                    @if ($ingredient->lots)
                                        {{-- <div class="ui tiny form -mb-3">
                                            <x-dropdown model="test" :collection="$ingredient->lots" value="lot_number" text="lot_number" customMessage="döngüyü yakalamak lazım" class="mini" sId="{{ $loop->index }}" >
                                            
                                            </x-dropdown>
                                        </div> --}}
                                        <select class="form-select text-xs ">
                                            <option selected disabled>seçiniz</option>
                                            @foreach ($ingredient->lots as $lot)
                                                <option value="{{ $lot['lot_number'] }}">{{ $lot['lot_number'] }} {{ $lot['amount'] . ' ' . $lot['unit']->name }} bulunuyor</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <span class="text-xs text-ease">Stokta hiç {{ $ingredient->name }} bulunmuyor. Üretim yapmadan önce kullanılacak lot numarası belirtilecektir.</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                @else 
                    <x-placeholder icon="mortar pestle" header="test" />
                @endif
            </div>
        </x-slot>
        
        <x-slot name="bottom">
            <div x-data="{addNote: false}">
                <div x-show="!addNote" class="text-ease">
                    <i class="write icon"></i>
                    <span class="cursor-pointer pt-1 text-sm font-bold" @click="addNote = true">{{ __('common.add_note') }}</span>
                </div>
                <div x-show="addNote" class="field">
                    <label><i class="write icon"></i>{{ __('common.note' )}}</label>
                    <textarea wire:model.lazy="note" rows="6"></textarea>
                </div>
            </div>
        </x-slot>

    </x-form-divider>


</form>




