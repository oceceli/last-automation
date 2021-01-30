
{{-- İkinci sıra --}}
<x-tbody-item>
    {{ $dispatchOrder->address->adr_name }}
    <span class="text-xs text-ease">
        ({{ __('common.phone') }}: {{ $dispatchOrder->address->adr_phone }})
    </span>
</x-tbody-item>
<x-tbody-item class="collapsing">
    {{ $dispatchOrder->company->cmp_commercial_title }}
    <span class="text-xs text-ease">
        ({{ __('validation.attributes.cmp_current_code')}}: {{ $dispatchOrder->company->cmp_current_code }})
    </span>
</x-tbody-item>
<x-tbody-item class="font-bold right aligned">{{ $dispatchOrder->do_number }}</x-tbody-item>