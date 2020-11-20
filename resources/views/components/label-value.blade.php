<div {{ $attributes->merge(['class' => 'cursor-default gap-1 flex']) }}>
    <div class="font-bold text-gray-500 text-sm hover:text-gray-800 transition ease-in-out duration-150 ">{{ $label }}:</div>
    <div class="font-bold text-gray-600 hover:text-{{ $hover }}-700 transition ease-in-out duration-200">{{ $value }}</div>
</div>