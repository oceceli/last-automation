    <div>

        @if ($data->count() > 0)
        <x-table-toolbar :perPage="$perPage" /> 

        <div>
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
                            <td class="collapsing">
                                <x-crud-actions modelName="work-order" :modelId="$workOrder->id" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="ui placeholder segment h-full">
                <div class="ui icon header">
                    <i class="project diagram icon"></i>
                    <a href="{{ route('work-orders.create') }}" class="text-blue-600 font-bold focus:outline-none">{{ __('common.click_here_link') }}</a> {{ __('sections/workorders.create_workorder') }}
                </div>
                <div class="text-sm font-semibold text-gray-500 text-center">{{ __('sections/workorders.no_workorder_found') }}</div>
            </div>
            @endif
           
            <div class="w-full">
                {{ $data->links('components.tailwind-pagination') }}
            </div>

            
        </div>
    </div>