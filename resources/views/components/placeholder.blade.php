<div class="ui placeholder segment h-full cursor-default">
    <div class="ui icon header">
        <i class="{{ $icon }} icon"></i>
        <span class="text-gray-600 leading-8">{{ $header }}</span>
    </div>
    <div class="text-center text-gray-500 hover:text-gray-800 transition ease-in-out duration-200 transform hover:translate-x-1">
        {{ $slot }}
    </div>
</div>