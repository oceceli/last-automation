<?php

namespace App\Http\Livewire\Products;

use App\Contracts\ExportsContract;
use App\Http\Livewire\SmartTable;
use App\Http\Livewire\Traits\Exportable;
use App\Models\Product;
use Livewire\Component;

class Datatable extends Component implements ExportsContract
{
    use SmartTable;
    use Exportable;

    public $detailsModal = false;
    public $selectedProduct;

    protected $alsoSearch = [
        'category.ctg_name', 'category.id',
    ];

    protected $orderByDefault = [
        'column' => 'prd_barcode',
        'direction' => 'desc',
    ];

    public $model = Product::class;
    protected $view = 'livewire.products.datatable';


    public function openDetailsModal($productId)
    {
        $this->detailsModal = true;
        $this->selectedProduct = Product::find($productId);
    }






    public function statusIcon($product)
    {
        return $product->prd_is_active
            ? ['class' => 'green circle icon', 'explanation' => __('common.active')]
            : ['class' => 'red circle icon', 'explanation' => __('common.inactive')];
    }

}
