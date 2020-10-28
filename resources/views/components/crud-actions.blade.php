

<div class="flex gap-4">
    <div data-tooltip="{{ __('common.detail') }}">
        <a href="{{ route("$pluralModelName.show", ["$modelName" => $modelId]) }}">
            <i class="circular link blue eye icon"></i>
        </a>
    </div>
    <div data-tooltip="{{ __('common.edit') }}">
        <a href="{{ route("$pluralModelName.edit", ["$modelName" => $modelId]) }}">
            <i class="bordered orange pen alternate link circular icon"></i>
        </a>
    </div>
    <div data-tooltip="{{ __('common.delete') }}">
        <i wire:click.prevent="delete({{ $modelId }})" class="bordered red eraser link circular inverted icon"></i>
    </div>
</div>