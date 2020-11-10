<div class="flex items-center">
    {{-- <div class="ui mini buttons w-full xl:w-3/12 pt-5"> --}}
        <div class="ui mini buttons w-full pt-5">
            <button class="ui basic button labeled icon" type="reset" wire:click="{{ $clear }}">
                <i class="undo alternate icon"></i>
                Temizle
            </button>
            <button class="ui right labeled icon positive button" wire:loading.class="disabled loading" wire:click.prevent="{{ $submit }}">
                <i class="angle right icon"></i>
                Kaydet
            </button>
        </div>
    {{-- </div> --}}
</div>