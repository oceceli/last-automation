
<div>

    <x-table-toolbar :perPage="$perPage" /> 

    <div>

        <table class="ui celled sortable table tablet stackable very compact">
            <thead>
                <tr>
                    <th>Sıra</th>
                    <th>{{ __('sections/recipes.code') }}</th>
                    <th>{{ __('sections/recipes.belongs_to') }}</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $recipe)
                    <tr>
                        <td class="right marked collapsing font-bold ">{{ $key+1 }}</td>
                        <td class="">{{ $recipe->code }}</td>
                        <td class="">{{ $recipe->product->name }}</td>
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

