<div>
    <x-content>
        <x-slot name="header">
            <x-page-header icon="briefcase" header="!! firma kaydet">

            </x-page-header>

        </x-slot>
        <form wire:submit.prevent="submit" class="ui tiny form">
            <x-form-divider>


                <x-slot name="left">
                    <x-input model="cmp_name" label="validation.attributes.cmp_name" placeholder="validation.attributes.cmp_name"  />
                    <x-input model="cmp_current_code" label="validation.attributes.cmp_current_code" placeholder="validation.attributes.cmp_current_code"  />
                    <x-input model="cmp_commercial_title" label="validation.attributes.cmp_commercial_title" placeholder="validation.attributes.cmp_commercial_title"  />
                </x-slot>


                <x-slot name="right">
                    <x-input model="cmp_tax_number" label="validation.attributes.cmp_tax_number" placeholder="validation.attributes.cmp_tax_number"  />
                    <x-input model="cmp_phone" label="validation.attributes.cmp_phone" placeholder="validation.attributes.cmp_phone"  />

                    <div x-data="{addNote: false}" class="pt-2">
                        <div x-show="!addNote">
                            <i class="write icon"></i>
                            <span class="cursor-pointer pt-1 text-gray-400 text-sm font-bold ease-in-out duration-200 hover:text-gray-600" @click="addNote = true">{{ __('common.add_explanation') }}</span>
                        </div>
                        <div x-show="addNote" class="field">
                            <label><i class="write icon"></i>{{ __('validation.attributes.cmp_note' )}}</label>
                            <textarea wire:model.lazy="cmp_note" rows="3"></textarea>
                        </div>
                    </div>
                </x-slot>

                
            </x-form-divider>
        </form>
    </x-content>
</div>
