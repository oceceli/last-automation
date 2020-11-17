<div>
    <x-page-header icon="truck packing" header="Stok ekle veya çıkar">
        <x-slot name="buttons">
            <button wire:click="addCard" class="ui icon mini teal button" data-tooltip="{{ __('common.add_new') }}" data-variation="mini">
                <i class="plus icon"></i>
            </button>
        </x-slot>
    </x-page-header>
    <x-content buttons >
        <div class="p-6 bg-cool-gray-50 shadow-inner rounded-md">
            <form class="ui tiny form flex flex-col gap-6">
                @foreach ($cards as $key => $card)
                    <div class="shadow-md rounded-md bg-white">
                        <div class="flex flex-col md:flex-row rounded-md">
                            <div wire:click.prevent="toggleDirection({{ $key }})" class="shadow md:rounded-l-md p-8 md:p-5 cursor-pointer @if($card['direction']) bg-teal-100 @else bg-red-100 @endif">
                                @if ($card['direction'])
                                    <span class="" data-tooltip="{{ __('stockmoves.stock_entry') }}" data-variation="mini">
                                        <i class="link green big angle double up icon"></i>
                                    </span>
                                @else
                                    <span class="" data-tooltip="{{ __('stockmoves.stock_decrease') }}" data-variation="mini">
                                        <i class="link red big angle double down icon"></i>
                                    </span>
                                @endif
                            </div>
                            <div class="flex-1 pt-3 px-5">
                                <div class="equal width fields">
                                    <x-dropdown placeholder="{{ __('modelnames.product') }}" sClass="search"
                                                model="cards.{{ $key }}.product_id" :collection="$this->products" value="id" text="name" :key="$key">
                                    </x-dropdown>
                                    <x-input model="cards.{{ $key }}.amount" placeholder="{{ __('stockmoves.amount') }}" innerLabel="asdf">
                                    </x-input>    
                                    <x-datepicker model="cards.{{ $key }}.datetime" type="date" initialDate="{{ $card['datetime'] }}" :key="$key" />
                                    {{ Carbon\Carbon::parse($card['datetime'])->format('d.m.Y - H:i:s') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </form>
        </div>
    </x-content>
</div>
