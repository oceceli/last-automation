<?php

namespace App\Http\Livewire;

use App\Services\DatetimeService;
use App\Services\SearchService;
use Livewire\WithPagination;

trait SmartTable
{
    use WithPagination;
    use Deletable;


    public $showFilters;

    // date filters
    public $showDateFilters = false;
    public $filterFromDate;
    public $filterToDate;

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
        $this->stInit();
    }


    public function stInit()
    {
        $this->perPage = auth()->user()->getDatatablePerpage();
        if(isset($this->orderByDefault)) {
            $this->orderByColumn = $this->orderByDefault['column'];
            $this->direction = $this->orderByDefault['direction'];
        }
    }


    public function updatedShowFilters($value)
    {
        // when show filters closed
        if($value == false && method_exists($this, 'resetFilters')) {
            $this->resetFilters();
            $this->reset('orderByColumn', 'direction', 'showFilters');
        }
    }




    public function updatedShowDateFilters($value)
    {
        if($value == false) $this->reset('filterFromDate', 'filterToDate');
    }
    



    public function render()
    {
        $data = $this->filteredQuery()->paginate($this->perPage);
        return view($this->view, ['data' => $data]);
    }



    private function filteredQuery()
    {
        $query = $this->model::query();

        if($this->filterFromDate) {
            DatetimeService::createdBetween($query, $this->filterFromDate, $this->filterToDate);
        }

        if($this->showFilters && method_exists($this, 'advancedFilters')) {
            foreach($this->advancedFilters() as $pair) {
                if(reset($pair)) // if first of array is not null
                    $query->where($pair);
            }
        }
        
        if($this->searchQuery) {
            $searchFields = array_merge($this->model::columnsToBeSearched(), isset($this->alsoSearch) ? $this->alsoSearch : []);
            SearchService::search($query, $this->searchQuery, $searchFields);
        }

        // return $query->orderBy($this->orderByColumn, $this->direction);
        
        return $this->orderByColumn
            ? $query->orderBy($this->orderByColumn, $this->direction)
            : $query;

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
