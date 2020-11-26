<div>
    
    <x-table-toolbar :perPage="$perPage" /> 

    <div>

        <x-table>
            <thead>
                <tr>
                    <th>ürün</th>
                    <th>Stok miktarı</th>
                    <th>Son giriş</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ($stockMoves as $calc)
                <tr>
                    <td>{{ $calc->product->name }}</td>
                    <td>{{ $calc->total_amount }}</td>
                    <td>{{ $calc->last_entry }}</td>
                </tr>
                @endforeach --}}
            </tbody>
        </x-table>

       
        {{-- <div class="w-full">
            {{ $data->links('components.tailwind-pagination') }}
        </div> --}}
        
    </div>
</div>

{{-- <div>
    <p class="text-sm">
        Toplam <strong class="text-red-800">{{ $total }}</strong> sonuçtan <strong>{{ $firstItem }} - {{ $firstItem + ($count-1) }}</strong> arası gösteriliyor
    </p>
</div> --}}        