<x-app-layout>
    <div class="flex gap-4">
        <div class="p-6 rounded-lg bg-green-50 shadow w-1/2">
            <div class="pb-6 flex justify-between">
                <div><h4 class="text-red-900">{{__('sections/workorders.queue')}}: {{ $workOrder->queue }}</h4></div>
                <div><h4>{{ __('sections/workorders.datetime') }}: {{ $workOrder->datetime }}</h4></div>
            </div>
            <hr>
            <div class="pt-6">
                <div class="ui very relaxed large animated list">
                    <div class="item">
                      <div class="content">
                        <div class="header">{{ __('sections/products.name') }}</div>
                        <a href="{{ route('products.show', ['product' => $workOrder->recipe->product])}}">{{ $workOrder->recipe->product->name }}</a>
                      </div>
                    </div>
                    <div class="item">
                      <div class="content">
                        <div class="header">{{ __('sections/workorders.amount') }}</div>
                        {{ $workOrder->amount }} Lt
                      </div>
                    </div>
                    <div class="item">
                      <div class="content">
                        <div class="header">{{ __('sections/workorders.lot_no')}}</div>
                        {{ $workOrder->lot_no }}
                      </div>
                    </div>
                    <div class="item">
                      <div class="content">
                        <div class="header">{{ __('sections/workorders.code') }}</div>
                        {{ $workOrder->code }}
                      </div>
                    </div>
                    <div class="item">
                      <div class="content">
                        <div class="header">{{ __('sections/workorders.is_active')}}</div>
                        <input disabled type="checkbox" name="public" :checked="{{ $workOrder->is_active }}">
                      </div>
                    </div>
                    <div class="item">
                      <div class="content">
                        <div class="header">{{ __('sections/workorders.in_progress')}}</div>
                        {{ $workOrder->in_progress }}
                      </div>
                    </div>
                    <div class="item">
                      <div class="content">
                        <div class="header">{{ __('sections/workorders.is_completed')}}</div>
                        {{ $workOrder->is_completed }} <i class="red cancel icon"></i>
                      </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div>test</div>
    </div>
</x-app-layout>