<x-tbody-item class="two wide">
    @if ($dp->isReady())
        <span>
            <i class="green check circle icon"></i>
            <span class="text-sm">{{ __('common.ready') }}</span>
        </span>
    @else
        <span>
            <i class="red clock icon"></i>
            <span class="text-sm">{{ __('dispatchorders.not_prepared_yet') }}</span>
        </span>
    @endif
</x-tbody-item>
<x-tbody-item class="three wide">
    <span class="font-bold">{{ $dp->product->prd_code }}</span>
    <span class="text-xs text-ease">{{ $dp->product->prd_name }}</span>
</x-tbody-item>
<x-tbody-item class="">
    <span class="font-bold">{{ (float)$dp->dp_amount }} </span>
    <span class="text-sm">{{ $dp->unit->name }}</span>
</x-tbody-item>