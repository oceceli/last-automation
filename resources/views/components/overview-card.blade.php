<div class="bg-white rounded shadow border">
    <div class="flex">

        <div class="bg-white rounded-l p-2">
            <div class="p-4 bg-{{ $color }}-500 hover:bg-{{ $color }}-400 rounded shadow">
                <i class="big text-white {{ $icon }} icon"></i>
            </div>
        </div>

        <div class="p-2 flex-1">
            {{ $slot }}
        </div>
        
    </div>
</div>