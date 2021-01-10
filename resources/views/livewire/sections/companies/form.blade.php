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
                    <x-input model="cmp_commercial_title" label="validation.attributes.cmp_commercial_title" placeholder="validation.attributes.cmp_commercial_title"  />
                    <x-input model="cmp_current_code" label="validation.attributes.cmp_current_code" placeholder="validation.attributes.cmp_current_code"  />
                </x-slot>


                <x-slot name="right">
                    <x-input model="cmp_tax_number" label="validation.attributes.cmp_tax_number" placeholder="validation.attributes.cmp_tax_number"  />
                    <x-input model="cmp_phone" label="validation.attributes.cmp_phone" placeholder="validation.attributes.cmp_phone"  />

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
                    {{-- <div x-data="{addAddress: false}" class="pt-1">
                        <div x-show="!addAddress">
                            <button @click="addAddress = true" wire:click.prevent class="ui mini button">
                                {{ __('addresses.add_address') }}
                            </button>
                        </div>
                        <div x-show="addAddress">
                            <livewire:sections.addresses.form>
                        </div>
                    </div> --}}

                </x-slot>

                
            </x-form-divider>
        </form>
    </x-content>
</div>
