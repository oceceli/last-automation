<div>
    
    <x-table-toolbar :perPage="$perPage" /> 

    <div>

        <x-table>
            <thead>
                <tr>
                    <th>ürün</th>
                    <th>mevcut stok</th>
                    <th>son hareket</th>
                    {{-- <th></th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($stocks as $stock)
                <tr>
                    <td>{{ $stock['product']->name }}</td>
                    <td>{{ $stock['total'] }} {{ $stock['product']->baseUnit->name}}</td>
                    <td>{{ $stock['last_entry'] }}</td>
                </tr>
                @endforeach
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