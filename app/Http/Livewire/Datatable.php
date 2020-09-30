<?php

namespace App\Http\Livewire;

use App\Common\Factories\ModelFactory;
use Livewire\Component;
use Livewire\WithPagination;

class Datatable extends Component
{

    use WithPagination;

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
        'created_at', 'updated_at', 'deleted_at', 'id',
    ];

    /**
     * Searching string
     */
    public $searchQuery = '';

    /**
     * The data which will be shown to a user
     */
    private $data;
   

    /** 
     * ****************************************
     * These properties for pagination purposes
     * ****************************************
     */
    public $perPage = 7;

    public $total;
    
    public $firstItem;
    
    public $count;
    
    public $lastPage;


    // Pagination **************************


    public function mount()
    {
        $this->modelPath = ModelFactory::make($this->modelName);
        $this->attributes = array_diff($this->modelPath::getColumnNames(), $this->except); // dinamik olursa rendera taşı
    }  
    

    public function render()
    {
        $this->resetPage();
        $this->queryResults();
        $this->setPagination();
        // dd($this->data->setCollection(collect('test')));
        return view('livewire.datatable', [
            'data' => $this->data,
        ]);
    }


    private function queryResults()
    {
        $this->data = $this->searchQuery == null 
            ? $this->modelPath::paginate($this->perPage)
            : $this->modelPath::search($this->searchQuery)->paginate($this->perPage);
    }

    private function setPagination()
    {
        $this->total = $this->data->total();
        $this->count = $this->data->count();
        $this->firstItem = $this->data->firstItem();
        $this->lastPage = $this->data->lastPage();
    }


    // public function updatedSearchQuery($value) 
    // {
    //     dd($value);
    // }

    




    
}
