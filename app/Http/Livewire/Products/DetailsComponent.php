<?php

namespace App\Http\Livewire\Products;

use Livewire\Component;

class DetailsComponent extends Component
{
    public $product;

    public $currentTab = 'definition';

    protected $queryString = ['currentTab'];


    public function __construct($product, $tab = null)
    {
        $this->product = $product;
        if($tab) $this->currentTab = $tab;
    }

    private function setTab($tab)
    {
        $this->currentTab = $tab;
    }



    public function tabDefinition()
    {
        $this->setTab('definition');
    }
    
    public function tabStocks()
    {
        $this->setTab('stocks');
    }
    
    public function tabProduction()
    {
        $this->setTab('production');
    }

    public function tabDispatch()
    {
        $this->setTab('dispatch');
    }

    
    public function render()
    {
        return view('livewire.products.details-component');
    }
}
