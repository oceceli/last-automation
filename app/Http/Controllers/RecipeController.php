<?php

namespace App\Http\Controllers;

use App\Contracts\RecipeContract;
use App\Http\Controllers\Traits\DefaultController;
use App\Models\Recipe;

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
    
    public function create()
    {
        if(auth()->user()->cannot('create update recipes')) abort(403);

        return view('web.sections.recipes.create.create');
    }

    public function index()
    {
        if(auth()->user()->cannot('view recipes')) abort(403);

        return view('web.sections.recipes.index');
    }

    public function show($id)
    {
        if(auth()->user()->cannot('view recipes')) abort(403);
        
        $recipe = Recipe::find($id);
        return view('web.sections.recipes.show', compact('recipe'));
    }

    public function edit(Recipe $recipe)
    {
        if(auth()->user()->cannot('create update recipes')) abort(403);
        
        // $recipe = Recipe::find(Recipe $recipe);
        return view('web.sections.recipes.edit', compact('recipe'));
    }
}