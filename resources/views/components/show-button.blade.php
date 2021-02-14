@if ($action)
    <span wire:click.prevent="{{ $action }}" data-tooltip="{{ __('common.detail') }}" data-variation="mini">
        <i class="link eye icon hover:text-green-500"></i>
    </span>
@else
    <span data-tooltip="{{ __('common.detail') }}" data-variation="mini">
        <a href="{{ $route }}" style="color: inherit">
            <i class="link eye icon hover:text-green-500"></i>
        </a>
    </span>
@endif