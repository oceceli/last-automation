

<div x-show="{{ $active }}" @click.away="{{ $active }} = false" class="fixed top-0 right-0 bottom-0 z-10 overflow-x-hidden p-3 bg-white w-3/12 shadow-xl border-l border-teal-200">
    {{ $header }}
    <div class="border p-2 rounded-md bg-indigo-50 border-teal-300 border-dashed">
        <div class="p-3 px-5 rounded-md shadow-lg border border-teal-200 bg-teal-100">
            {{ $slot }} 
        </div>
    </div>
</div>