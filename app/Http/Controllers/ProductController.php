<?php

namespace App\Http\Controllers;

use App\Contracts\ProductContract;
use App\Http\Controllers\Traits\DefaultController;
use App\Models\Product;

class ProductController extends Controller
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
    public function __construct(ProductContract $repository)
    {
        $this->repository = $repository;
        $this->authorization = true;
        $this->validateData(['store', 'update']);
    }

    public function index()
    {
        if(auth()->user()->cannot('view products')) abort(403);

        $products = $this->repository->all();
        return view('web.sections.products.index', compact('products'));
    }

    public function show($id)
    {
        if(auth()->user()->cannot('view products')) abort(403);

        $product = $this->repository->fetch($id);
        return view('web.sections.products.show.show', compact('product'));
    }

    public function create()
    {
        if(auth()->user()->cannot('create update products')) abort(403);
        
        return view('web.sections.products.create');
    }

    public function edit(Product $product)
    {
        if(auth()->user()->cannot('create update products')) abort(403);
        
        // $product = Product::find(Product $product);
        return view('web.sections.products.edit', compact('product'));
    }


}