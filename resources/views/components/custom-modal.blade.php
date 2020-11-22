
<div x-show="{{ $active }}" x-cloak>
    <div class="fixed bottom-0 right-0 top-0 left-0 bg-black opacity-25 z-10" @click="{{ $active }} = false"></div>
    <div {{ $attributes->merge(['class' => 'fixed '. $position .' z-20 overflow-x-hidden bg-white shadow-xl max-w-screen-md'])}} style="min-width: 500px">
        @if ($header)
        <div class="pt-3 px-4 mb-2 bg-white shadow border">
            {{ $header }}
        </div>
        @endif
        <div class="px-4 pt-6 py-2">
            <div class="{{ $padding }} rounded-md shadow-md border border-{{ $theme }}-200 bg-white">
                {{ $slot }} 
            </div>
        </div>
    </div>
</div>