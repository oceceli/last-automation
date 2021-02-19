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
            <div class="flex flex-col gap-3">
                @foreach ($workOrder->product->recipe->calculateNecessaryIngredients($workOrder->wo_amount, $workOrder->unit_id) as $item)
                    <div x-data="{lotNumbers: false}" class="border p-4 {{ $classes['borderColor'] }} rounded hover:bg-cool-gray-50 border-dashed">
                        <div class="flex justify-between text-ease cursor-pointer" @click="lotNumbers = ! lotNumbers" >
                            <span class="font-bold">{{ $item['ingredient']->prd_name }}</span>
                            <div>
                                <span>{{ $item['amount'] }} {{ $item['unit']->name }}</span>
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
            {{-- <div class="p-2 border border-dashed">
                <x-necessary-ingredients :unitId="$workOrder->unit_id" :amount="$workOrder->wo_amount" :product="$workOrder->product" />
            </div> --}}
        </x-slot>

        <x-slot name="bottom">
            <div class="text-white">
                <div class="flex justify-between">
                    <div>
                        <i class="{{ $classes['icon'] }}"></i>
                        <span class="font-bold">
                            {{ __("workorders.{$workOrder->wo_status}") }}
                        </span>
                        <span class="text-xs">- {{ $classes['explanation'] }}</span>
                    </div>
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

