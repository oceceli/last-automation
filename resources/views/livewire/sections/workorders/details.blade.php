<div class="rounded-md bg-{{ $statusColor }}-50 shadow-md">

    @include('web.sections.workorders.detailsHeadstick')
    


    <div class="grid grid-cols-1 md:grid-cols-2">
        <div class="border-b md:border-b-0 md:border-r p-3 flex flex-col gap-3">
            <x-label-value label="{{ __('sections/workorders.lot_no') }}" value="{{ $workOrder->lot_no }}"                              hover="{{ $statusColor }}" />
            <x-label-value label="{{ __('modelnames.product') }}" value="{{ $workOrder->product->name }}"                               hover="{{ $statusColor }}" />
            <x-label-value label="{{ __('sections/products.code') }}" value="{{ $workOrder->product->code }}"                           hover="{{ $statusColor }}" />
            <x-label-value label="{{ __('sections/workorders.amount') }}" value="{{ $workOrder->amount }} {{ $workOrder->unit->name }}" hover="{{ $statusColor }}" />
            <x-label-value label="{{ __('sections/workorders.queue') }}" value="{{ $workOrder->queue }}"                                hover="{{ $statusColor }}" />
        </div>

        @if ($workOrder->isCompleted())
            <div class="p-3 m-4 select-text rounded border relative">
                <div class="font-bold text-lg">
                    <span>{{ __('common.total') }}:</span>
                    <span>{{ $productionResults['gross'] }}</span> 
                    <span class="text-sm text-gray-600">{{ $workOrder->product->getBaseUnit()->name }}</span>
                </div>
                <div class="font-bold text-lg">
                    <span>{{ __('common.waste') }}:</span> 
                    <span>{{ $productionResults['waste'] }}</span> 
                    <span class="text-sm text-gray-600">{{ $workOrder->product->getBaseUnit()->name }}</span>
                </div>
                <div class="font-bold text-lg">
                    <span>Net stoğa eklenen:</span> 
                    <span>{{ $productionResults['net'] }}</span>
                    <span class="text-sm text-gray-600">{{ $workOrder->product->getBaseUnit()->name }}</span>
                </div>
            </div>
        @endif
    
        
    </div>
    @if ($workOrder->note)
        <div class="p-3 border-t shadow rounded-b-md">
            <i class="{{ $statusColor }} comment outline alternate icon"></i>
            <i class="text-{{ $statusColor }}-700">{{ $workOrder->note }}</i>
        </div>
    @endif



</div>