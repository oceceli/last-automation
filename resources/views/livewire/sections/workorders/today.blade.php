<div>
    <x-page-header icon="loading cog" header="sections/workorders.daily_work_orders" subheader="{{ $today }}" />
    <x-content theme="green">
        <div class="p-4">
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
                    @foreach ($todaysList as $key => $workOrder)
                        <tr>
                            <td class="right marked collapsing font-bold ">{{ $workOrder->code }}</td>
                            <td>{{ $workOrder->product->name }}</td>
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
        </div>
    </x-content>
</div>
