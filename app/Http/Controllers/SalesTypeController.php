<?php

namespace App\Http\Controllers;


class SalesTypeController extends Controller
{
    public function create()
    {
        return view('web.sections.salestype.create');
    }
}
