@if(session()->has('success'))  
    <div {{ $attributes->merge(['class' => 'relative']) }} x-data="{showInfoArea: true}" x-show="showInfoArea">
        <div class="mb-4 md:mb-0 mt-4 mx-5">
            <div class="ui success message">
                <div class="header">
                    <i class="info icon"></i>
                    {{ session()->get('success') }}
                </div>
            </div>
        </div>
        <button wire:click.prevent @click="showInfoArea = false" class="absolute top-0 right-0 -mt-2 mx-1 focus:outline-none opacity-75 hover:opacity-100">
            <i class="red shadow rounded-full cancel icon"></i>
        </button>
    </div>
@endif