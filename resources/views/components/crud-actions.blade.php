

<div class="flex gap-4 px-1 rounded bg-gray-50  hover:shadow-outline-teal shadow-md">
    <div data-tooltip="{{ __('common.detail') }}">
        <a href="{{ route("$pluralModelName.show", ["$modelName" => $modelId]) }}">
            <i class="link @if($gray) grey @else blue @endif eye icon"></i>
        </a>
    </div>
    @if (!$onlyShow)
    <div data-tooltip="{{ __('common.edit') }}">
        <a href="{{ route("$pluralModelName.edit", ["$modelName" => $modelId]) }}">
            <i class="pen alternate link @if($gray) grey @else orange @endif icon"></i>
        </a>
    </div>
    <div data-tooltip="{{ __('common.delete') }}">
        <i wire:click.prevent="delete({{ $modelId }})" class="eraser link @if($gray) grey @else inverted red @endif  icon"></i>
    </div>
    @endif
    {{ $slot }}
</div>