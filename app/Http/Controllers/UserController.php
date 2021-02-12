<?php

namespace App\Http\Controllers;


class UserController extends Controller
{
    // public function index()
    // {
    //     return view('web.users.index');
    // }

    public function userRoles()
    {
        return view('web.users.user-roles');
    }
}
