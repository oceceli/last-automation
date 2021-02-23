<div>
    
    <x-content>
        <x-slot name="header">
            <x-page-header icon="truck packing" header="{{ __('stockmoves.stock_moves_create') }}">
                <x-slot name="buttons">
                    <button wire:click="addCard" class="ui icon mini teal button" data-tooltip="{{ __('stockmoves.new_move') }}" data-variation="mini">
                        <i class="plus icon"></i>
                    </button>
                </x-slot>
            </x-page-header>
        </x-slot>
        <div class="p-6 bg-cool-gray-50 rounded-t-md shadow-lg">
            <form class="ui tiny form flex flex-col gap-6">
                @forelse ($cards as $key => $card)
                    <div wire:key="{{ $key }}" class="shadow-md rounded-md bg-white">
                        <div class="flex flex-col md:flex-row rounded-md relative">

                            <div wire:click.prevent="toggleDirection({{ $key }})" class="shadow md:rounded-l-md p-8 md:p-5 cursor-pointer @if($card['direction']) bg-teal-100 @else bg-red-100 @endif">
                                @if ($card['direction'])
                                    <span class="" data-tooltip="{{ __('stockmoves.stock_in') }}" data-variation="mini">
                                        <i class="link green big plus icon"></i>
                                    </span>
                                @else
                                    <span class="" data-tooltip="{{ __('stockmoves.stock_out') }}" data-variation="mini">
                                        <i class="link red big minus icon"></i>
                                    </span>
                                @endif
                            </div>
                            <div class="flex-1 pt-3 px-5">
                                <div class="four fields">
                                    <x-dropdown placeholder="{{ __('modelnames.product') }}" sClass="search" noErrors
                                                model="cards.{{ $key }}.product_id" :collection="$this->products" value="id" text="prd_code,prd_name" :key="'selectProduct'.$key">
                                    </x-dropdown>
                                    <x-dropdown iModel="cards.{{ $key }}.amount" iPlaceholder="{{ __('stockmoves.amount') }}" iType="number" sClass="basic" 
                                                initnone triggerOnEvent="sm_product_selected{{$key}}" model="cards.{{ $key }}.unit_id" dataSource="units.{{ $key }}"
                                                :key="'units'.$key" value="id" text="name" placeholder="{{ __('modelnames.unit') }}" noErrors>
                                    </x-dropdown>
                                    @if ($card['lotNumberAreaType'] === 'input')
                                        <x-input model="cards.{{ $key }}.lot_number" placeholder="{{ __('stockmoves.lot_number') }}" noErrors  />
                                    @elseif($card['lotNumberAreaType'] === 'dropdown')
                                        <div class="field pt-1">
                                            <x-select model="cards.{{ $key }}.lot_number" :collection="$lotNumbers" :collectionKey="$key" value="text"  />
                                        </div>
                                        {{-- <x-dropdown model="cards.{{ $key }}.lot_number" initnone triggerOnEvent="sm_product_selected{{$key}}" dataSource="lotNumbers.{{ $key }}" 
                                            placeholder="{{ __('stockmoves.lot_number') }}" value="id" text="id">
                                        </x-dropdown> --}}
                                    @endif
                                    <x-datepicker model="cards.{{ $key }}.datetime" type="date" :uniqueKey="$key" />
                                    {{-- <input type="datetime-local" class="form-date" wire:model="cards.{{ $key }}.datetime"> --}}
                                </div>
                                
                            </div>
                            <button wire:click.prevent="removeCard({{ $key }})" class="focus:outline-none absolute top-0 right-0 -mt-2 -mr-3 hover:opacity-100 opacity-50">
                                <i class="red shadow rounded-full cancel icon"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <x-placeholder icon="blue truck packing">
                        <span>{{ __('stockmoves.use_add_button_to_make_stock_move') }}</span>
                    </x-placeholder>
                @endforelse
                
            </form>
        </div>

        <x-form-buttons submit="submit()" class="p-5 shadow-md" />
        
        <x-error-area />
    </x-content>
</div>
