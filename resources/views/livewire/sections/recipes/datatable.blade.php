
<div>
    <div class="bg-white border-t border-r border-l rounded-t-md  p-4 flex justify-between items-center">
        <div class="ui icon input w-28 border-green-500" wire:model.debounce.300ms="perPage" data-tooltip="{{ __('datatable.perpage_explain') }}" data-position="top left" data-variation="tiny wide fixed">
            <i class="stream icon"></i>
            <input type="number" value="{{ $perPage }}" placeholder="{{ __('datatable.perpage') }}">
        </div>
        <div class="ui icon input" wire:model.debounce.150ms="searchQuery">
            <i class="search icon"></i>
            <input type="text" placeholder="{{ __('common.search_in_database') }}">
        </div>
    </div>


    <div class="">

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

