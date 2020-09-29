<?php

namespace App\Http\Controllers;

use App\Contracts\RecipeContract;
use App\Http\Controllers\Traits\DefaultController;

class RecipeController extends Controller
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
    public function __construct(RecipeContract $repository)
    {
        $this->repository = $repository;
        // $this->authorization = true;
        $this->validateData(['store', 'update']);
    }

}