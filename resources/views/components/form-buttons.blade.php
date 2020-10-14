<div class="mt-8 flex justify-between items-center">
    <div></div>
    <div class="ui buttons w-full xl:w-3/12">
        <button class="ui basic button labeled icon" type="reset" wire:click="clearFields">
            <i class="undo alternate icon"></i>
            Temizle
        </button>
        <button class="ui right labeled icon positive button" wire:loading.class="disabled loading" wire:target="submit">
            <i class="angle right icon"></i>
            Kaydet
        </button>
    </div>
</div>