<div class="flex flex-col gap-5">
    <div>
        <select wire:model="editableAddressId" class="form-select">
            <option selected >Adres seçiniz...</option>
            @foreach ($company->addresses as $address)
                <option value="{{ $address->id }}">
                    {{ $address->adr_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        @if ($editableAddress) 
            @if ($editMode)
                <div>

                </div>
            @else
                <div class="flex gap-10">
                    <div>
                        <div>{{ $editableAddress->adr_country }}</div>
                        <div>{{ $editableAddress->adr_province }}</div>
                        <div>{{ $editableAddress->adr_district }}</div>
                    </div>
                    <div>
                        <div>{{ $editableAddress->adr_body }}</div>
                        <div>{{ $editableAddress->adr_phone }}</div>
                        <div>{{ $editableAddress->adr_note }}</div>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>