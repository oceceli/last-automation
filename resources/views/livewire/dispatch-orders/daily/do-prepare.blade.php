<div>
    <x-content>
        <div>
            
            {{-- <h5 class="">
                {{ __('dispatchorders.dispatch_address') }}
            </h5> --}}

            <div class="m-4 p-5 border rounded-sm shadow-lg relative bg-teal-1000">
                <div class="flex justify-between border-b border-white text-ease pb-2">
                    <div>
                        <h5 class="">
                            {{ $dispatchOrder->company->cmp_commercial_title }}
                        </h5>
                    </div>
                    <div>
                        <span class="text-xs">{{ __('dispatchorders.dispatch') }}</span>:
                        <span class="">
                            {{ $dispatchOrder->do_number }}
                        </span>
                    </div>
                </div>

                <div>
                    <div class="flex flex-col py-2 gap-2 text-ease">
                        <span>{{ $dispatchAddress }}</span>
                        <div>{{ __('validation.attributes.adr_phone') }}: {{ $dispatchOrder->address->adr_phone }}</div>
                    </div>
                    @if ($dispatchOrder->do_note)
                        <div class="mt-4 p-2 border rounded shadow">
                            <i class="comment alternate outline flipped icon"></i>
                            <i class="text-green-700">“{{ $dispatchOrder->do_note }}”</i>
                        </div>
                    @endif
                </div>
            </div>
            

            <div class="p-5">
                @if ($dispatchOrder->isNotCompleted())
                    <div class="flex items-center justify-between">
                        <div class="text-red-700 cursor-default">
                            <i class="shipping fast icon"></i>
                            <span class="font-bold">
                                {{ __('dispatchorders.there_are_number_variety_of_products_which_is_waiting_for_the_dispatch', ['number' => $dispatchOrder->dispatchProducts->count()]) }}
                            </span>
                        </div>
                        @if ($dispatchOrder->isAllReady())
                            <button wire:click.prevent="markAsCompleted()" class="ui mini label red button">
                                <i class="checkmark icon"></i>
                                {{ __('dispatchorders.mark_as_ready') }}
                            </button>
                        @endif
                    </div>
                @else
                    <div class="text-ease-green font-bold">
                        !! Tüm ürünler hazırlandı / araca yüklendi, onay bekliyor...
                    </div>
                @endif
                <div class="mt-2 p-1 border shadow-inner rounded border-blue-200">
                    @foreach($dispatchOrder->dispatchProducts as $key => $dispatchProduct)
                        <div class="pl-3 flex gap-4 justify-between items-center hover:bg-blue-50 rounded">
                            <div class="p-1 flex gap-4 items-center">
                                <div>
                                    @if (optional($dispatchProduct)->isReady())
                                        <x-span tooltip="{{ __('dispatchorders.ready_to_dispatch') }}" position="top left">
                                            <i class="green checkmark icon"></i>
                                        </x-span>
                                    @else
                                        <x-span tooltip="{{ __('dispatchorders.lot_sources_not_specified_yet') }}" position="top left">
                                            <i class="orange wait icon"></i>
                                        </x-span>
                                    @endif
                                </div>
                                {{-- <dive wire:click.prevent="openDoLotModal({{ $dispatchProduct->id }})" class="font-bold hover:bg-orange-100 hover:shadow p-1 rounded cursor-pointer flex-1"> --}}
                                <div class="font-bold  p-1">
                                    <span class="text-blue-600">{{ $dispatchProduct->product->code }}</span>
                                    <span class="text-xs text-ease">{{ $dispatchProduct->product->name }}</span>
                                    <span>- {{ $dispatchProduct->dp_amount }} {{ $dispatchProduct->product->baseUnit->name }}</span>
                                </div>
                            </div>

                            @if ($dispatchOrder->isNotCompleted())
                                <div>
                                    @if (! $dispatchProduct->isReady())
                                        <x-span wire:click.prevent="openDoLotModal({{ $dispatchProduct->id }})" tooltip="test" position="top right">
                                            <i class="orange plus link icon"></i>
                                        </x-span>
                                    @else
                                        <x-span wire:click.prevent="openDoLotModal({{ $dispatchProduct->id }})" tooltip="{{ __('common.edit') }}" position="top right">
                                            <i class="green edit alternate   link icon"></i>
                                        </x-span>
                                        <x-span wire:click.prevent="emptyDpReserveds({{ $dispatchProduct->id }})" tooltip="{{ __('dispatchorders.unload_products') }}" position="top right">
                                            <i class="red trash alternate outline link icon"></i>
                                        </x-span>
                                    @endif
                                </div>
                            @else
                                <x-span wire:click.prevent="openDoLotModal({{ $dispatchProduct->id }})" tooltip="test" position="top right">
                                    <i class="green eye link icon"></i>
                                </x-span>
                            @endif
                        </div>
                    @endforeach
                </div>
                
                    
            </div>

        </div>

        <x-slot name="bottom">
            <div class="text-xs text-ease shadow rounded p-2 bg-white">
                @if ($dispatchOrder->isNotCompleted())
                    <i class="triangle exclamation icon"></i>
                    {{ __('dispatchorders.whenever_products_prepared_or_loaded_on_vehicle_then_it_must_be_marked_as_ready') }}
                @else
                    asdf
                @endif
            </div>
        </x-slot>

    </x-content>

    
    @include('web.sections.dispatchorders.dispatchLotPicker')


</div>