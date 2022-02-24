<?php

namespace App\Http\Livewire\WorkOrders;

use App\Contracts\ExportsContract;
use App\Http\Livewire\SmartTable;
use App\Http\Livewire\Traits\Exportable;
use App\Http\Livewire\Traits\WorkOrders\DetailsModal;
use App\Models\Product;
use App\Models\WorkOrder;
use App\Services\Product\ProductService;
use App\Services\WorkOrder\WorkOrderService;
use Livewire\Component;

class Datatable extends Component implements ExportsContract
{
    use SmartTable;
    use DetailsModal;
    use Exportable;
     
    public $model = WorkOrder::class;
    protected $view = 'livewire.work-orders.datatable';

    protected $queryString = ['filterFromDate', 'filterToDate', 'showFilters', 'filterProduct', 'filterStatus', 'filterWoCode', 'filterWoQueue'];

    protected $alsoSearch = [
        'product.prd_name',
    ];

    protected $orderByDefault = [
        'column' => 'wo_datetime',
        'direction' => 'asc',
    ];

    // public $product;

    // filters
    public $filterProduct;
    public $filterStatus;
    public $filterWoCode;
    public $filterWoQueue;

    public function mount($product = null) // override
    {
        $this->stInit(); // smarttable içinde
        if($product) {
            $this->showFilters = true;
            $this->filterProduct = $product->id;
        }
    }
    

    private function resetFilters()
    {
        $this->reset('filterProduct', 'filterStatus', 'filterWoCode', 'filterWoQueue');
    }

    private function advancedFilters()
    {
        return [ // and
            ['product_id' => $this->filterProduct], // or
            ['wo_status' => $this->filterStatus],
            ['wo_code' => $this->filterWoCode],
            ['wo_queue' => $this->filterWoQueue],
        ];
    }


    public function getProductsProperty()
    {
        return ProductService::getProducibleOnes();
    }

    public function getStatesProperty()
    {
        return $this->model::states();
    }

    public function getWoCodesProperty()
    {
        return WorkOrderService::getUniqueWoCodes();
    }



    // public function exportToExcel()
    // {
    //     return (new WorkOrdersExport($this->filteredQuery()))->download("İş emirleri(" . date('d.m.Y') . ').xlsx');
    // }

    // public function exportToPDF()
    // {
    //     return (new WorkOrdersExport($this->filteredQuery()))->download("İş emirleri(" . date('d.m.Y') . ').pdf', \Maatwebsite\Excel\Excel::MPDF);
    // }

}
