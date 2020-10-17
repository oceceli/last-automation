

{{-- @if ($currentProduct) --}}
<div class="relative border rounded-t bg-gray-50 shadow-inner" style="min-height: 60%" x-data="{'materials' : false}">
                        
    {{-- BAŞLIK VE BUTONLAR --}}

    {{ $title }}
    
    <div class="shadow-inner relative">

        {{-- İÇERİK - CARD KISMI   md:h-96 overflow-x-hidden  --}}
        <div class="p-5 py-7">
            <div class="flex flex-col gap-3">
                @if (! $addedMaterial)

                    {{ $ifNoMaterial }}

                @else
                    {{-- @foreach ($addedMaterial as $key => $item)
                        <div class="bg-white shadow rounded-lg flex border border-red-100 relative hover:border-red-300" style="min-height: 50px">

                            <div class="w-16 flex pl-2 rounded-l-lg justify-center items-center shadow-md">
                                <i class="large red box icon"></i>
                            </div>

                            {{ $content }}

                            <button wire:click.prevent="{{ $removeItemFunction }}({{ $key }})" class="absolute top-0 right-0 -mt-2 -mr-3 focus:outline-none hover:opacity-100 opacity-50">
                                <i class="red shadow rounded-full cancel icon"></i>
                            </button>
                            
                        </div>
                    @endforeach --}}
                    {{ $content }}

                @endif
            </div>
            
            {{ $plusButtonAction }}

        </div>
    </div>                
</div>
{{-- @endif --}}





                {{-- <div class="ui placeholder segment h-full">
                    <div class="ui icon header">
                        <i class="blue atom left bottom corner icon"></i>
                        <i class="flask icon"></i>
                        <button @click="materials = true" wire:click.prevent class="text-blue-600 font-bold focus:outline-none">Buradan</button> reçete içeriği oluşturun
                    </div>
                    <div class="text-sm text-center">{ürün} içeriği burada görüntülenecek</div>
                </div> --}}