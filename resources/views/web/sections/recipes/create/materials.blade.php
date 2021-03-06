<x-custom-modal active="materials" padding>
    <x-slot name="header">
        <x-page-header icon="sitemap" header="recipes.add_ingredients" subheader="recipes.add_recipe_ingredients" />
    </x-slot>
    <div class="p-4">
        <div class="border border-dashed flex flex-col justify-center">
            @foreach ($this->categories as $category)
                <div class="hover:bg-gray-100  rounded-t border-b last:border-0" x-data="{caret: false}">

                    <div @click="caret = !caret" class="p-3 flex justify-between items-center cursor-pointer">
                        <div>
                            <i class="layer group icon"></i>
                            <span class="font-bold">{{ $category->ctg_name }}</span>
                            <span class="text-xs text-ease">kategorisi</span>
                            <div class="text-xs text-ease">
                                {{ $category->products->count() }} {{ ucfirst(__('products.product')) }}
                            </div>
                        </div>
                        <div class="text-right">
                            <i :class="{'caret down text-teal-800 icon': caret, 'caret right icon': !caret}"></i>
                        </div>
                    </div>

                    <div x-show.transition="caret" class="border-t">
                        <div class="border-l ml-5 hover:border-teal-400">
                            <div class="p-2">
                                @foreach ($category->products as $product)
                                    <div  wire:click.prevent="addCard({{ $product }})" class="flex gap-2 items-center hover:bg-teal-100 rounded px-2 py-1 cursor-pointer">
                                        <div>
                                            <i class="box icon"></i>
                                        </div>
                                        <div class="flex flex-1 justify-between items-center">
                                            <div>
                                                <div class="font-bold text-sm">{{ $product->prd_name }}</div>
                                                <div class="font-semibold text-xs text-ease ">{{ $product->prd_code }}</div>
                                            </div>
        
                                            @if ($this->isInCard($product->id))
                                                <div class="text-green-600 font-bold">
                                                    <span>{{ __('common.added' )}}</span>
                                                    <i class="checkmark icon"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-custom-modal>