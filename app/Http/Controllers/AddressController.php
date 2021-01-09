<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        return view('web.sections.addresses.index');
    }
    public function create()
    {
        return view('web.sections.addresses.create');
    }
}
