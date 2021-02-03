<x-app-layout>
    <div class="p-4">

        <div class="grid md:grid-cols-3 gap-5">
            <x-overview-card color="red" icon="box">
                slot
            </x-overview-card>
            <x-overview-card>
                slot
            </x-overview-card>
            <x-overview-card>
                slot
            </x-overview-card>
        </div>
    
        <div class="mt-10 grid md:grid-cols-2 gap-2 shadow rounded bg-white p-2">
            <div class="shadow p-2 rounded-sm">
                
            </div>
            <div class="shadow p-2 rounded-sm">
                
            </div>
        </div>


    </div>
</x-app-layout>
