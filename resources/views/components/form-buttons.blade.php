<div {{ $attributes->merge(['class' => 'flex items-center'])}}>
    <div class="ui mini buttons w-full ">
        <button class="ui basic button labeled icon" type="reset" wire:click="{{ $clear }}">
            <i class="undo alternate icon"></i>
            Temizle
        </button>
        <button class="ui right labeled icon positive button" wire:loading.class="disabled" @if($submit) wire:click.prevent="{{ $submit }} @endif"> {{-- wire:click.prevent="{{ $submit }}" --}}
            <i class="angle right icon"></i>
            Kaydet
        </button>
    </div>
</div>