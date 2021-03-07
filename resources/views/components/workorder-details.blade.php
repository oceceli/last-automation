<div>
    <x-form-divider noButtons bottomClass="{{ $classes['bottomClass'] }}">
        <x-slot name="left">
            <div class="p-4 shadow-lg border rounded {{ $classes['borderColor'] }}">
                <x-list-item>
                    <span>{{ __('validation.attributes.prd_name') }}</span>
                    <span>{{ $workOrder->product->prd_name }}</span>
                </x-list-item>
                <x-list-item>
                    <span>{{ __('validation.attributes.wo_lot_no') }}</span>
                    <span>{{ ucfirst($workOrder->wo_lot_no) }}</span>
                </x-list-item>
                <x-list-item>
                    <span>{{ __('validation.attributes.wo_amount') }}</span>
                    <span>{{ $workOrder->wo_amount }} {{ $workOrder->unit->name }}</span>
                </x-list-item>
                <x-list-item>
                    <span>{{ __('validation.attributes.wo_datetime') }}</span>
                    <span>{{ $workOrder->wo_datetime }}</span>
                </x-list-item>
                <x-list-item>
                    <span>{{ __('validation.attributes.wo_code') }}</span>
                    <span>{{ $workOrder->wo_code }}</span>
                </x-list-item>
                <x-list-item>
                    <span>{{ __('validation.attributes.wo_queue') }}</span>
                    <span>{{ $workOrder->wo_queue }}</span>
                </x-list-item>
                @if ($workOrder->isInProgress())
                    <x-list-item>
                        <span>{{ __('validation.attributes.wo_started_at') }}</span>
                        <span>{{ $workOrder->wo_started_at }}</span>
                    </x-list-item>
                @endif
            </div>
        </x-slot>

        <x-slot name="right">
            @if ($workOrder->isCompleted() || $workOrder->isApproved())
                <div class="border rounded text-center">

                    <div class="shadow p-2">
                        <span class="text-green-700">{{ $workOrder->productionResults['total'] }}</span> -
                        <span class="text-red-700">{{ $workOrder->productionResults['waste'] }}</span> =
                        <span class="text-green-700 font-bold">{{ $workOrder->productionResults['net'] }}</span>
                        <span> 
                            {{ strtolower($workOrder->product->baseUnit->name) }} 
                            <span class="font-bold">{{ $workOrder->product->prd_name }}</span> stoğa eklendi.
                        </span>
                    </div>

                    <div class="p-2 pt-4">
                        <div class="font-bold">Üretimde kullanılan malzemeler:</div>
                        <div class="pt-2">
                            @foreach ($workOrder->ingredientMoves as $stockMove)
                                <x-list-item>
                                    <div>
                                        <span>{{ $stockMove->product->prd_code }}</span>
                                        <span class="text-xs">({{ $stockMove->lot_number }})</span>
                                    </div>
                                    <span>{{ $stockMove->base_amount }} {{ $stockMove->product->baseUnit->name }}</span>
                                </x-list-item>
                            @endforeach
                        </div>
                    </div>

                </div>
            @else
                <div class="flex flex-col gap-3">
                    @foreach ($workOrder->product->recipe->calculateNecessaryIngredients($workOrder->wo_amount, $workOrder->unit_id) as $item)
                        <div x-data="{lotNumbers: false}" @click="lotNumbers = ! lotNumbers" class="border p-4 {{ $classes['borderColor'] }} rounded hover:bg-cool-gray-50 border-dashed cursor-pointer">
                            <div class="flex justify-between">
                                <span class="font-bold">{{ $item['ingredient']->prd_name }}</span>
                                <div>
                                    <span>{{ number_format($item['amount'],2, ',', '.') }} {{ $item['unit']->name }}</span>
                                    <span x-show="!lotNumbers" class="pl-6"><i class="caret right icon"></i></span>
                                    <span x-show="lotNumbers" class="pl-6"><i class="caret down icon"></i></span>
                                </div>
                            </div>
                            <div x-show="lotNumbers" class="pt-2">
                                <x-reserved-stocks-table :reservations="$workOrder->reservationsFor($item['ingredient']['id'])->get()" noHead noProduct emptyMessage="dispatchorders.not_ready_yet" />
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </x-slot>

        <x-slot name="bottom">
            <div class="text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <i class="{{ $classes['icon'] }}"></i>
                        <span class="font-bold">
                            {{ __("workorders.{$workOrder->wo_status}") }}
                        </span>
                        <span class="text-xs">- {{ $classes['explanation'] }}</span>
                    </div>
                    @if ($viewOnly === false && $workOrder->isCompleted())
                        <div>
                            <button wire:click.prevent="woDeny({{ $workOrder->id }})" class="ui mini white button" data-tooltip="{{ __('workorders.wo_will_fallback_to_inprogress_state') }}" data-variation="mini" data-position="top right" >
                                <i class="red ban icon"></i>
                                {{ __('common.deny') }}
                            </button>
                            <button wire:click.prevent="woApprove({{ $workOrder->id }})" class="ui mini white button" data-tooltip="{{ __('workorders.production_results_will_be_added_to_stock') }}" data-variation="mini" data-position="top right">
                                <i class="green checkmark icon"></i>
                                {{ __('common.confirm') }}
                            </button>
                        </div>
                    @endif
                </div>
                @if ($workOrder->wo_note)
                    <div class="mt-4 p-2 border rounded shadow">
                        <i class="comment alternate outline flipped icon"></i>
                        <i class="">{{ $workOrder->wo_note }}</i>
                    </div>
                @endif
            </div>
        </x-slot>

    </x-form-divider>
</div>

