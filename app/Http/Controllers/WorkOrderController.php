<?php

namespace App\Http\Controllers;

use App\Contracts\WorkOrderContract;
use App\Http\Controllers\Traits\DefaultController;
use App\Models\WorkOrder;

class WorkOrderController extends Controller
{
    use DefaultController;

    /**
    * Repository instance 
    */
    protected $repository;


    /**
     * Create controller instance
     * Authorization has been set true, so there should be a Policy class.
     * Validation logic has been set for only 'store' and 'update'. It can be changed or completely deleted as needed
     * There should be a static 'rules()' method that returns an array of validation rules within model class. 
     */
    public function __construct(WorkOrderContract $repository)
    {
        $this->repository = $repository;
        $this->authorization = true;
        $this->validateData(['store', 'update']);
    }

    public function index()
    {
        if(auth()->user()->cannot('view workorders')) abort(403);

        return view('web.sections.workorders.index');
    }

    public function show($id)
    {
        if(auth()->user()->cannot('view workorders')) abort(403);

        $workOrder = $this->repository->fetch($id);
        return view('web.sections.workorders.show.index', compact('workOrder'));
    }

    public function edit(WorkOrder $workOrder)
    {
        if(auth()->user()->cannot('create update workorders')) abort(403);
        if( ! ($workOrder->canBeUpdated())) abort(404);
        
        return view('web.sections.workorders.edit', compact('workOrder'));
    }

    public function create()
    {
        if(auth()->user()->cannot('create update workorders')) abort(403);
        
        return view('web.sections.workorders.create.index');
    }

    public function daily()
    {
        if(auth()->user()->cannot('process workorders')) abort(403);

        return view('web.sections.workorders.daily.index');
    }

    public function prepare($workOrder) // ?? inject yapınca bozuluyor livewire'da ne alakaysa
    {
        if(auth()->user()->cannot('process workorders')) abort(403);
        
        $workOrder = WorkOrder::findOrFail($workOrder);

        if( ! ($workOrder->isActive() || $workOrder->isPreparing() || $workOrder->isPrepared())) abort(404);

        return view('web.sections.workorders.daily.prepare.prepare', compact('workOrder'));
    }

}