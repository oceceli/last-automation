<?php

namespace App\Observers;

use App\Models\Company;

class CompanyObserver
{
    public function deleting(Company $company)
    {
        if($company->dispatchorders()->exists()) return false;
    }

    public function deleted(Company $company)
    {
        $company->addresses()->delete();
    }

}
