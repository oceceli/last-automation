<div>
    <x-page-header icon="mortar pestle" header="sections/recipes.header" subheader="sections/recipes.subheader" />
    <x-content theme="orange" >


            {{-- RECIPE FORM ---------------------------------------------------------------------------}}
            <div class="p-6 shadow-md">
                <form class="ui small form">
                    <div class="equal width fields">
                        <x-dropdown.search model="product_id" label="sections/recipes.recipe_product" :collection="$this->producibles" value="id" text="name,code" id="selectProduct" class="required" sClass="search" />
                        
                        <x-input action model="code" label="sections/recipes.code" placeholder="sections/recipes.code" class="required">
                            <x-slot name="action">
                                <button wire:click.prevent="suggest" class="ui teal right labeled icon button @if(!$selectedProduct) disabled @endif" >
                                    <i class="icon random"></i>
                                    {{ __('sections/recipes.suggest_code') }}
                                </button>
                            </x-slot>
                        </x-input>
                    </div>
                    @if ($this->producibles->count() <= 0)
                        <div class="pt-2 font-semibold text-sm">Listede hiç ürün yok, öncelikle <a class="text-red-600" href="{{ route('products.create') }}">buradan</a> başlayın...</div>
                    @endif
                </form> 
            </div>
            {{-- RECIPE FORM ---------------------------------------------------------------------------}}




            
            {{-- INGREDIENTS ---------------------------------------------------------------------------}}
            @if ( ! empty($product_id))
            <div x-data="{materials: false}" class="p-6">
                @include('web.sections.recipes.ingredientHeader')     

                <div class="p-4 rounded-md border border-blue-200">
                    @if (empty($cards))
                        @include('web.sections.recipes.recipePlaceholder')
                    @else
                    {{-- CARDS ------------------------------------}}
                    <div class="flex flex-col gap-6 fields">
                        @foreach ($cards as $key => $card)
                            <div wire:key="{{ $key }}" class="relative flex border shadow rounded-lg bg-white border-blue-100 hover:border-blue-300">

                                {{-- <div class="px-4 rounded-l-lg bg-green-300">
                                    <i class="inverted box icon"></i>
                                </div> --}}

                                {{-- image field --}}
                                <div wire:click.prevent="toggleLiteral({{ $key }})" class="flex flex-col justify-center items-center w-3/12 md:w-16 rounded-l-lg shadow-md">
                                    @if ($card['literal'])
                                        <span data-tooltip="Üretimden önce" data-variation="mini" data-position="top left" class="cursor-pointer">
                                            <i class="large red chevron left icon"></i>
                                        </span>
                                    @else
                                        <span data-tooltip="Üretimden sonra" data-variation="mini" data-position="top left" class="cursor-pointer">
                                            <i class="large green chevron right icon"></i>
                                        </span>
                                    @endif
                                </div>


                                <div class="p-3 flex-1 flex flex-col md:flex-row md:items-center gap-3 justify-between">
                                    <div class="flex flex-col">
                                        <div class="flex gap-2 items-center">
                                            <div class="font-bold">{{ $card['ingredient']['name'] }}</div>
                                            <div class="text-sm text-ease">({{ $card['ingredient']['code'] }})</div>
                                        </div>
                                        <div class="text-sm font-semibold text-green-500 hover:text-green-700 ease-in-out duration-200 cursor-default">
                                            <span>{{ $this->calculatedUnit($card) }}</span>
                                            <i wire:loading.class="animate-spin orange circle notch icon" wire:target="cards.{{ $key }}.unit_id, cards.{{ $key }}.amount"></i>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="flex gap-2 items-center">
                                        <x-dropdown iModel="cards.{{ $key }}.amount" iPlaceholder="sections/recipes.amount" iType="number"
                                            model="cards.{{ $key }}.unit_id" dataSource="cards.{{ $key }}.ingredient.units" :sId="'unit'.$key" sClass="basic"
                                            value="id" text="name" placeholder="{{ __('sections/units.unit') }}">
                                        </x-dropdown>
                                    </div>
                                </div>
                               

                                <button wire:click.prevent="removeCard({{ $key }})" class="absolute top-0 right-0 -mt-2 -mr-3 bg-white focus:outline-none opacity-75 hover:opacity-100">
                                    <i class="red shadow rounded-full cancel icon"></i>
                                </button>

                            </div>
                        @endforeach
                    </div>
                    {{-- CARDS ------------------------------------}}
                    @endif
                </div>

                {{-- MALZEMELER BÖLÜMÜ - MODAL ----------------------------}}
                @include('web.sections.recipes.materials')

            </div>
            @endif
            {{-- INGREDIENTS ---------------------------------------------------------------------------}}





    </x-content>
    @if ($selectedProduct)
        <x-form-buttons class="p-4 pt-6" submit="submit()" />
    @endif
</div>