<div {{ $attributes->merge(['class' => 'rounded-t'])}}>
    <div class="grid @if($right) grid-cols-1 md:grid-cols-2 @endif border-b">
        <div class="p-6 {{ $lClass }}">
            {{ $left }}
        </div>

        @if ($right)
        <div class="border-t md:border-t-0 md:border-l p-6 border-dashed border-gray-200 {{ $rClass }}">
            {{ $right }}
        </div>
        @endif

    </div>
    @if ($bottom)
    <div class="p-6 shadow-md {{ $bottomClass }}">
        {{ $bottom }}
    </div>
    @endif
    @if (! $noButtons)
    <div class="p-6 rounded-b-md border-t">
        <x-form-buttons />
    </div>
    @endif

</div>
















{{-- <div class="rounded-t">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 border-b">
        <div class="p-6">
            {{ $left }}
        </div>

        <div class="border-t md:border-t-0 md:border-l p-6 border-dashed border-gray-200">
            {{ $right }}
        </div>

    </div>
    @if ($bottom)
    <div class="p-6 shadow-md">
        {{ $bottom }}
    </div>
    @endif
    @if (! $noButtons)
    <div class="p-6 rounded-b-md">
        <x-form-buttons />
    </div>
    @endif

</div> --}}