<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CompaniesExport extends BaseExport implements FromQuery, WithMapping, WithHeadings
{

    protected $fileName = 'Firmalar';


    public function __construct(Builder $query)
    {
        $this->injectedQuery = $query;
    }

    protected function title() : string
    {
        return 'Kayıtlı Firmalar - Çıktı tarihi: ' . now()->format('d.m.Y');
    }



    public function headings() : array
    {
        return [
            __('common.type'), ' ',
            __('validation.attributes.cmp_name'), ' ',
            __('validation.attributes.cmp_commercial_title'), ' ',
            __('validation.attributes.cmp_current_code'), ' ',
            __('validation.attributes.cmp_tax_number'), ' ',
            __('validation.attributes.cmp_phone'), ' ',
            __('validation.attributes.cmp_note'), ' ',
            // __('addresses.addresses'), ' ',
        ];
    }
    

    public function map($company) : array
    {
        
        return [
            $company->companyType(), ' ',
            $company->cmp_name, ' ',
            $company->cmp_commercial_title, ' ',
            $company->cmp_current_code, ' ',
            $company->cmp_tax_number, ' ',
            $company->cmp_phone, ' ',
            $company->cmp_note, ' ',
            // $company->addresses, ' ',
        ];
    }



    public function query()
    {
        return $this->injectedQuery;
    }
}
