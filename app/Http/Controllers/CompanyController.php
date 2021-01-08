<?php

namespace App\Http\Controllers;


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

    // ** show edit yapılmadı henüz
}
