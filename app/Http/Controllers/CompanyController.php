<?php

namespace App\Http\Controllers;

use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        if(auth()->user()->cannot('view companies')) abort(403);

        return view('web.sections.companies.index.index');
    }

    public function create()
    {
        if(auth()->user()->cannot('create update companies')) abort(403);

        return view('web.sections.companies.create');
    }

    public function edit(Company $company)
    {
        if(auth()->user()->cannot('create update companies')) abort(403);

        return view('web.sections.companies.edit', compact('company'));
    }
    
}
