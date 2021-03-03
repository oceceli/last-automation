<div class="bg-white rounded shadow p-2">
    <div class="flex relative border border-dashed">

        <div class="bg-white rounded-l p-2">
            <div class="p-4 {{ $bgColor }} rounded shadow ease-in-out duration-200">
                <i class="big text-white {{ $icon }} icon"></i>
            </div>
        </div>

        <div class="p-2 flex-1">
            <div>
                {{ __('common.this') }}
                <select wire:model="{{ $model }}" class="focus:outline-none bg-white">
                    <option selected value="week">{{ __('common.week')}}</option>
                    <option value="month">{{ __('common.month')}}</option>
                    <option value="year">{{ __('common.year')}}</option>
                </select>
            </div>
            <div class="pt-3">
                <span class="text-3xl ease {{ $textColor }} font-bold">
                    {{ $number }}
                </span>
                <span class="">{{ $text }}</span>
            </div>
        </div>

        <div class="absolute bottom-0 right-0 -mb-3 -mr-2 shadow-md text-white">
            <a href="{{ $href }}" class="px-3 py-1 {{ $bgColor }} rounded font-bold text-sm ease-in-out duration-200" style="color: inherit">
                <i class="right arrow icon"></i>
                {{ __('common.look_into') }}
            </a>
        </div>
        
    </div>
</div>