@if ($selectedCompany)
    <div x-data="{showModal: @entangle('showModal')}">
        <x-custom-modal active="showModal" header="{{ __('companies.company_informations') }}">
            <div>
                <div class="shadow-md p-4">
                    <x-list-item>
                        <label>{{ __('validation.attributes.cmp_name') }}</label>
                        <span>{{ $selectedCompany->cmp_name }}</span>
                    </x-list-item>
                    <x-list-item>
                        <label>{{ __('validation.attributes.cmp_commercial_title') }}</label>
                        <span>{{ $selectedCompany->cmp_commercial_title }}</span>
                    </x-list-item>
                    <x-list-item>
                        <label>{{ __('validation.attributes.cmp_current_code') }}</label>
                        <span>{{ $selectedCompany->cmp_current_code }}</span>
                    </x-list-item>
                    <x-list-item>
                        <label>{{ __('validation.attributes.cmp_tax_number') }}</label>
                        <span>{{ $selectedCompany->cmp_tax_number }}</span>
                    </x-list-item>
                    <x-list-item>
                        <label>{{ __('validation.attributes.cmp_phone') }}</label>
                        <span>{{ $selectedCompany->cmp_phone  }}</span>
                    </x-list-item>
                    @if ($selectedCompany->cmp_note)
                        <x-list-item>
                            <label>{{ __('validation.attributes.cmp_note') }}</label>
                            <span>{{ $selectedCompany->cmp_note  }}</span>
                        </x-list-item>
                    @endif
                </div>

                <div class="p-5 max-w-full">
                    @include('web.sections.addresses.editable')
                </div>
            </div>
        </x-custom-modal>
    </div>
@endif