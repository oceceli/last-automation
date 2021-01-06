
<x-container>
        {{ $header }}
        <div class="shadow-md @if(!$noBorder) border border-{{ $theme }}-200 @endif rounded bg-white">
                <div class="flex flex-col">
                        {{ $slot }}
                </div>
                @if ($buttons)
                        <x-form-buttons />
                @endif
        </div>
</x-container>
