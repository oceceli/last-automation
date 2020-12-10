<div class="rounded-md bg-{{ $statusColor }}-50 shadow-md">

    @include('web.sections.workorders.show.detailsHeadstick')
    


    <div class="grid grid-cols-1 md:grid-cols-2">
        <div class="border-b md:border-b-0 md:border-r p-3 flex flex-col gap-3">
            <x-label-value label="{{ __('sections/workorders.lot_no') }}" value="{{ $workOrder->lot_no }}"                              hover="{{ $statusColor }}" />
            <x-label-value label="{{ __('modelnames.product') }}" value="{{ $workOrder->product->name }}"                               hover="{{ $statusColor }}" />
            <x-label-value label="{{ __('sections/products.code') }}" value="{{ $workOrder->product->code }}"                           hover="{{ $statusColor }}" />
            <x-label-value label="{{ __('sections/workorders.amount') }}" value="{{ $workOrder->amount }} {{ $workOrder->unit->name }}" hover="{{ $statusColor }}" />
            <x-label-value label="{{ __('sections/workorders.queue') }}" value="{{ $workOrder->queue }}"                                hover="{{ $statusColor }}" />
        </div>

        <div class="p-3 m-4 rounded shadow-md border leading-8 cursor-default">
            @if ($workOrder->isFinalized())
                <div class="flex flex-col justify-between gap-2">
                    <div class="border-b pb-2">
                        <div>
                            <i class="calculator icon"></i>
                            <span class=>{{ __('common.total') }}:</span>
                            <span class="font-bold text-green-600">{{ $productionResults['gross'] }}</span> 
                            <span class="text-sm text-green-600">{{ $workOrder->product->getBaseUnit()->name }}</span>
                        </div>
                        <div>
                            <i class="trash icon"></i>
                            <span>{{ __('common.waste') }}:</span> 
                            <span class="font-bold text-red-600">{{ $productionResults['waste'] }}</span> 
                            <span class="text-sm text-red-600">{{ $workOrder->product->getBaseUnit()->name }}</span>
                        </div>
                    </div>
                    <div>
                        <i class="edit icon"></i>
                        <span>Net stoğa eklenen:</span> 
                        <u class="font-bold text-green-600 text-lg">{{ $productionResults['net'] }}</u>
                        <span class="text-sm text-green-600">{{ $workOrder->product->getBaseUnit()->name }}</span>
                    </div>
                </div>
            @elseif($workOrder->isInProgress())
                <span data-tooltip="{{ $this->inProduction->startedAt()->format('H:i:s') }}" data-variation="mini" data-position="top left">
                    <span class="font-bold text-yellow-500">{{ __('sections/workorders.production_started_at_time', ['time' => $this->inProduction->startedAt()->diffForHumans()]) }}...</span>
                </span>
            @elseif($workOrder->isActive())
                {{-- <x-necessary-ingredients :product="$workOrder->product" :amount="$amount" :unitId="$unit_id" /> --}}
                {{-- <h5 class="text-ease font-sans border-b">Gerekli malzemeler</h5>

                @foreach ($workOrder->necessaryIngredients as $necessary)
                    <div>
                        <span class="text-ease">{{ $necessary['ingredient']->name }}: </span> 
                        <span>{{ $necessary['amount'] }} </span>
                        <span>{{ $necessary['ingredient']->baseUnit->name }}</span>
                    </div>
                @endforeach

                                    <div>
                                        <div class="font-bold pb-2 text-gray-400">{{ __('sections/workorders.wo_status') }}</div>
                                        <div class="ui toggle checkbox">
                                            <input type="checkbox" wire:model="status">
                                            <label></label>
                                        </div>
                                    </div>
            @else
                                    <div>
                                        <div class="font-bold pb-2 text-gray-400">{{ __('sections/workorders.wo_status') }}</div>
                                        <div class="ui toggle checkbox">
                                            <input type="checkbox" wire:model="status">
                                            <label></label>
                                        </div>
                                    </div>
            @endif --}}
        </div>
    </div>

    
    @if ($workOrder->note)
        <div class="p-3 border-t shadow rounded-b-md">
            <i class="{{ $statusColor }} comment outline alternate icon"></i>
            <i class="text-{{ $statusColor }}-700">{{ $workOrder->note }}</i>
        </div>
    @endif

</div>

