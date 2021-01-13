@if ($company->cmp_supplier && $company->cmp_customer)
    <x-span tooltip="{{ __('companies.either_supplier_and_customer') }}" position="top left">
        <i class="purple exchange icon"></i>
    </x-span>
@elseif($company->cmp_supplier)
    <x-span tooltip="{{ __('validation.attributes.cmp_supplier') }}" position="top left">
        <i class="blue arrow right icon"></i>
    </x-span>
@elseif($company->cmp_customer)
    <x-span tooltip="{{ __('validation.attributes.cmp_customer') }}" position="top left">
        <i class="green arrow left icon"></i>
    </x-span>
@else
    <x-span tooltip="{{ __('companies.company_type_not_specified') }}" position="top left">
        {{-- <i class="circle icon"></i> --}}
        <i class="question mark icon"></i>
    </x-span>
@endif