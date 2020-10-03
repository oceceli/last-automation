<?php

namespace App\Http\Controllers;

use App\Contracts\WorkOrderContract;
use App\Http\Controllers\Traits\DefaultController;

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
        return view('web.sections.workorders.index');
    }

    public function show($id)
    {
        $workOrder = $this->repository->fetch($id);
        return view('web.sections.workorders.show', ['workOrder' => $workOrder]);
    }

}