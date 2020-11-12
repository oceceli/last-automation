<div class="bg-white shadow rounded-lg flex border border-teal-100 relative hover:border-teal-300">
    <div class="w-16 flex pl-2 rounded-l-lg justify-center items-center shadow-md">
        {{-- image field
        --}}
        <i class="large teal weight icon"></i>
    </div>
    <div class="flex flex-1 gap-3 items-center p-3">
        <div class="flex flex-1 justify-between items-center">
           
            <div class="flex items-center gap-2">
                <x-input model="cards.{{ $key }}.abbreviation" placeholder="sections/units.new_unit_name_short" class="ui input tiny w-15" />
                <x-input model="cards.{{ $key }}.name" placeholder="sections/units.new_unit_name" class="ui input tiny" />
            </div>

            <div class="pl-6">
                <i class="equals icon"></i>
            </div>
            {{-- inputs -------------------------------}}
            <div class="pl-6 flex flex-1 justify-around items-center gap-12">
                <div class="">
                    <h2 class="font-bold text-teal-700">1</h2>
                </div>

                <div class="cursor-pointer" wire:click="toggleOperator({{ $key }})" data-tooltip="İşlemi değiştir" data-variation="mini">
                    <i class="large hover:text-gray-600 {{ $card['operator'] == true ? 'times' : 'divide' }} icon"></i>
                </div>

                <div class="">                   
                    <input wire:model.lazy="cards.{{ $key }}.factor" type="number" placeholder="Miktar"
                        class="font-bold text-xl pb-1 text-teal-700 border-b-2 border-dashed border-teal-200 hover:border-teal-300 focus:border-teal-400 focus:outline-none ">
                </div>

                <div>
                    <select wire:model.lazy="cards.{{ $key }}.parent_id"
                        class="font-bold text-xl focus:outline-none cursor-pointer bg-white">
                        <option selected class="disabled">Birim</option>
                        @foreach ($selectedProduct->units as $unit)
                            <option class="text-red-500 font-bold" value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="pl-6">
                <button wire:click="submit({{ $key }})" class="ui positive tiny button pl-2">{{ __('common.save') }}</button>
            </div>

        </div>

        <button wire:click.prevent="removeCard({{ $key }})"
            class="absolute top-0 right-0 -mt-2 -mr-3 focus:outline-none hover:opacity-100 opacity-50">
            <i class="red shadow rounded-full cancel icon"></i>
        </button>

    </div>
</div>
