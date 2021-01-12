<div>
    <x-container>
        <x-table-toolbar :perPage="$perPage" /> 
        <div>
            
            <x-table class="ui celled sortable table tablet stackable very compact">
                <x-thead>
                    <tr>
                        <x-thead-item>{{ __('common.type') }}</x-thead-item>
                        <x-thead-item sortBy="cmp_name">{{ __('validation.attributes.cmp_name') }}</x-thead-item>
                        <x-thead-item sortBy="cmp_commercial_title">{{ __('validation.attributes.cmp_commercial_title') }}</x-thead-item>
                        <x-thead-item sortBy="cmp_current_code">{{ __('validation.attributes.cmp_current_code') }}</x-thead-item>
                        <x-thead-item sortBy="cmp_tax_number">{{ __('validation.attributes.cmp_tax_number') }}</x-thead-item>
                        <x-thead-item sortBy="cmp_phone">{{ __('validation.attributes.cmp_phone') }}</x-thead-item>
                        {{-- <x-thead-item sortBy="cmp_note">Açıklama</x-thead-item> --}}
                        <x-thead-item>{{ __('addresses.addresses')}}</x-thead-item>
                        <x-thead-item></x-thead-item>
                        
                    </tr>
                </x-thead>
                <x-tbody>
                    @foreach ($data as $company)
                        <tr wire:key="{{ $loop->index }}">
                            <x-tbody-item class="collapsing text-sm">{{ $company->type }}</x-tbody-item>
                            <x-tbody-item class="collapsing">{{ $company->cmp_name }}</x-tbody-item>
                            <x-tbody-item class="collapsing">{{ $company->cmp_commercial_title }}</x-tbody-item>
                            <x-tbody-item class="collapsing">{{ $company->cmp_current_code }}</x-tbody-item>
                            <x-tbody-item>{{ $company->cmp_tax_number }}</x-tbody-item>
                            <x-tbody-item>{{ $company->cmp_phone  }}</x-tbody-item>
                            {{-- <x-tbody-item>{{ $company->cmp_note  }}</x-tbody-item> --}}
                            <x-tbody-item class=" flex justify-between items-center">
                                <div wire:click="openShowModal({{ $company->id }})" class="text-ease cursor-pointer text-sm">{{ __('addresses.found_count_addresses', ['count' => $company->addresses->count()]) }}</div>
                                <span wire:click.prevent="addAddress({{ $company->id }})" data-tooltip="{{ __('addresses.add_address') }}" data-variation="mini">
                                    <i class="blue plus link icon"></i>
                                </span>
                            </x-tbody-item>
                            <x-tbody-item class="collapsing">
                                <div>
                                    <x-crud-actions delete edit modelName="company" :modelId="$company->id">
                                        <div wire:click="openShowModal({{ $company->id }})" data-tooltip="{{ __('common.detail') }}" data-variation="mini">
                                            <i class="link eye icon"></i>
                                        </div>
                                    </x-crud-actions>
                                </div>
                            </x-tbody-item>
                        </tr>
                    @endforeach
                </x-tbody>
            </x-table>
            {{ $data->links('components.tailwind-pagination') }}
        </div>



        @if ($addressModal)
            <div x-data="{addressModal: @entangle('addressModal')}">
                <x-custom-modal active="addressModal" header="{{ __('companies.add_address_to_name_company', ['name' => $selectedCompany->cmp_name]) }}">
                    @include('web.sections.addresses.AddressForm')
                </x-custom-modal>
            </div>
        @endif
        
        @include('web.sections.companies.showModal')

    </x-container>

</div>