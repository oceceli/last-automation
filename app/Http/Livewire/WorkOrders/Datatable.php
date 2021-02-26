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
        'product.name',
    ];

    // public $product;
    public $productId;



    public function getProductsProperty()
    {
        return Product::getProducibleOnes();
    }

    private function advancedFilter()
    {
        return $this->model::where('product_id', 1);
    }



    public function mount($product = null)
    {
        if($product) {
            // $this->product = $product;
            $this->productId = $product->id;
        }
    }




}
