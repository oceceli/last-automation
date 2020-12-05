<div {{ $attributes->merge(['class' => 'flex items-center relative'])}}>
    <div wire:loading.class="absolute pin z-20"></div>
    <div class="ui mini buttons w-full">
        <button class="ui basic button labeled icon" type="reset" wire:click.prevent="{{ $clear }}">
            <i class="undo alternate icon"></i>
            {{ __('common.clear') }}
        </button>
        <button class="ui right labeled icon positive button" @if($submit) wire:click.prevent="{{ $submit }} @endif"> {{-- wire:click.prevent="{{ $submit }}" --}}
            <i class="angle right icon"></i>
            {{ __('common.save') }}
        </button>
    </div>
</div>