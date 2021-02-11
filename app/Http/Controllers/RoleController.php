<?php

namespace App\Http\Controllers;


class RoleController extends Controller
{
    public function index()
    {
        return view('web.roles.index');
    }
}