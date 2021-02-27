<?php

namespace App\Http\Livewire\WorkOrders;

use App\Http\Livewire\SmartTable;
use App\Http\Livewire\Traits\WorkOrders\DetailsModal;
use App\Models\Product;
use App\Models\WorkOrder;
use Livewire\Component;

class Datatable extends Component
{
    use SmartTable;
    use DetailsModal;
     
    public $model = WorkOrder::class;
    protected $view = 'livewire.work-orders.datatable';

    protected $alsoSearch = [
        'product.prd_name',
    ];

    // public $product;
    public $productId;



    public function getProductsProperty()
    {
        return Product::getProducibleOnes();
    }

    
    private function advancedFilters()
    {
        return [ // and
            [
                ['product_id' => $this->productId], // or
            ],
            // [
            //     ['']
            // ]
        ];
    }



    public function mount($product = null)
    {
        $this->stInit();
        if($product) {
            // $this->product = $product;
            $this->productId = $product->id;
        }
    }




}
