<x-custom-modal theme="orange" position="center" active="{{ $active }}">
    <div class="p-5 flex flex-col gap-5">
        <div class="text-xl text-ease text-center">
            {{ $question }}
        </div>
        <div class="ui tiny buttons">
            <button wire:click.prevent="{{ $atDeny }}" class="ui basic button">Hayır</button>
            <button wire:click.prevent="{{ $atConfirm }}" class="ui primary button">Kaydet</button>
        </div>
    </div>
    
</x-custom-modal>