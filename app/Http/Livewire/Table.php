<?php

namespace App\Http\Livewire;

use App\Common\Factories\ModelFactory;
use Livewire\WithPagination;

trait Table
{
    


    // use WithPagination;

    // /**
    //  * Prop property for $this livewire component
    //  */
    // public $modelName;

    // /**
    //  * Points the model path
    //  */
    // public $model;

    // /**
    //  * Table attributes
    //  */
    // public $attributes;
    
    // /**
    //  * These columns should not be shown in the table
    //  */
    // public $except = [
    //     'created_at', 'updated_at', 'deleted_at', // id
    // ];

    // /**
    //  * Searching string
    //  */
    // public $searchQuery = '';

    // /**
    //  * The data which will be shown to a user
    //  */
    // protected $data = [];
   
    // /** 
    //  * Paginate per page 
    //  */
    // public $perPage;



    // protected $view = 'livewire.datatable'; // default



    // public function mount()
    // {
    //     if($this->modelName)
    //         $this->model = ModelFactory::make($this->modelName);
    //     if( ! $this->attributes)
    //         $this->attributes = array_diff($this->model::getColumnNames(), $this->except); 
    //     $this->perPage = auth()->user()->getDatatablePerpage();
    // }  
    

    // public function render()
    // {
    //     $this->setData();

    //     return view($this->view, [
    //         'data' => $this->data,
    //     ]);
    // }


    // protected function setData()
    // {
    //     $this->data = $this->searchQuery == null 
    //         ? $this->model::paginate($this->perPage)
    //         : $this->model::search($this->searchQuery)->paginate($this->perPage);
    // }

    // public function updatedSearchQuery()
    // {
    //     $this->resetPage();
    // }

    // public function updatedPerPage($value)
    // {
    //     $value = abs($value);
    //     $this->resetPage();
    //     $this->perPage = $value;

    //     auth()->user()->setDatatablePerpage($value);
    // }    


    // public function delete($id)
    // {
    //     if($this->model::find($id)->delete()) {
    //         $this->emit('toast', 'crud.deleted', 'crud.content_deleted_smoothly', 'info');
    //     } else {
    //         $this->emit('toast', 'crud.unable_to_delete', 'crud.something_happened_while_deleting_the_content', 'error');
    //     }
    // }
}
