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
                    <x-thead-item sortBy="cmp_note">Açıklama</x-thead-item>
                    <x-thead-item sortBy="">!! Kayıtlı adresler</x-thead-item>
                    
                </tr>
            </x-thead>
            <x-tbody>
                @foreach ($data as $company)
                    <tr>
                        <x-tbody-item>{{ $company->cmp_name }}</x-tbody-item>
                        <x-tbody-item>{{ $company->cmp_commercial_title }}</x-tbody-item>
                        <x-tbody-item>{{ $company->cmp_current_code }}</x-tbody-item>
                        <x-tbody-item>{{ $company->cmp_tax_number }}</x-tbody-item>
                        <x-tbody-item>{{ $company->cmp_phone  }}</x-tbody-item>
                        <x-tbody-item>{{ $company->cmp_note  }}</x-tbody-item>
                        <x-tbody-item class="text-xs text-ease">!!! 8 adres kayıtlı</x-tbody-item>
                    </tr>
                @endforeach
            </x-tbody>
        </x-table>
        {{ $data->links('components.tailwind-pagination') }}
    </div>

</div>

                {{-- <x-thead-item>Adres Adı</x-thead-item>
                <x-thead-item>Ülke</x-thead-item>
                <x-thead-item>Şehir</x-thead-item>
                <x-thead-item>İlçe</x-thead-item>
                <x-thead-item>Detay</x-thead-item>
                <x-thead-item>Telefon</x-thead-item>
                <x-thead-item>Açıklama</x-thead-item> --}}