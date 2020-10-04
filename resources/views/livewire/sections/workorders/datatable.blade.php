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
            <table class="ui celled sortable selectable table tablet stackable very compact">
                <thead>
                    <tr>
                        <th>{{ __('sections/workorders.code') }}</th>
                        <th>{{ __('sections/products.name') }}</th>
                        <th>{{ __('sections/workorders.amount') }}</th>
                        <th>{{ __('sections/workorders.lot_no') }}</th>
                        <th>{{ __('sections/workorders.datetime') }}</th>
                        <th>{{ __('sections/workorders.queue') }}</th>
                        {{-- <th>{{ __('sections/workorders.in_progress') }}</th>     --}}
                        <th>{{ __('sections/workorders.is_active') }}</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $workOrder)
                        <tr>
                            <td class="right marked collapsing font-bold ">{{ $workOrder->code }}</td>
                            <td>{{ $workOrder->recipe->product->name }}</td>
                            <td>{{ $workOrder->amount }}</td>
                            <td>{{ $workOrder->lot_no }}</td>
                            <td>{{ $workOrder->datetime }}</td>
                            <td><a href="{{ route('work-orders.show', ['work_order' => $workOrder]) }}">{{ $workOrder->queue }}</a></td>
                            {{-- <td>{{ $workOrder->in_progress }}</td> --}}
                            <td>{{ $workOrder->is_active }}</td>
                            {{-- <td class="">Onay<i class="green checkmark icon"></i></td> --}}
                            <td>düzenle sil</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
           
            <div class="w-full">
                {{ $data->links('components.tailwind-pagination') }}
            </div>

            <div>
                test
            </div>
        </div>
    </div>

    
    {{-- <div>
        <p class="text-sm">
            Toplam <strong class="text-red-800">{{ $total }}</strong> sonuçtan <strong>{{ $firstItem }} - {{ $firstItem + ($count-1) }}</strong> arası gösteriliyor
        </p>
    </div> --}}        





    {{-- @foreach($data as $key => $model)
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
                    @endforeach --}}