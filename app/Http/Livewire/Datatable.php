<?php

namespace App\Http\Livewire;

use App\Common\Factories\ModelFactory;
use App\Models\Setting;
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
     * Paginate per page 
     */
    public $perPage;



    public function mount()
    {
        $this->modelPath = ModelFactory::make($this->modelName);
        $this->attributes = array_diff($this->modelPath::getColumnNames(), $this->except); // dinamik olursa rendera taşı
        $this->perPage = auth()->user()->getDatatablePerpage();
    }  
    

    public function render()
    {
        $this->setData();

        return view('livewire.datatable', [
            'data' => $this->data,
        ]);
    }


    private function setData()
    {
        $this->data = $this->searchQuery == null 
            ? $this->modelPath::paginate($this->perPage)
            : $this->modelPath::search($this->searchQuery)->paginate($this->perPage);
    }


    public function updatedPerPage($value)
    {
        // $this->resetPage();
        auth()->user()->setDatatablePerpage($value);
    }


    public function hydrate()
    {
        $this->resetPage();
    }
    




    
}
