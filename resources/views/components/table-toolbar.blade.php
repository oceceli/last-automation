

<div class="p-4 bg-white md:border-t md:border-r md:border-l md:rounded-t-md" x-data="{showFilters: false}">
    <div class="flex justify-between items-center">

        <div class="flex gap-2 items-center">
            <div class="ui tiny icon input" >
                <i class="search icon"></i>
                <input wire:model.debounce.150ms="searchQuery" type="text" placeholder="{{ __('common.search_in_database') }}">
            </div>
            @if ($filters)
            <div @click="showFilters = ! showFilters" class="text-xs text-ease-red cursor-pointer">
                <i class="filter icon"></i>
                Filtrele
            </div>
            @endif
        </div>

        <div class="flex gap-5 items-center">
            <div>
                <x-span tooltip="PDF olarak indir">
                    <i class="large pdf file  icon text-ease-red cursor-pointer"></i>
                </x-span>
                <x-span tooltip="Excel olarak indir">
                    <i wire:click="export" class="large excel file  icon text-ease-green cursor-pointer"></i>
                </x-span>
            </div>
            <div class="ui tiny icon input w-28 border-green-500" data-tooltip="{{ __('datatable.perpage_explain') }}" data-position="left center" data-variation="tiny wide fixed">
                <i class="stream icon"></i>
                <input wire:model.debounce.300ms="perPage" type="number" value="{{ $perPage }}" placeholder="{{ __('datatable.perpage') }}">
            </div>
        </div>

    </div>
    <div x-show.transition="showFilters" class="mt-4 p-2 text-sm border rounded bg-white shadow">
        {{ $filters }}
    </div>
</div>