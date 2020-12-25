<div class="fixed top-0 right-0 left-0 bottom-0 bg-smoke-light z-50 flex overflow-auto" x-show="{{ $active }}" x-cloak>
    <div class="{{ $position }} h-full md:h-auto w-full md:w-max-content shadow">
        
        <div class="md:py-6">
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
</div>
