<x-custom-modal active="showModal" header="!!! header">
    <div class="">
        <div class="shadow-md p-4">
            <x-list-item>
                <label>{{ __('validation.attributes.cmp_name') }}</label>
                <span>{{ $company->cmp_name }}</span>
            </x-list-item>
            <x-list-item>
                <label>{{ __('validation.attributes.cmp_commercial_title') }}</label>
                <span>{{ $company->cmp_commercial_title }}</span>
            </x-list-item>
            <x-list-item>
                <label>{{ __('validation.attributes.cmp_current_code') }}</label>
                <span>{{ $company->cmp_current_code }}</span>
            </x-list-item>
            <x-list-item>
                <label>{{ __('validation.attributes.cmp_tax_number') }}</label>
                <span>{{ $company->cmp_tax_number }}</span>
            </x-list-item>
            <x-list-item>
                <label>{{ __('validation.attributes.cmp_phone') }}</label>
                <span>{{ $company->cmp_phone  }}</span>
            </x-list-item>
            @if ($company->cmp_note)
                <x-list-item>
                    <label>{{ __('validation.attributes.cmp_note') }}</label>
                    <span>{{ $company->cmp_note  }}</span>
                </x-list-item>
            @endif
        </div>

        <div class="p-5">
            @include('web.sections.addresses.editable')
        </div>
    </div>
</x-custom-modal>