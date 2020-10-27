
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
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $recipe)
                    <tr>
                        <td class="right marked collapsing font-bold ">{{ $key+1 }}</td>
                        <td class=""><a href="{{ route('recipes.show', ['recipe' => $recipe->id]) }}">{{ $recipe->code }}</a></td>
                        <td class="">{{ $recipe->product->name }}</td>
                        <td class="">
                            <span data-tooltip="@foreach ($recipe->ingredients as $ingredient) '{{ $ingredient->name }}' @endforeach">{{ $recipe->ingredients->count() }}</span>
                        </td>
                        <td>düzenle sil</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="w-full">
            {{ $data->links('components.tailwind-pagination') }}
        </div>
        
    </div>
</div>

