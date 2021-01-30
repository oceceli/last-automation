<div {{ $attributes->merge(['class' => 'h-full']) }}>
    @if ($listings)
        <div class="h-full flex flex-col gap-5 relative">
            @if (!$noHeader)
                <div class="py-5 text-center shadow">
                    <h5 class="leading-tight font-light text-ease">{{ $headerText }}</h5>
                </div>
            @endif
            <div class="p-8">
        
                @foreach ($listings as $item)
                    <x-custom-list wire:key="{{ $loop->index }}">
                        <div class="flex items-center gap-1">
                            <div>{{ $item['ingredient']->name }}</div>
                            <span class="text-xs hidden md:block"> ({{ $item['ingredient']->code }})</span> 
                        </div>
                        <div>
                            @if ($item['ingredient']->pivot->literal) <span class="text-xs text-ease-green">{{ __('common.net') }}</span>
                            @else <span class="text-xs text-ease-green">{{ __('common.variable') }}</span>
                            @endif
                            <span>
                                {{ number_format($item['amount'],2, ',', '.') }}
                            </span>
                            <span>
                                {{ $item['unit']->name }}
                            </span>
                        </div>
                    </x-custom-list>
                @endforeach
        
            </div>
            @if ($actions)
                <div class="p-4 sticky bottom-0 right-0 left-0 hover:bg-smoke-lighter bg-smoke-lightest ease-in-out duration-500">
                    {{ $actions }}
                </div>
            @endif
        </div>
    @else
        <x-placeholder icon="primary tasks">
            <span class="text-sm">
                {{ __('workorders.please_fill_in_the_amount_and_unit_fields') }}
            </span>
        </x-placeholder>
    @endif
</div>
