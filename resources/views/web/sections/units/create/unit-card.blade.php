<div class="bg-white shadow rounded-lg flex border border-teal-100 relative hover:border-teal-300">
    <div class="w-16 h-16 hidden md:flex px-5 rounded-l-lg justify-center items-center shadow-md">
        <i class="large teal balance scale right icon"></i>
    </div>
    <div class="px-2 grid md:grid-cols-8 w-full gap-3 items-center relative">

        <div class="md:text-center items-center pt-2">
            @if($this->isLocked($key))
                <h3 class="font-bold text-red-700">1</h3>
            @else
                <x-input model="cards.{{ $key }}.name" placeholder="units.new_unit_name" class="ui input tiny max-w-full" noErrors />
            @endif
        </div>

        <div class="pt-2">
            @if($this->isLocked($key))
                <span class="font-bold text-lg text-red-600">{{ $card['name'] }}</span>
                <span class="text-xs text-ease">({{ $card['abbreviation']}})</span>
            @else
                <x-input model="cards.{{ $key }}.abbreviation" placeholder="units.new_unit_name_short" class="ui input tiny max-w-full" noErrors />
            @endif
        </div>

        <div class="hidden md:flex ">
            <i class="equals icon"></i>
        </div>

        <div>
            <h2 class="font-bold text-teal-700">1</h2>
        </div>

        <div>
            @if ($this->isLocked($key))
                <span wire:key="locked.{{ $key }}"class="cursor-pointer" data-tooltip="İşlemi değiştir" data-variation="mini">
                    <i class="large hover:text-gray-600 {{ $card['operator'] == true ? 'times' : 'divide' }} icon"></i>
                </span>
            @else
                <span wire:key="unlocked.{{ $key }}" wire:click.prevent="toggleOperator({{ $key }})" class="cursor-pointer" data-tooltip="İşlemi değiştir" data-variation="mini">
                    <i class="large hover:text-gray-600 {{ $card['operator'] == true ? 'times' : 'divide' }} icon"></i>
                </span>
            @endif
        </div>       

        <div>                   
            @if ($this->isLocked($key))
                <h3 class="font-bold text-teal-700">
                    {{ $card['factor'] }}
                </h3>
            @else
                <input wire:model="cards.{{ $key }}.factor" type="number" placeholder="Miktar"
                    class="font-bold text-xl pb-1 max-w-full text-teal-700 border-b-2 border-dashed border-teal-200 hover:border-teal-300 focus:border-teal-400 focus:outline-none ">
            @endif
        </div>

        <div class="">
            @if ($this->isLocked($key))
                <span class="text-lg font-bold text-indigo-900">{{ $this->getParentName($key) }}</span>
            @else
                <select wire:model.lazy="cards.{{ $key }}.parent_id"
                    class="font-bold text-xl focus:outline-none cursor-pointer bg-white">
                    <option selected class="disabled">Birim</option>
                    @foreach ($this->unitsOfSelectedProduct($key) as $unit)
                        <option class="text-red-500 font-bold" value="{{ $unit->id }}">{{ $unit->name }}</option>
                    @endforeach
                </select>
            @endif
        </div>
        
        <div class="text-right">
            @if (! $this->isBaseUnit($key))
                @if ( $this->isLocked($key))
                <button wire:click.prevent="unlockCard({{ $key }})" 
                    class="ui mini icon button max-w-full">
                    <i class="orange lock icon"></i>
                </button>
                @else
                    <div class="ui buttons max-w-full">
                        <button wire:click.prevent="submit({{ $key }})"
                                class="ui positive mini button ">{{ __('common.save') }}</button>
                        @if ($this->isSavedBefore($key))
                        <button wire:click.prevent="lockCard({{ $key }})" class="ui mini icon button">
                            <i class="green unlock icon"></i>
                        </button>
                        @endif
                    </div>
                @endif
            @endif
        </div>

        @if ( ! $this->isLocked($key))
            <div class="absolute top-0 right-0 -mt-2 -mr-3 hover:opacity-100 opacity-50">
                <button wire:click.prevent="callDeleteModal({{ $key }})" class="focus:outline-none">
                    <i class="red shadow rounded-full cancel icon"></i>
                </button>
            </div>
        @endif

    </div>
</div>














{{-- 
<div class="bg-white shadow rounded-lg flex border border-teal-100 relative hover:border-teal-300">
    <div class="w-16 flex pl-2 rounded-l-lg justify-center items-center shadow-md">
        <i class="large teal weight icon"></i>
    </div>
    <div class="flex flex-1 gap-3 items-center p-3">
        <div class="flex flex-1 justify-between items-center">
           
            @if ($this->isLocked($card))
                <div class="w-3/12">
                    <span class="font-bold text-lg text-teal-600">{{ $card['name'] }}</span>
                    <span class="text-sm text-gray-500">({{ $card['abbreviation']}})</span>
                </div>
            @else
                <div class="flex items-center gap-2">
                    <x-input model="cards.{{ $key }}.name" placeholder="units.new_unit_name" class="ui input tiny" />
                    <x-input model="cards.{{ $key }}.abbreviation" placeholder="units.new_unit_name_short" class="ui input tiny w-15" />
                </div>
            @endif

            <div class="pl-6">
                <i class="equals icon"></i>
            </div>
            - inputs -------------------------------
            <div class="pl-6 flex flex-1 justify-around items-center gap-12">
                <div class="">
                    <h2 class="font-bold text-teal-700">1</h2>
                </div>

                <div @if(!$this->isLocked($card)) class="cursor-pointer" wire:click="toggleOperator({{ $key }})" data-tooltip="İşlemi değiştir" data-variation="mini" @endif>
                    <i class="large hover:text-gray-600 {{ $card['operator'] == true ? 'times' : 'divide' }} icon"></i>
                </div>

                <div>                   
                    @if ($this->isLocked($card))
                        <h3 class="font-bold text-teal-700">
                            {{ $card['factor'] }}
                        </h3>
                    @else
                        <input wire:model.lazy="cards.{{ $key }}.factor" type="number" placeholder="Miktar"
                            class="font-bold text-xl pb-1 text-teal-700 border-b-2 border-dashed border-teal-200 hover:border-teal-300 focus:border-teal-400 focus:outline-none ">
                    @endif
                </div>

                <div>
                    @if ($this->isLocked($card))
                        <span>parent birim</span>
                    @else
                        <select wire:model.lazy="cards.{{ $key }}.parent_id"
                            class="font-bold text-xl focus:outline-none cursor-pointer bg-white">
                            <option selected class="disabled">Birim</option>
                            @foreach ($selectedProduct->units as $unit)
                                <option class="text-red-500 font-bold" value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>

            @if ( ! $this->isLocked($card))
                <div class="pl-6">
                    <button wire:click="submit({{ $key }})" class="ui positive mini button pl-2">{{ __('common.save') }}</button>
                </div>
            @endif

        </div>

        <div class="absolute top-0 right-0 -mt-2 -mr-3 hover:opacity-100 opacity-50">
            @if ($this->isLocked($card))
                <button wire:click.prevent="unlockCard({{ $key }})" class="focus:outline-none">
                    <i class="orange shadow rounded-full lock icon"></i>
                </button>
            @else
                <button wire:click.prevent="removeCard({{ $key }})" class="focus:outline-none">
                    <i class="red shadow rounded-full cancel icon"></i>
                </button>
            @endif
        </div>

    </div>
</div> --}}
