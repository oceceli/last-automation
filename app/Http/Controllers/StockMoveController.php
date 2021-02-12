<?php

namespace App\Http\Controllers;

use App\Contracts\StockMoveContract;
use App\Http\Controllers\Traits\DefaultController;
use App\Models\StockMove;

class StockMoveController extends Controller
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
    public function __construct(StockMoveContract $repository)
    {
        $this->repository = $repository;
        $this->authorization = true;
        $this->validateData(['store', 'update']);
    }

    public function index()
    {
        if(auth()->user()->cannot('view stockmoves')) abort(403);

        return view('web.sections.stockmoves.index');
    }

    public function show($id)
    {
        if(auth()->user()->cannot('view stockmoves')) abort(403);

        $stockMove = StockMove::find($id);
        return view('web.sections.stockmoves.show', compact('stockMove'));
    }

    public function create()
    {
        if(auth()->user()->cannot('create update stockmoves')) abort(403);

        return view('web.sections.stockmoves.create');
    }

    public function edit(StockMove $stockMove)
    {
        if(auth()->user()->cannot('create update stockmoves')) abort(403);

        return view('web.sections.stockmoves.edit', compact('stockMove'));
    }

}