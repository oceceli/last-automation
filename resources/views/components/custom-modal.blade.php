

<div x-show="{{ $active }}" @click.away="{{ $active }} = false" {{ $attributes->merge(['class' => 'fixed top-0 right-0 bottom-0 z-10 overflow-x-hidden bg-white w-3/12 bg-white shadow-xl border-l border-'.$theme.'-200'])}}>
    @if ($header)
    <div class="pt-3 px-4 mb-2 bg-white shadow border">
        {{ $header }}
    </div>
    @endif
    <div class="px-4 py-2">
        <div class="px-4 py-2 rounded-md shadow-md border border-{{ $theme }}-200 bg-white">
            {{ $slot }} 
        </div>
    </div>
</div>