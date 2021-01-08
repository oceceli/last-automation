<div>
    <x-table-toolbar :perPage="$perPage" /> 
    <div>
        
        <x-table class="celled ui celled sortable table tablet stackable very compact">
            <x-thead>
                <tr>
                    <x-thead-item>Firma Adı</x-thead-item>
                    <x-thead-item>Ticari Ünvan</x-thead-item>
                    <x-thead-item>Cari Kodu</x-thead-item>
                    <x-thead-item>Vergi Numarası</x-thead-item>
                    <x-thead-item>Telefon</x-thead-item>
                    {{-- <x-thead-item>Adres</x-thead-item> --}}
                    <x-thead-item>Açıklama</x-thead-item>
                    
                </tr>
            </x-thead>
            <x-tbody>
                {{-- @foreach ($companies as $company) --}}
                    <tr>
                        {{-- <x-tbody-item>{{ $company->cmp_name }}</x-tbody-item>
                        <x-tbody-item>{{ $company->cmp_commercial_title }}</x-tbody-item>
                        <x-tbody-item>{{ $company->cmp_current_code }}</x-tbody-item>
                        <x-tbody-item>{{ $company->cmp_tax_number }}</x-tbody-item>
                        <x-tbody-item>{{ $company->cmp_phone  }}</x-tbody-item>
                        <x-tbody-item>{{ $company->address  }}</x-tbody-item>
                        <x-tbody-item>{{ $company->cmp_note  }}</x-tbody-item> --}}
                    </tr>
                {{-- @endforeach --}}
            </x-tbody>
        </x-table>
    </div>

</div>

                {{-- <x-thead-item>Adres Adı</x-thead-item>
                <x-thead-item>Ülke</x-thead-item>
                <x-thead-item>Şehir</x-thead-item>
                <x-thead-item>İlçe</x-thead-item>
                <x-thead-item>Detay</x-thead-item>
                <x-thead-item>Telefon</x-thead-item>
                <x-thead-item>Açıklama</x-thead-item> --}}