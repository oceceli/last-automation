<div>
    
    <div class="bg-white border-t border-r border-l rounded-t-md  p-4 flex justify-between items-center">
        <div class="ui icon input w-28 border-green-500" wire:model.debounce.300ms="perPage" data-tooltip="{{ __('datatable.perpage_explain') }}" data-position="top left" data-variation="tiny wide fixed">
            <i class="stream icon"></i>
            <input type="number" value="{{ $perPage }}" placeholder="{{ __('datatable.perpage') }}">
        </div>
        <div class="ui icon input" wire:model.debounce.150ms="searchQuery">
            <i class="search icon"></i>
            <input type="text" placeholder="{{ __('common.search_in_database') }}">
        </div>
    </div>
    <div class="">
        <table class="ui celled table">
            <thead>
                <tr>
                    <th>Sıra</th>
                    @foreach ($attributes as $attribute)
                        <th>{{ __('sections/products.'.$attribute) }}</th>
                    @endforeach
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $key => $value)
                <tr>
                    <td>{{ $key+1 }}</td>
                    @foreach ($attributes as $attribute)
                        @if ($value->$attribute == null)
                            <td><i class="text-red-500 text-sm">{{ __('common.empty') }}</i></td>
                        @else
                            @if (strlen($value->$attribute) > 20)
                                <td>
                                    <i class="font-hairline text-yellow-900" data-tooltip="{{ $value->$attribute }}" data-position="top left" data-variation="tiny wide fixed">
                                        {{ substr($value->$attribute, 0, 20) }}...
                                    </i>
                                </td>
                            @else
                                <td>{{ $value->$attribute }}</td> 
                            @endif
                        @endif
                    @endforeach
                    <td><div>Düzenle sil falan</div></td>
                </tr>
                @endforeach
            </tbody>
            {{-- <tfoot>
                <tr>
                    <th colspan="5">
                        <div class="ui right floated pagination menu">
                            <a class="icon item">
                                <i class="left chevron icon"></i>
                            </a>
                            <a class="item">1</a>
                            <a class="item">2</a>
                            <a class="item">3</a>
                            <a class="item">4</a>
                            <a class="icon item">
                                <i class="right chevron icon"></i>
                            </a>
                        </div>
                    </th>,
                </tr>
            </tfoot> --}}
        </table>
       


        

            {{-- <div>
                <p class="text-sm">
                    Toplam <strong class="text-red-800">{{ $total }}</strong> sonuçtan <strong>{{ $firstItem }} - {{ $firstItem + ($count-1) }}</strong> arası gösteriliyor
                </p>
            </div> --}}


        <div class="w-full">
            {{ $data->links('components.semantic-pagination') }}
        </div>

            



        
    </div>
</div>
