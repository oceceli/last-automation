<x-custom-modal theme="orange" position="center" active="{{ $active }}">
    <div class="flex flex-col bg-cool-gray-50">
        <div>
            <div class="py-8 rounded shadow-md bg-white text-xl text-ease text-center">
                {{ $question }}
            </div>
        </div>
        <div class="p-5 ui tiny buttons border-t border-{{ $color }}-200">
            <button wire:click.prevent="{{ $atDeny }}" class="ui basic button">{{ $deny }}</button>
            <button wire:click.prevent="{{ $atConfirm }}" class="ui {{ $color }} button">{{ $confirm }}</button>
        </div>
    </div>
    
</x-custom-modal>