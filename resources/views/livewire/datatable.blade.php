<div>
    
    <x-table-toolbar :perPage="$perPage" /> 

    <div>

        <table class="ui celled sortable table tablet stackable very compact">
            <thead>
                <tr>
                    <th>Sıra</th>
                    @foreach ($attributes as $attribute)
                        <th>{{ __('sections/' . Illuminate\Support\Str::plural(strToLower($modelName))  . '.' . $attribute) }}</th>
                    @endforeach
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $key => $model)
                <tr>
                    <td>{{ $key+1 }}</td>
                    @foreach ($attributes as $attribute)
                        @if ($model->$attribute == null)
                            <td><i class="text-red-500 text-sm">{{ __('common.empty') }}</i></td>
                        @else
                            @if (strlen($model->$attribute) > 20)
                                <td>
                                    <i class="font-hairline text-yellow-900" data-tooltip="{{ $model->$attribute }}" data-position="top left" data-variation="tiny wide fixed">
                                        {{ substr($model->$attribute, 0, 20) }}...
                                    </i>
                                </td>
                            @else
                                <td>{{ $model->$attribute }}</td> 
                            @endif
                        @endif
                    @endforeach
                    <td><div>Düzenle sil falan</div></td>
                </tr>
                @endforeach
            </tbody>
        </table>
       
        
    </div>
    {{ $data->links('components.tailwind-pagination') }}
</div>

{{-- <div>
    <p class="text-sm">
        Toplam <strong class="text-red-800">{{ $total }}</strong> sonuçtan <strong>{{ $firstItem }} - {{ $firstItem + ($count-1) }}</strong> arası gösteriliyor
    </p>
</div> --}}        