<div class="flex flex-col gap-5">
    <div class="flex justify-between">
        <div>
            <i class="primary route icon"></i>
            <select wire:model="editableAddressId" class="bg-white focus:outline-none">
                <option selected>{{ __('addresses.saved_addresses') }}</option>
                @foreach ($selectedCompany->addresses as $address)
                    <option value="{{ $address->id }}">
                        {{ $address->adr_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            @if ($editableAddress)
                @if ($editMode)
                    <div wire:loading wire:target="saveEdited">
                        <i class="gray loading circle notch icon"></i>
                    </div>
                    <span data-tooltip="{{ __('common.cancel') }}" data-variation="mini">
                        <i wire:click.prevent="cancelEditing" class="red undo link icon cursor-pointer"></i>
                    </span>
                    <span data-tooltip="{{ __('common.save') }}" data-variation="mini">
                        <i wire:click.prevent="saveEdited" class="green checkmark link icon cursor-pointer"></i>
                    </span>
                @else
                    <span data-tooltip="{{ __('common.edit') }}" data-variation="mini">
                        <i wire:click.prevent="enableEditMode" class="primary pen alternate link icon cursor-pointer"></i>
                    </span>
                @endif
            @endif
        </div>
    </div>



    
    @if ($editableAddress) 
        <div>
            @if ($editMode)
                <div>
                    <x-list-item>
                        <label>{{ __('validation.attributes.adr_country') }}</label>
                        <input type="text" wire:model.defer="adr_country" class="input-borderless text-right w-36 text-orange-700">
                    </x-list-item>
                    <x-list-item>
                        <label>{{ __('validation.attributes.adr_province') }}</label>
                        <input type="text" wire:model.defer="adr_province" class="input-borderless text-right w-36 text-orange-700">
                    </x-list-item>
                    <x-list-item>
                        <label>{{ __('validation.attributes.adr_district') }}</label>
                        <input type="text" wire:model.defer="adr_district" class="input-borderless text-right w-36 text-orange-700">
                    </x-list-item>
                    <x-list-item>
                        <label>{{ __('validation.attributes.adr_phone') }}</label>
                        <input type="text" wire:model.defer="adr_phone" class="input-borderless text-right w-36 text-orange-700">
                    </x-list-item>
                    
                    <x-list-item class="flex-col">
                        <label>{{ __('validation.attributes.adr_body') }}</label>
                        <textarea placeholder="{{ __('validation.attributes.adr_note')}}" rows="3" wire:model.defer="adr_body" class="input-borderless py-2 text-orange-700"></textarea>
                    </x-list-item>
                    <x-list-item class="flex-col">
                        <label>{{ __('validation.attributes.adr_note') }}</label>
                        <textarea placeholder="{{ __('validation.attributes.adr_note')}}" rows="3" wire:model.defer="adr_note" class="input-borderless py-2 text-orange-700"></textarea>
                    </x-list-item>
                        
                    <x-error-area class="pt-5" />
                </div>
            @else
                <div>
                    <x-list-item>
                        <label>{{ __('validation.attributes.adr_country') }}</label>
                        <span>{{ $editableAddress->adr_country }}</span>
                    </x-list-item>
                    <x-list-item>
                        <label>{{ __('validation.attributes.adr_province') }}</label>
                        <span>{{ $editableAddress->adr_province }}</span>
                    </x-list-item>
                    <x-list-item>
                        <label>{{ __('validation.attributes.adr_district') }}</label>
                        <span>{{ $editableAddress->adr_district }}</span>
                    </x-list-item>
                    <x-list-item>
                        <label>{{ __('validation.attributes.adr_phone') }}</label>
                        <span>{{ $editableAddress->adr_phone}}</span>
                    </x-list-item>
                    
                    <x-list-item class="flex-col">
                        <label>{{ __('validation.attributes.adr_body') }}</label>
                        <i>{{ $editableAddress->adr_body}}</i>
                    </x-list-item>
                    <x-list-item class="flex-col">
                        <label>{{ __('validation.attributes.adr_note') }}</label>
                        <i>{{ $editableAddress->adr_note }}</i>
                    </x-list-item>
                </div>
            @endif
        </div>
    @endif
</div>