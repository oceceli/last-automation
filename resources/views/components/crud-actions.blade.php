<div class="flex justify-around items-center gap-2 px-1 rounded bg-gray-50  hover:shadow shadow-md hover:bg-gray-200 ease-in-out duration-150 {{ $addClass }}">
    {{ $slot }}
    
    @if ($show)
        <div data-tooltip="{{ __('common.detail') }}" data-variation="mini">
            <a href="{{ route("$pluralModelName.show", ["$modelName" => $modelId]) }}">
                <i class="link @if($gray) grey @else blue @endif eye icon"></i>
            </a>
        </div>
    @endif
    @if ($edit)
        <div data-tooltip="{{ __('common.edit') }}" data-variation="mini">
            <a href="{{ route("$pluralModelName.edit", ["$modelName" => $modelId]) }}">
                <i class="pen alternate link @if($gray) grey @else orange @endif icon"></i>
            </a>
        </div>
    @endif
    @if ($delete)
        <div data-tooltip="{{ __('common.delete') }}" data-variation="mini">
            <i wire:click.prevent="delete({{ $modelId }})" class="eraser link @if($gray) grey @else inverted red @endif  icon"></i>
        </div>
    @endif
</div>  