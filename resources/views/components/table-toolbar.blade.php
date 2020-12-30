

<div class="bg-white border-t border-r border-l rounded-t-md p-4 flex justify-between items-center">
    <div class="ui tiny icon input" >
        <i class="search icon"></i>
        <input wire:model.debounce.150ms="searchQuery" type="text" placeholder="{{ __('common.search_in_database') }}">
    </div>
    <div class="ui tiny icon input w-28 border-green-500" data-tooltip="{{ __('datatable.perpage_explain') }}" data-position="left center" data-variation="tiny wide fixed">
        <i class="stream icon"></i>
        <input wire:model.debounce.300ms="perPage" type="number" value="{{ $perPage }}" placeholder="{{ __('datatable.perpage') }}">
    </div>
</div>