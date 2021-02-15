
<div>

        <x-table-toolbar :perPage="$perPage" /> 

        <div>

            <table class="ui celled sortable table tablet stackable very compact">
                <thead>
                    <tr>
                        <x-thead-item>Sıra</x-thead-item>
                        <x-thead-item sortBy="code">{{ __('recipes.code') }}</x-thead-item>
                        <x-thead-item>{{ __('recipes.belongs_to') }}</x-thead-item>
                        <x-thead-item>{{ __('recipes.count_of_ingredients') }}</x-thead-item>
                        <x-thead-item></x-thead-item>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $key => $recipe)
                        <tr>
                            <td class="right marked collapsing font-bold ">{{ $key+1 }}</td>
                            <td class="collapsing">{{ $recipe->rcp_code }}</td>
                            <td class="">{{ $recipe->product->prd_name }}</td>
                            <td>
                                @if (count($recipe->ingredients) > 0)
                                    <span data-tooltip="@foreach ($recipe->ingredients as $ingredient) {{ $ingredient->prd_name }} @endforeach">
                                        {{ __('recipes.different_products', ['number' => $recipe->ingredients->count() ]) }}
                                    </span>
                                @else 
                                    <span class="text-xs text-orange-600 ">{{ __('recipes.there_is_no_content_yet') }}</span>
                                @endif
                            </td>
                            <td class="collapsing">
                                <x-crud-actions show delete edit modelName="recipe" :modelId="$recipe->id" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">
                                <x-placeholder icon="mortar pestle">
                                    {{ __('common.no_results') }}
                                </x-placeholder>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
        </div>

        {{ $data->links('components.tailwind-pagination') }}

        @include('web.helpers.deletable')

</div>

