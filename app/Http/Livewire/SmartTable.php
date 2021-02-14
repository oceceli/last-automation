<?php

namespace App\Http\Livewire;

use Livewire\WithPagination;

trait SmartTable
{
    use WithPagination;
    use Deletable;


    /** 
     * Paginate per page 
     */
    public $perPage;

    /**
     * Searching string
     */
    public $searchQuery = '';


    public $orderByColumn = '';
    public $direction = 'asc';

    
    public function mount()
    {
        $this->perPage = auth()->user()->getDatatablePerpage();
    }



    public function render()
    {
        // Searched or unsearched Illuminate\Database\Eloquent\Builder
        $query = $this->searchQuery
            ? $this->model::search($this->searchQuery, isset($this->alsoSearch) ? $this->alsoSearch : [])
            : $this->model::query();
        
        $data = $query->orderBy($this->orderByColumn, $this->direction)
                      ->paginate($this->perPage);

        return view($this->view, ['data' => $data]);
    }



    public function updatedSearchQuery()
    {
        $this->setPage(1);
    }


    /**
     * save user's default perpage preference 
     */
    public function updatedPerPage()
    {
        $this->setPage(1);
        $this->chastenPerpage();
        auth()->user()->setDatatablePerpage($this->perPage);
    }

    /**
     * perPage property should not be 0 or less
     */
    public function chastenPerpage()
    {
        if($this->perPage < 1) {
            $this->perPage = auth()->user()->getDatatablePerpage();
        }
    }

    public function sortBy($column)
    {
        // todo: column model columnları içerisinde var mı
        if($this->orderByColumn == $column) {
            $this->direction = $this->direction === 'asc' ? 'desc' : 'asc';
        } else {
            $this->orderByColumn = $column;
            $this->direction = 'asc';
        }
    }

    /**
     * Direction class will provide a visual statement for direction icon
     */
    public function getDirectionClass($column)
    {
        if($this->orderByColumn === $column && $this->direction === 'asc') {
            return 'small green sort up';
        } elseif($this->orderByColumn === $column && $this->direction === 'desc') {
            return 'small red sort down';
        } else {
            return 'small orange sort';
        }
    }

}
