
<div class="p-4 shadow rounded-md bg-white">
        <div class="border border-{{ $theme }}-200 rounded-md flex flex-col">
                {{ $slot }}
        </div>
        @if ($buttons)
                <x-form-buttons />
        @endif
</div>