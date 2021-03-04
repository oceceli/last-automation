<div class="p-4">

    {{-- özet kartlar --}}
    <div class="grid md:grid-cols-3 gap-5">
        <x-overview-card model="woFrq" number="{{ number_format($this->woCountOverview(), 0, ',', '.') }}" text="üretim yapıldı..." icon="industry" bgColor="bg-red-500 hover:bg-red-700" textColor="text-red-500 hover:text-red-700" />
        <x-overview-card model="doFrq" number="{{ number_format($this->doCountOverview(), 0, ',', '.') }}" text="sevkiyat yapıldı..." icon="fast shipping" bgColor="bg-blue-500 hover:bg-blue-700" textColor="text-blue-500 hover:text-blue-700" />
        <x-overview-card model="smFrq" number="{{ number_format($this->smCountOverview(), 0, ',', '.') }}" text="stok girişi yapıldı..." icon="warehouse" bgColor="bg-green-500 hover:bg-green-700" textColor="text-green-500 hover:text-green-700" />
    </div>


    {{-- Kritik stok --}}
   

    @if ($this->criticalStockProducts->count() > 0)
        <x-expandable-area class="mt-6">
            <x-slot name="header">
                <span class="font-bold text-lg text-red-600">
                    <i class="triangle exclamation icon"></i>
                    {{ __('inventory.critical_stock_warning') }}
                </span>
                - <span class="text-sm text-ease">{{ $this->criticalStockProducts->count() }} {{ __('products.product') }}</span>
            </x-slot>
            <div class="p-2 rounded shadow-inner flex flex-col gap-3 bg-cool-gray-50">
                @foreach ($this->criticalStockProducts as $product)
                    <div class="p-2 rounded border bg-white shadow-sm">
                        <div>
                            <i class="box icon"></i>
                            <span class="font-bold">{{ $product->prd_code }}</span>
                            <span class="text-xs text-ease">{{ $product->prd_name }}</span>
                        </div>
                        <p class="text-sm">
                            {{ __('inventory.total')}} 
                            <span class="text-red-700 font-bold">{{ $product->totalStock['amount_string'] }},</span>
                            en az 
                            <u class="text-red-700 font-bold">{{ $product->prd_min_threshold }} {{ strtolower($product->totalStock['unit']->name) }}</u> 
                            olması gerekiyor
                        </p>
                    </div>
                @endforeach
            </div>
        </x-expandable-area>
    @endif



    <div class="mt-6 grid md:grid-cols-2 gap-2 shadow rounded bg-white p-2">
        <div class="shadow p-2 rounded-sm">
            
        </div>
        <div class="shadow p-2 rounded-sm">
            
        </div>
    </div>

    

</div>
