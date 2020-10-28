<div class="p-2 flex flex-col gap-5 bg-white rounded-md">
    <x-input model="name" label="sections/categories.category_name" 
        placeholder="sections/categories.category_name" class="required field" />
    <div wire:click="submit" class="ui mini positive button">
        Kaydet
    </div>
</div>
