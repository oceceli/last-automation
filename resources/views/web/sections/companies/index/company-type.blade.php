<x-span tooltip="{{ $company->companyType() }}" position="top left">
    @if ($company->cmp_supplier && $company->cmp_customer)
        <i class="purple exchange icon"></i>
    @elseif($company->cmp_supplier)
        <i class="blue arrow right icon"></i>
    @elseif($company->cmp_customer)
        <i class="green arrow left icon"></i>
    @else
        <i class="question mark icon"></i>
    @endif
</x-span>
