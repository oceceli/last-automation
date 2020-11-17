
<div class="p-4 shadow rounded-md bg-white">
        <div class="@if(!$noBorder) border border-{{ $theme }}-200 @endif rounded-md flex flex-col">
                {{ $slot }}
        </div>
        @if ($buttons)
                <x-form-buttons />
        @endif
</div>