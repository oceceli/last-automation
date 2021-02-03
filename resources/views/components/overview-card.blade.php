<div class="bg-white rounded shadow border">
    <div class="flex relative">

        <div class="bg-white rounded-l p-2">
            <div class="p-4 bg-{{ $color }}-500 hover:bg-{{ $color }}-400 rounded shadow ease-in-out duration-200">
                <i class="big text-white {{ $icon }} icon"></i>
            </div>
        </div>

        <div class="p-2 flex-1 ">
            {{ $slot }}
        </div>

        <div class="absolute bottom-0 right-0 -mb-3 -mr-2 shadow-md text-white">
            <a href="{{ $href }}" class="px-3 py-1 bg-{{ $color }}-500 rounded font-bold text-sm ease-in-out duration-200 hover:bg-{{ $color }}-400" style="color: inherit">
                <i class="right arrow icon"></i>
                {{ __('common.look_into') }}
            </a>
        </div>
        
    </div>
</div>