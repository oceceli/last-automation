

<div class="p-4 bg-white md:border-t md:border-r md:border-l md:rounded-t-md" x-data="{showFilters: @entangle('showFilters'), dateRange: @entangle('showDateFilters')}">
    <div class="flex justify-between items-center">

        <div class="flex gap-2 items-center">

            <div class="ui tiny icon input" >
                <i class="search icon"></i>
                <input wire:model.debounce.150ms="searchQuery" type="text" placeholder="{{ __('common.search_in_database') }}">
            </div>
            <div @click="dateRange = ! dateRange" class="text-xs @if($this->showDateFilters) text-ease-red @else text-ease-green @endif cursor-pointer">
                <x-span tooltip="{{ __('common.date_range') }}">
                    <i class="large calendar alternate icon"></i>
                </x-span>
            </div>
            <div x-show.transition.in="dateRange">
                <input wire:model="filterFromDate" type="date" class="focus:outline-none bg-white font-bold rounded p-1 border">
                <i class="small exchange icon"></i>
                <input wire:model="filterToDate" type="date" class="focus:outline-none bg-white font-bold rounded p-1 border">
            </div>

            @if ($filters)
                <div x-show.transition.in="! showFilters" @click="showFilters = true" class="text-xs text-ease-green cursor-pointer">
                    <i class="large filter icon"></i>
                    {{ __('common.filter') }}
                </div>
                <div x-show.transition.in="showFilters" @click="showFilters = false" class="text-xs text-ease-red cursor-pointer">
                    {{-- <i class="large filter icon"></i> --}}
                    <i class="large cancel icon"></i>
                    {{ __('common.remove_filters') }}
                </div>
            @endif

        </div>

        <div class="flex gap-5 items-center">
            <div>
                <x-span tooltip="PDF olarak indir">
                    <i wire:click="exportToPDF" class="large pdf file  icon text-ease-red cursor-pointer"></i>
                </x-span>
                <x-span tooltip="Excel olarak indir">
                    <i wire:click="exportToExcel" class="large excel file icon text-ease-green cursor-pointer"></i>
                </x-span>
            </div>
            <div class="ui tiny icon input w-28 border-green-500" data-tooltip="{{ __('datatable.perpage_explain') }}" data-position="left center" data-variation="tiny wide fixed">
                <i class="stream icon"></i>
                <input wire:model.debounce.300ms="perPage" type="number" value="{{ $perPage }}" placeholder="{{ __('datatable.perpage') }}">
            </div>
        </div>

    </div>

    <div x-show.transition="showFilters" class="mt-4 p-3 text-sm border rounded bg-white shadow">
        {{ $filters }}
    </div>
    
</div>