<?php

namespace App\Http\Controllers;


class UserController extends Controller
{


    // public function index()
    // {
    //     return view('web.users.index');
    // }

    public function index()
    {
        if(auth()->user()->cannot('manage users')) abort(403);

        return view('web.users.index');
    }
}
