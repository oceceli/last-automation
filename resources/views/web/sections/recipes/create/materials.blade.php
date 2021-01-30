<x-custom-modal active="materials" padding>
    <x-slot name="header">
        <x-page-header icon="sitemap" header="recipes.add_ingredients" subheader="recipes.add_recipe_ingredients" />
    </x-slot>
    @foreach ($this->categories as $category)
        <div class="relative" x-data="{caret: false}">
            <div class="absolute w-full h-9 cursor-pointer text-right" @click="caret = !caret">
                <i :class="{'caret down text-teal-800 icon': caret, 'caret right icon': !caret}"></i>
            </div>
            <div class="ui list">
                <div class="item">
                    <i class="layer group icon"></i>
                    <div class="content">
                        <div class="header">{{ $category->name }}</div>
                        <div class="description">{{ $category->products->count() }} {{ ucfirst(__('products.product')) }}</div>
                        @foreach ($category->products as $product)
                            <div class="ui animated list selection" x-show="caret" x-transition:enter="transition ease-out duration-500" 
                                                                        x-transition:enter-start="opacity-0 transform scale-60" 
                                                                        x-transition:enter-end="opacity-100 transform scale-100" 
                                                                        x-transition:leave="transition ease-in duration-100" 
                                                                        x-transition:leave-start="opacity-100 transform scale-100" 
                                                                        x-transition:leave-end="opacity-0 transform scale-60">
                                <div class="item" wire:click.prevent="addCard({{ $product }})">
                                    <div class="flex gap-2 items-center hover:bg-yellow-100 rounded px-2 py-1">
                                        <div><i class="box icon"></i></div>
                                        <div class="flex flex-1 justify-between items-center">
                                            <div>
                                                <div class="header">{{ $product->name }}</div>
                                                <div class="description">{{ $product->code }}</div>
                                            </div>

                                            @if ($this->isInCard($product->id))
                                                <div class="text-green-600 font-bold">
                                                    <span>{{ __('common.added' )}}</span>
                                                    <i class="checkmark icon"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>  
        </div>
    @endforeach
</x-custom-modal>