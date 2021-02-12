<?php

namespace App\Http\Controllers;

class InventoryController extends Controller
{
    public function index()
    {
        if(auth()->user()->cannot('view stockmoves')) abort(403);

        return view('web.sections.inventory.index');
    }
}
