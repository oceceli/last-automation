<div>
    <x-container>
        <x-table-toolbar :perPage="$perPage">
            <x-slot name="filters">
                <div  class="responsive-grid-3-4">
                    {{-- <x-checkbox wire:key="filters" label="test" model="cmp_supplier" /> --}}
                    <div class="border border-dashed p-2 flex justify-around items-center gap-5">
                        <x-checkbox model="cmp_supplier" label="{{ __('validation.attributes.cmp_supplier') }}" />
                        ve
                        <x-checkbox model="cmp_customer" label="{{ __('validation.attributes.cmp_customer') }}" />
                    </div>

                </div>
            </x-slot>    
        </x-table-toolbar> 
        <div>
            
            <x-table class="ui celled sortable table tablet stackable very compact">
                <x-thead>
                    <x-table-row>
                        <x-thead-item>{{ __('common.type') }}</x-thead-item>
                        <x-thead-item sortBy="cmp_name">{{ __('validation.attributes.cmp_name') }}</x-thead-item>
                        <x-thead-item sortBy="cmp_commercial_title">{{ __('validation.attributes.cmp_commercial_title') }}</x-thead-item>
                        <x-thead-item sortBy="cmp_current_code">{{ __('validation.attributes.cmp_current_code') }}</x-thead-item>
                        <x-thead-item sortBy="cmp_tax_number">{{ __('validation.attributes.cmp_tax_number') }}</x-thead-item>
                        <x-thead-item sortBy="cmp_phone">{{ __('validation.attributes.cmp_phone') }}</x-thead-item>
                        {{-- <x-thead-item sortBy="cmp_note">Açıklama</x-thead-item> --}}
                        <x-thead-item>{{ __('addresses.addresses')}}</x-thead-item>
                        <x-thead-item></x-thead-item>
                    </x-table-row>
                </x-thead>
                <x-tbody>
                    @forelse ($data as $company)
                        <x-table-row wire:key="{{ $loop->index }}">
                            <x-tbody-item class="collapsing center aligned text-sm">@include('web.sections.companies.index.company-type')</x-tbody-item>
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
                        </x-table-row>
                    @empty
                    <tr>
                        <td colspan="10">
                            <x-placeholder icon="building">
                                {{ __('common.no_results') }}
                            </x-placeholder>
                        </td>
                    </tr>
                    @endforelse
                </x-tbody>
            </x-table>
        </div>
        {{ $data->links('components.tailwind-pagination') }}



        @if ($addressModal)
            <div x-data="{addressModal: @entangle('addressModal')}">
                <x-custom-modal active="addressModal" header="{{ __('companies.add_address_to_name_company', ['name' => $selectedCompany->cmp_name]) }}">
                    @include('web.sections.addresses.address-form')
                </x-custom-modal>
            </div>
        @endif
        
        @include('web.sections.companies.index.show-modal')

        @include('web.helpers.deletable')


    </x-container>

</div>