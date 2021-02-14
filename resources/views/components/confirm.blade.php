<x-custom-modal position="center" active="{{ $active }}" atClose="{{ $atClose }}">
    <div class="flex flex-col bg-cool-gray-50">
        <div>
            <div class="p-4 shadow-md text-xl text-center">
                {{ $slot }}
            </div>
        </div>
        <div class="p-5 ui mini buttons border-t border-{{ $color }}-300">
            {{-- <button wire:click.prevent="{{ $atDeny }}" class="ui basic button">{{ $deny }}</button> --}}
            <button @click="{{ $active }} = false" class="ui basic button">{{ $deny }}</button>
            <button wire:click.prevent="{{ $atConfirm }}" class="ui {{ $color }} button">{{ $confirm }}</button>
        </div>
    </div>
    
</x-custom-modal>