
{{-- <div x-show="{{ $active }}" x-cloak>
    <div class="fixed bottom-0 right-0 top-0 left-0 bg-black opacity-25 z-10" @click="{{ $active }} = false"></div>
    <div {{ $attributes->merge(['class' => 'fixed '. $position .' z-20 overflow-x-hidden bg-white shadow-xl'])}}> 
        @if ($header)
        <div class="pt-3 px-4 mb-2 bg-white shadow border">
            {{ $header }}
        </div>
        @endif
        <div class="px-4 pt-6 py-2">
            <div class="{{ $padding }} rounded-md shadow-md border border-{{ $theme }}-200 bg-white relative">
                {{ $slot }} 
                <button @click="{{ $active }} = false" class="absolute top-0 right-0 -mt-3 -mr-3 bg-white focus:outline-none opacity-75 hover:opacity-100">
                    <i class="red shadow rounded-full large cancel icon"></i>
                </button>
            </div>
        </div>
    </div>
</div> --}}





<div class="fixed top-0 right-0 left-0 bottom-0 bg-smoke-light z-50 flex overflow-auto" x-show="{{ $active }}" x-cloak>
    <div class="bg-white {{ $position }} h-full md:h-auto w-full md:max-w-md shadow" >
        
        <div class="{{ $padding }} md:rounded-md shadow-md bg-white">
            <div class="{{ $headerClass }} border flex justify-between items-center p-2">
                <div>
                    @if($header)
                        {{ $header }}
                    @endif
                </div>
                <button class="focus:outline-none opacity-75 hover:opacity-100 ease-in-out duration-150"
                        wire:click.prevent="{{ $atClose }}" @if(!$atClose) @click="{{ $active }} = false" @endif>
                    <i class="black shadow rounded-full large cancel icon"></i>
                </button>
            </div>
            {{ $slot }} 
        </div>

    </div>
</div>
