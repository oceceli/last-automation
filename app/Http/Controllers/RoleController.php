<?php

namespace App\Http\Controllers;


class RoleController extends Controller
{
    public function index()
    {
        if(auth()->user()->cannot('manage users')) abort(403);

        return view('web.roles.index');
    }
}