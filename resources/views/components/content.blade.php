
<div class="shadow @if(!$noBorder) border border-{{ $theme }}-200 @endif rounded-md bg-white">
        <div class="flex flex-col">
                {{ $slot }}
        </div>
        @if ($buttons)
                <x-form-buttons />
        @endif
</div>