<div>
    <x-content>
        <x-slot name="header">
            @if ($editMode)
                <x-page-header icon="briefcase" header="{{ __('companies.edit_company') }}" />
            @else
                <x-page-header icon="briefcase" header="{{ __('companies.create_company') }}" />
            @endif

        </x-slot>
        <form wire:submit.prevent="submit" class="ui tiny form">
            <x-form-divider>


                <x-slot name="left">
                    <x-input defer model="cmp_name" label="validation.attributes.cmp_name" placeholder="validation.attributes.cmp_name"  />
                    <x-input defer model="cmp_commercial_title" label="validation.attributes.cmp_commercial_title" placeholder="validation.attributes.cmp_commercial_title"  />
                    <x-input defer model="cmp_current_code" label="validation.attributes.cmp_current_code" placeholder="validation.attributes.cmp_current_code"  />
                </x-slot>


                <x-slot name="right">
                    <x-input defer model="cmp_tax_number" label="validation.attributes.cmp_tax_number" placeholder="validation.attributes.cmp_tax_number"  />
                    <x-input defer model="cmp_phone" label="validation.attributes.cmp_phone" placeholder="validation.attributes.cmp_phone"  />
                    <div class="pt-1">
                        <div class="px-2 py-1 border border-dashed">
                            <span class="text-ease text-xs">{{ __('companies.a_company_can_be_either_a_supplier_and_a_customer') }}.</span>
                            <div class="py-1 flex gap-10">
                                <x-checkbox model="cmp_supplier" label="{{ __('validation.attributes.cmp_supplier') }}" />
                                <x-checkbox model="cmp_customer" label="{{ __('validation.attributes.cmp_customer') }}" />
                            </div>
                        </div>
                    </div>
                </x-slot>
                
                <x-slot name="bottom">
                    <div x-data="{addExplanation: false}">
                        <div x-show="!addExplanation">
                            <i class="write icon"></i>
                            <span class="cursor-pointer pt-1 text-gray-400 text-sm font-bold ease-in-out duration-200 hover:text-gray-600" @click="addExplanation = true">{{ __('common.add_explanation') }}</span>
                        </div>
                        <div x-show="addExplanation" class="field">
                            <label><i class="write icon"></i>{{ __('validation.attributes.cmp_note' )}}</label>
                            <textarea wire:model.lazy="cmp_note" rows="3"></textarea>
                        </div>
                    </div>
                </x-slot>

                
            </x-form-divider>
        </form>
    </x-content>
</div>
