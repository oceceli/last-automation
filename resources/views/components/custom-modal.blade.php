<div class="fixed top-0 right-0 left-0 bottom-0 bg-white overflow-hidden md:bg-smoke-light z-50 flex md:overflow-auto" x-show.transition="{{ $active }}" x-cloak>
    <div class="{{ $position }} h-full md:h-auto w-full max-w-5xl"> {{-- bu ölçülerin yeniden tanımlanması lazım adamakıllı otursun ekrana --}}
        
        {{-- <div class="{{ $padding }} md:rounded-md md:py-6"> --}}
            
            <div class="text-right pb-1">
                <button class="focus:outline-none pt-2" wire:click.prevent="{{ $atClose }}" @if(!$atClose) @click="{{ $active }} = false" @endif>
                    <i class="text-red-500 hover:text-red-400 ease large rounded-full cancel icon"></i>
                </button>
            </div>
            <div {{ $attributes->merge(['class' => 'shadow-md bg-white rounded']) }}>
                {{ $slot }} 
            </div>
        {{-- </div> --}}

    </div>
</div>




{{-- <div class="{{ $headerClass }} border flex justify-between items-center p-2">
                    <div class="text-ease font-bold pr-16 pl-2">
                        @if($header)
                            {{ $header }}
                        @endif
                    </div>
                </div> --}}