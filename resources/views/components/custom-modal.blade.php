

<div x-show="{{ $active }}" @click.away="{{ $active }} = false" {{ $attributes->merge(['class' => 'fixed top-0 right-0 bottom-0 z-10 overflow-x-hidden p-3 bg-white w-3/12 bg-white shadow-xl border-l border-'.$theme.'-200'])}}>
    <div class="border p-2 rounded-md bg-{{ $theme }}-50 border-{{ $theme }}-300 border-dashed">
        <div class="p-2 rounded-md shadow-lg border border-{{ $theme }}-200 bg-{{ $theme }}-100">
            <div class="pt-3 px-4 mb-2 bg-white rounded-lg shadow border">
                {{ $header }}
            </div>
            {{ $slot }} 
        </div>
    </div>
</div>