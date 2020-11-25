<div>
    
    <x-table-toolbar :perPage="$perPage" /> 

    <div>

        <table class="ui celled sortable table tablet stackable very compact">
            <thead>
                <tr>
                    <th>Sıra</th>
                    <th>test</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $key => $model)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>test</td>
                    <td><div>Düzenle sil falan</div></td>
                </tr>
                @endforeach
            </tbody>
        </table>
       
        <div class="w-full">
            {{ $data->links('components.tailwind-pagination') }}
        </div>
        
    </div>
</div>

{{-- <div>
    <p class="text-sm">
        Toplam <strong class="text-red-800">{{ $total }}</strong> sonuçtan <strong>{{ $firstItem }} - {{ $firstItem + ($count-1) }}</strong> arası gösteriliyor
    </p>
</div> --}}        