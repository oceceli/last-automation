<?php

namespace App\Http\Controllers;

use App\Models\DispatchOrder;

class DispatchOrderController extends Controller
{
    public function index()
    {
        return view('web.sections.dispatchorders.index');
    }

    public function create()
    {
        return view('web.sections.dispatchorders.create');
    }

    public function edit(DispatchOrder $dispatchOrder)
    {
        return view('web.sections.dispatchorders.edit', compact('dispatchOrder'));
    }
}
