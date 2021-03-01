<?php

namespace App\Http\Controllers;

use App\Models\DispatchOrder;

class DispatchOrderController extends Controller
{
    public function index()
    {
        if(auth()->user()->cannot('view dispatchorders')) abort(403);

        return view('web.sections.dispatchorders.index.index');
    }

    public function create()
    {
        if(auth()->user()->cannot('create update dispatchorders')) abort(403);

        return view('web.sections.dispatchorders.create.create');
    }

    public function edit($dispatchOrder)
    {
        if(auth()->user()->cannot('create update dispatchorders')) abort(403);
        
        $dispatchOrder = DispatchOrder::findOrFail($dispatchOrder);

        if( ! ($dispatchOrder->isSuspended() || $dispatchOrder->isActive())) abort(404);


        // $dispatchOrder = DispatchOrder::findOrFail($dispatchOrder);
        return view('web.sections.dispatchorders.edit', compact('dispatchOrder'));
    }

    public function daily()
    {
        if(auth()->user()->cannot('process dispatchorders')) abort(403);

        return view('web.sections.dispatchorders.daily.index');
    }

    public function prepare(DispatchOrder $dispatchOrder)
    {
        if(auth()->user()->cannot('process dispatchorders')) abort(403);

        return view('web.sections.dispatchorders.daily.prepare.prepare', compact('dispatchOrder'));
    }
}
