<div class="ui mini buttons w-full">
    <button class="ui basic button labeled icon" type="reset" wire:click="clearFields">
        <i class="undo alternate icon"></i>
        Temizle
    </button>
    <button class="ui right labeled icon positive button" wire:loading.class="disabled loading" wire:click.prevent="submit">
        <i class="angle right icon"></i>
        Kaydet
    </button>
</div>