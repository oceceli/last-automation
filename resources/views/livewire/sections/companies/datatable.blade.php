<div>
    <x-table-toolbar :perPage="$perPage" /> 
    <div>
        
        <x-table class="ui celled sortable table tablet stackable very compact">
            <x-thead>
                <tr>
                    <x-thead-item sortBy="cmp_name">Firma Adı</x-thead-item>
                    <x-thead-item sortBy="cmp_current_code">Ticari Ünvan</x-thead-item>
                    <x-thead-item sortBy="cmp_commercial_title">Cari Kodu</x-thead-item>
                    <x-thead-item sortBy="cmp_tax_number">Vergi Numarası</x-thead-item>
                    <x-thead-item sortBy="cmp_phone">Telefon</x-thead-item>
                    {{-- <x-thead-item sortBy="cmp_note">Açıklama</x-thead-item> --}}
                    <x-thead-item>!! Kayıtlı adresler</x-thead-item>
                    <x-thead-item></x-thead-item>
                    
                </tr>
            </x-thead>
            <x-tbody>
                @foreach ($data as $company)
                    <tr wire:key="{{ $loop->index }}">
                        <x-tbody-item>{{ $company->cmp_name }}</x-tbody-item>
                        <x-tbody-item>{{ $company->cmp_commercial_title }}</x-tbody-item>
                        <x-tbody-item>{{ $company->cmp_current_code }}</x-tbody-item>
                        <x-tbody-item>{{ $company->cmp_tax_number }}</x-tbody-item>
                        <x-tbody-item>{{ $company->cmp_phone  }}</x-tbody-item>
                        {{-- <x-tbody-item>{{ $company->cmp_note  }}</x-tbody-item> --}}
                        <x-tbody-item class=" flex justify-between items-center">
                            <div class="text-ease text-sm">{{ __('addresses.found_count_addresses', ['count' => $company->addresses->count()]) }}</div>
                            <span wire:click.prevent="addAddress({{ $company->id }})" data-tooltip="{{ __('addresses.add_address') }}" data-variation="mini">
                                <i class="blue plus link icon"></i>
                            </span>
                        </x-tbody-item>
                        <x-tbody-item class="collapsing">
                            <x-crud-actions show delete edit modelName="company" :modelId="$company->id" />
                        </x-tbody-item>
                    </tr>
                @endforeach
            </x-tbody>
        </x-table>
        {{ $data->links('components.tailwind-pagination') }}
    </div>



    @if ($addressModal)
        <div x-data="{addressModal: @entangle('addressModal')}">
            <x-custom-modal active="addressModal" header="!!! header">
                @include('web.sections.addresses.AddressForm')
                {{-- <livewire:sections.addresses.form  addressableType="App\Models\Company" :addressableId="$companyId"> --}}
            </x-custom-modal>
        </div>
    @endif


</div>