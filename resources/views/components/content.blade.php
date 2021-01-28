
<x-container {{ $attributes }}>
        {{ $header }}
        <div class="shadow-md @if(!$noBorder) border border-{{ $theme }}-200 @endif rounded bg-white">
                <div class="flex flex-col">
                        {{ $slot }}
                </div>
                @if ($buttons)
                        <x-form-buttons />
                @endif
        </div>

        @if ($bottom)
                <div class="mt-3">
                        {{ $bottom }}
                </div>
        @endif

</x-container>
