<div>
    <x-page-header icon="mortar pestle" header="sections/recipes.header" subheader="sections/recipes.subheader" />
    <x-content theme="orange" buttons>


            {{-- RECIPE FORM ---------------------------------------------------------------------------}}
            <div class="p-6 shadow-md">
                <div class="ui small form">
                    <div class="equal width fields">
                        <x-dropdown.search model="product_id" label="sections/recipes.recipe_product" :collection="$this->producibles" value="id" text="name,code" id="selectProduct" class="required" sClass="search" />
                        
                        <x-input action model="code" label="sections/recipes.code" placeholder="sections/recipes.code" class="required">
                            <x-slot name="button">
                                <button wire:click.prevent="random" class="ui teal right labeled icon button" >
                                    <i class="icon random"></i>
                                    {{ __('sections/recipes.random_code') }}
                                </button>
                            </x-slot>
                        </x-input>
                    </div>
                    @if ($this->producibles->count() <= 0)
                        <div class="pt-2 font-semibold text-sm">Listede hiç ürün yok, öncelikle <a class="text-red-600" href="{{ route('products.create') }}">buradan</a> başlayın...</div>
                    @endif
                </div> 
            </div>
            {{-- RECIPE FORM ---------------------------------------------------------------------------}}




            
            {{-- INGREDIENTS ---------------------------------------------------------------------------}}
            @if ( ! empty($product_id))
            <div x-data="{materials: false}" class="p-6">
                @include('web.sections.recipes.ingredientHeader')     

                <div class="p-4 rounded-md border border-blue-200">
                    @if (empty($cards))
                        @include('web.sections.recipes.placeholder')
                    @else
                    {{-- CARDS ------------------------------------}}
                    <div class="flex flex-col gap-6">
                        @foreach ($cards as $key => $card)
                            <div class="relative flex border shadow rounded-lg bg-white border-blue-100 hover:border-blue-300">

                                {{-- image field --}}
                                <div class="flex w-16 pl-2 rounded-l-lg shadow-md justify-center items-center">
                                    <i class="large red box icon"></i>
                                </div>

                                <div class="flex flex-1 justify-between items-center p-3">
                                    <div>
                                        <div class="font-bold">{{ $card['ingredient']['name'] }}</div>
                                        <div class="text-sm text-gray-500">{{ $card['ingredient']['code'] }}</div>
                                    </div>
                                    @if(! empty($cards[$key]['unit_id']))
                                        {{ $cards[$key]['unit_id']}}
                                    @endif
                                    <div class="field flex items-center">
                                        <x-dropdown iModel="cards.{{ $key }}.amount" iPlaceholder="sections/recipes.amount" iType="number"
                                            model="cards.{{ $key }}.unit_id" dataSource="cards.{{ $key }}.ingredient.units" :key="$key" sClass="basic"
                                            triggerOnEvent="aCardDeleted" value="id" text="name" placeholder="{{ __('sections/units.unit') }}">
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
</div>