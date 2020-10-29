<div>
    <x-page-header icon="weight" header="sections/units.header" subheader="sections/units.subheader" />
    <div class="bg-white p-5 rounded-lg shadow">

        <div class="ui small form">
            <div class="equal width fields">
                <div class="field" wire:ignore>
                    <label>Ürün</label>
                    <x-dropdown.search model="product_id" :collection="$this->products" value="id" text="name,code" transition="slide right" class="ui search selection dropdown" />                    
                </div>
            </div>
        </div>
        

        @if ($selectedProduct)

            <div class="relative border rounded-t bg-gray-50 shadow-inner" style="min-height: 60%" x-data="{'materials' : false}">
                            
                {{-- BAŞLIK VE BUTONLAR --}}
                <x-page-header title="'{{ $selectedProduct->name }}'  {{ __('sections/units.units') }}" icon="weight" class="py-4 px-3 bg-cool-gray-50" >
                    <x-slot name="buttons">
                        <button wire:click.prevent="addNewUnitField" class="ui icon small teal button" data-tooltip="{{ __('common.add_new') }}">
                            <i class="plus icon"></i>
                        </button>
                        <button wire:click.prevent="removeAllUnitFields" class="ui icon small gray basic button" data-tooltip="{{ __('common.remove_all') }}">
                            <i class="red trash icon"></i>
                        </button>
                    </x-slot>
                </x-page-header>

                <div class="shadow-inner relative">
                    {{-- İÇERİK - CARD KISMI   md:h-96 overflow-x-hidden  --}}
                    <div class="p-5 py-7">
                        <div class="flex flex-col gap-3">
                            @if (! $unitFields)
                            <div class="ui placeholder segment h-full">
                                <div class="ui icon header">
                                    {{-- <i class="blue atom left bottom corner icon"></i> --}}
                                    <i class="weight icon"></i>
                                    Birim oluşturmak için ekle butonunu kullanın
                                </div>
                                <div class="text-sm text-center"></div>
                            </div>
                            @else
                                @foreach ($unitFields as $key => $unitField)
                                    <div class="bg-white shadow rounded-lg flex border border-teal-100 relative hover:border-teal-300">

                                        <div class="w-16 flex pl-2 rounded-l-lg justify-center items-center shadow-md">
                                            {{-- image field --}}
                                            <i class="large teal weight icon"></i>
                                        </div>

                                        <div class="flex flex-1 gap-3 items-center p-3">
                                        {{-- <div class="flex flex-1 justify-between items-center p-3"> --}}
                                            <div class="">
                                                {{-- <input wire:model.lazy="unitFields.{{ $key }}.name" type="text" placeholder="{{ ucfirst(__('sections/units.new_unit_name')) }}"> --}}
                                                <x-input model="unitFields.{{ $key }}.name" placeholder="sections/units.new_unit_name" class="ui input small" />
                                            </div>
                                            <div class="pl-6">
                                                <i class="equals icon"></i>
                                            </div>
                                            {{-- inputs --}}
                                            <div class="pl-6 flex flex-1 justify-around items-center gap-12">
                                                <div class="">
                                                    <h2 class="font-bold text-teal-700">1</h2>
                                                </div>
                                                
                                                <div class="cursor-pointer" wire:click="toggleMultiplier({{ $key }})" data-tooltip="İşlemi değiştir">
                                                    <i class="large {{ $unitField['multiplier'] == true ? 'times' : 'divide' }} icon"></i>
                                                </div>
                                                
                                                <div class="">
                                                    {{-- <i class="calculator icon"></i> --}}
                                                    <input wire:model.lazy="unitFields.{{ $key }}.factor" type="number" placeholder="Miktar" class="font-bold text-xl pb-1 text-teal-700 border-b-2 border-dashed border-teal-200 hover:border-teal-300 focus:border-teal-400 focus:outline-none ">
                                                </div>
                                                
                                                <div>
                                                    <select wire:model.lazy="unitFields.{{ $key }}.parent_id" class="font-bold text-xl focus:outline-none cursor-pointer bg-white">
                                                        <option selected class="disabled">Birim</option>
                                                        @foreach ($selectedProduct->units as $unit)
                                                            <option class="text-red-500 font-bold" value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                
                                            </div>
                                            <div>
                                                <button wire:click="submit({{ $key }})" class="ui positive tiny button pl-2">{{ __('common.save') }}</button>
                                            </div>

                                        </div>
                                        
                                        <button wire:click.prevent="removeUnitField({{ $key }})" class="absolute top-0 right-0 -mt-2 -mr-3 focus:outline-none hover:opacity-100 opacity-50">
                                            <i class="red shadow rounded-full cancel icon"></i>
                                        </button>
                                        
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>                
            </div>
            
        @endif
    </div>

</div>