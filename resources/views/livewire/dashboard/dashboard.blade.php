<div class="p-4">

    <div class="grid md:grid-cols-3 gap-5">
        <x-overview-card model="woFrq" number="{{ $this->woCountOverview() }}" text="üretim yapıldı..." icon="industry" bgColor="bg-red-500 hover:bg-red-700" textColor="text-red-500 hover:text-red-700" />
        <x-overview-card model="doFrq" number="{{ $this->doCountOverview() }}" text="sevkiyat yapıldı..." icon="fast shipping" bgColor="bg-blue-500 hover:bg-blue-700" textColor="text-blue-500 hover:text-blue-700" />
        <x-overview-card model="smFrq" number="{{ $this->smCountOverview() }}" text="stok girişi yapıldı..." icon="warehouse" bgColor="bg-green-500 hover:bg-green-700" textColor="text-green-500 hover:text-green-700" />
    </div>

    <div class="mt-10 grid md:grid-cols-2 gap-2 shadow rounded bg-white p-2">
        <div class="shadow p-2 rounded-sm">
            
        </div>
        <div class="shadow p-2 rounded-sm">
            
        </div>
    </div>

    

</div>
