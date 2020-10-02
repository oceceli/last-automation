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
     * Table attributes
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
    protected $data;
   
    /** 
     * Paginate per page 
     */
    public $perPage;



    protected $view = 'livewire.datatable'; // dikkat



    public function mount()
    {
        $this->modelPath = ModelFactory::make($this->modelName);
        if( ! $this->attributes)
            $this->attributes = array_diff($this->modelPath::getColumnNames(), $this->except); 
        $this->perPage = auth()->user()->getDatatablePerpage();
    }  
    

    public function render()
    {
        $this->setData();

        return view($this->view, [
            'data' => $this->data,
        ]);
    }
    
    
    // public function render()
    // {
    //     $this->setData();

    //     return view('livewire.datatable', [
    //         'data' => $this->data,
    //     ]);
    // }


    protected function setData()
    {
        $this->data = $this->searchQuery == null 
            ? $this->modelPath::paginate($this->perPage)
            : $this->modelPath::search($this->searchQuery)->paginate($this->perPage);
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }

    public function updatedPerPage($value)
    {
        $value = abs($value);
        $this->resetPage();
        $this->perPage = $value;

        auth()->user()->setDatatablePerpage($value);
    }    
}
