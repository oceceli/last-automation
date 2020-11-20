<div>
    <div class="p-3 rounded-lg bg-white">
        <div class="bg-white rounded-md border border-teal-200">





            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 w-full p-4 shadow">
                <div class="text-left">
                    <label class="text-gray-500">{{ __('sections/workorders.code') }}:</label>
                    <span class="font-bold">{{ $workOrder->code }}</span>
                </div>
                
                <div class="text-right">
                    <label class="text-gray-500">{{ __('sections/workorders.datetime') }}:</label>
                    @if ($workOrder->is_active)
                        <u class="text-green-500 font-bold">{{ $workOrder->datetime }}</u>
                    @else
                        <s class="text-red-500 font-bold">{{ $workOrder->datetime }}</s>
                    @endif
                </div>
            </div>



            <div class="p-6">
                <div class="p-4 border shadow rounded-sm @if($workOrder->isCompleted()) bg-green-50 @else bg-orange-50 @endif">
                    <div class="border-b pb-4 flex justify-between items-center">
                        <div>
                            <label class="text-gray-500">{{ __('modelnames.product') }}:</label>
                            <span class="font-bold text-teal-600">{{ $product->name }}</span>
                        </div>
                        <div class="text-gray-500">
                            <label class="text-gray-500">{{ __('sections/products.code') }}:</label>
                            <span class="font-bold">{{ $product->code }}</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 w-full pt-4 border-dashed rounded-md">
                        <div class="text-left">
                            <label class="text-gray-500">{{ __('sections/workorders.amount') }}: </label> 
                            <u class="font-bold">{{ $workOrder->amount }}</u>
                            <span class="font-bold">{{ $workOrder->unit->name }}</span>
                        </div>
                        
                        <div class="text-left md:text-center">
                            <label class="text-gray-500">{{ __('sections/workorders.lot_no') }}: </label> 
                            <u class="font-bold">{{ $workOrder->lot_no }}</u>
                        </div>
    
                        <div class="text-left md:text-right">
                            <label class="text-gray-500">{{ __('sections/workorders.queue') }}: </label> 
                            <span class="font-bold">{{ $workOrder->queue }}</span>
                        </div>
                    </div>
                    
                    @if ($workOrder->note)
                    <div class="mt-8 p-3 border rounded-md shadow-inner">
                        <i class="green comment outline alternate icon"></i>
                        <i class="text-green-700">{{ $workOrder->note }}</i>
                    </div>
                    @endif
                </div>




                <div class="mt-4 flex justify-between items-center">
                    <div class="font-bold text-xl border p-2 rounded shadow-md">
                        @if ($workOrder->isCompleted())
                            <span class="text-green-500">Üretim sonuçlandı!</span>
                        @else
                            @if ($workOrder->inProgress())
                                <i class="circular green loading cog link icon"></i>
                                <span>{{ __('sections/workorders.production_continues') }}</span>
                            @else
                                @if ($workOrder->is_active)
                                    <span class="text-yellow-500">{{ __('sections/workorders.waiting_for_production') }}</span>
                                @else
                                    <span class="text-red-600">{{ __('common.suspended') }}</span>
                                @endif
                            @endif
                        @endif
                    </div>
                    @if ($workOrder->isNotCompleted() && ! $workOrder->inProgress())
                    <div>
                        <div class="font-bold pb-2 text-gray-400">{{ __('sections/workorders.wo_status') }}</div>
                        <div class="ui toggle checkbox">
                            <input type="checkbox" wire:model="is_active">
                            <label></label>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            




        </div>
    </div>
</div>
