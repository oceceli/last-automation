<div class="p-4 flex flex-col gap-5 bg-white rounded-md">
    <div class="ui small form">
        <x-input model="ctg_name" label="{{ __('validation.attributes.ctg_name') }}" noErrors
            placeholder="{{ __('validation.attributes.ctg_name') }}" class="required field" />
        <div class="pt-5">
            <button class="ui green mini button" wire:click.prevent="ctgSubmit">
                {{ __('common.save') }}
            </button>
        </div>
    </div>
</div>