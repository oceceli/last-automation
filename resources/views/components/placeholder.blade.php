<div {{ $attributes->merge(['class' => 'ui placeholder segment h-full cursor-default'])}}>
    <div class="ui icon header">
        <i class="{{ $icon }} icon"></i>
        <span class="text-gray-600 leading-8">{{ $header }}</span>
    </div>
    <div {{ $attributes->merge(['class' => 'text-center text-ease'])}}>
        {{ $slot }}
    </div>
</div>