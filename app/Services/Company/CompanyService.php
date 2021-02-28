<?php

namespace App\Services\Company;

use App\Models\Company;

class CompanyService
{
    public static function getCustomers($only = [])
    {
        if($only) 
            return Company::where('cmp_customer', true)->select($only)->get();
        return Company::where('cmp_customer', true)->get();
    }
}