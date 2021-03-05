
<div>

        <x-table-toolbar :perPage="$perPage" /> 

        <div>

            <x-table class="sortable">
                <x-thead>
                    <x-table-row>
                        <x-thead-item class="collapsing center aligned clickable" sortBy="rcp_code">{{ __('validation.attributes.rcp_code') }}</x-thead-item>
                        <x-thead-item>{{ __('recipes.belongs_to') }}</x-thead-item>
                        <x-thead-item>{{ __('common.inside') }}</x-thead-item>
                        <x-thead-item></x-thead-item>
                    </x-table-row>
                </x-thead>
                <x-tbody>
                    @forelse ($data as $recipe)
                        <x-table-row>
                            <td class="collapsing center aligned font-bold">{{ $recipe->rcp_code }}</td>
                            <td class="">
                                <span>
                                    {{ optional($recipe->product)->prd_code }}
                                </span>
                                <span class="text-xs text-ease">
                                    {{ optional($recipe->product)->prd_name }}
                                </span>
                            </td>
                            <td>
                                @if (count($recipe->ingredients) > 0)
                                    <span>
                                        {{ __('recipes.different_products', ['number' => $recipe->ingredients->count() ]) }}
                                    </span>
                                @else 
                                    <span class="text-xs text-orange-600 ">{{ __('recipes.there_is_no_content_yet') }}</span>
                                @endif
                            </td>
                            <td class="collapsing">
                                <div class="crud-buttons">
                                    @can('view recipes')
                                        <x-show-button wire:key="showbutton_{{$loop->index}}" route="{{ route('recipes.show', ['recipe' => $recipe])}}" />
                                    @endcan
                                    @can('create update recipes')
                                        <x-edit-button wire:key="editbutton_{{$loop->index}}" route="{{ route('recipes.edit', ['recipe' => $recipe]) }}" />
                                    @endcan
                                    @can('delete recipes')
                                        <x-delete-button wire:key="deletebutton_{{$loop->index}}" action="delete({{ $recipe->id }})"  />
                                    @endcan
                                </div>
                            </td>
                        </x-table-row>
                    @empty
                        <tr>
                            <td colspan="10">
                                <x-placeholder icon="mortar pestle">
                                    {{ __('common.no_results') }}
                                </x-placeholder>
                            </td>
                        </tr>
                    @endforelse
                </x-tbody>
            </x-table>
            
        </div>

        {{ $data->links('components.tailwind-pagination') }}

        @include('web.helpers.deletable')

</div>

