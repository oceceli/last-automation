<?php

namespace App\Http\Controllers;


class SalesTypeController extends Controller
{
    public function create()
    {
        if(auth()->user()->cannot('create update dispatchorders')) abort(403);
        
        return view('web.sections.salestype.create');
    }
}
