<?php

namespace App\Http\Livewire;

use App\Common\Factories\ModelFactory;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class Datatable extends Component
{

    /**
     * Prop property for $this livewire component
     */
    public $modelName;

    /**
     * Points the model path
     */
    public $modelPath;

    /**
     * Table thead attributes
     */
    public $attributes;
    
    /**
     * These columns should not be shown in the table
     */
    public $except = [
        'created_at', 'updated_at', 'deleted_at', 'id',  // note kaldır
    ];

    /**
     * Searching string
     */
    public $searchQuery = '';

    /**
     * Pagination
     */
    public $paginate;

    /**
     * 
     */
    public $perPage = 10;



    public function mount()
    {
        $this->modelPath = ModelFactory::make($this->modelName);
        $this->attributes = array_diff($this->modelPath::getColumnNames(), $this->except);
    }


    public function queryResults()
    {
        if($this->searchQuery == null)
            return $this->modelPath::paginate($this->perPage);
        return $this->modelPath::search($this->searchQuery);
    }

    
    

    public function render()
    {
        return view('livewire.datatable', [
            'data' => $this->queryResults(),
        ]);
    }




    




    
}
