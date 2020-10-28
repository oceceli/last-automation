
<div>

    <x-table-toolbar :perPage="$perPage" /> 

    <div>

        <table class="ui celled sortable table tablet stackable very compact">
            <thead>
                <tr>
                    <th>Sıra</th>
                    <th>{{ __('sections/recipes.code') }}</th>
                    <th>{{ __('sections/recipes.belongs_to') }}</th>
                    <th>{{ __('sections/recipes.count_of_ingredients') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $recipe)
                    <tr>
                        <td class="right marked collapsing font-bold ">{{ $key+1 }}</td>
                        <td class="collapsing">{{ $recipe->code }}</td>
                        <td class="">{{ $recipe->product->name }}</td>
                        <td class="">
                            <span data-tooltip="@foreach ($recipe->ingredients as $ingredient) {{ $ingredient->name }} @endforeach">
                                {{ __('sections/recipes.different_products', ['number' => $recipe->ingredients->count() ]) }}
                            </span>
                        </td>
                        <td class="collapsing">
                            <x-crud-actions modelName="recipe" :modelId="$recipe->id" />
                            {{-- <div class="flex gap-4">
                                <div data-tooltip="{{ __('common.detail') }}">
                                    <a href="{{ route('recipes.show', ['recipe' => $recipe->id]) }}">
                                        <i class="circular link blue eye icon"></i>
                                    </a>
                                </div>
                                <div data-tooltip="{{ __('common.edit') }}">
                                    <a href="{{ route('recipes.edit', ['recipe' => $recipe->id]) }}">
                                        <i class="bordered orange pen alternate link circular icon"></i>
                                    </a>
                                </div>
                                <div data-tooltip="{{ __('common.delete') }}">
                                    <i wire:click.prevent="delete({{ $recipe->id }})" class="bordered red eraser link circular inverted icon"></i>
                                </div>
                            </div> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="w-full">
            {{ $data->links('components.tailwind-pagination') }}
        </div>
        
    </div>
</div>

