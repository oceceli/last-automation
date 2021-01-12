<?php

namespace App\Http\Controllers;

use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        return view('web.sections.companies.index');
    }

    public function create()
    {
        return view('web.sections.companies.create');
    }

    public function edit(Company $company)
    {
        return view('web.sections.companies.edit', compact('company'));
    }

    // ** show edit yapılmadı henüz
}
