
<div>

    @if ($data->count() > 0)
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
                            <td>
                                @if (count($recipe->ingredients) > 0)
                                <span data-tooltip="@foreach ($recipe->ingredients as $ingredient) {{ $ingredient->name }} @endforeach">
                                    {{ __('sections/recipes.different_products', ['number' => $recipe->ingredients->count() ]) }}
                                </span>
                                @else 
                                <span class="text-xs text-orange-600 ">{{ __('sections/recipes.there_is_no_content_yet') }}</span>
                                @endif
                            </td>
                            <td class="collapsing">
                                <x-crud-actions modelName="recipe" :modelId="$recipe->id" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="w-full">
                {{ $data->links('components.tailwind-pagination') }}
            </div>
            
        </div>
    @else 
        <div class="ui placeholder segment h-full">
            <div class="ui icon header">
                <i class="mortar pestle icon"></i>
                <span>{{ __('sections/recipes.there_is_no_content_yet') }}</span>
            </div>
            <div class="flex items-center justify-center">
                <div class="ui animated link list">
                    <div class="item">
                        <a href="{{ route('recipes.create') }}" class="text-sm font-semibold">{{ __('common.add_from_here') }}.</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

