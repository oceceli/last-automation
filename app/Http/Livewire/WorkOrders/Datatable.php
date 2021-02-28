<?php

namespace App\Http\Livewire\WorkOrders;

use App\Contracts\Exports;
use App\Exports\WorkOrdersExport;
use App\Http\Livewire\SmartTable;
use App\Http\Livewire\Traits\WorkOrders\DetailsModal;
use App\Models\Product;
use App\Models\WorkOrder;
use App\Services\WorkOrder\WorkOrderService;
use Livewire\Component;

class Datatable extends Component implements Exports
{
    use SmartTable;
    use DetailsModal;
     
    public $model = WorkOrder::class;
    protected $view = 'livewire.work-orders.datatable';

    protected $queryString = ['showFilters', 'filterProduct', 'filterStatus', 'filterWoCode', 'filterWoQueue', 'filterFromDate', 'filterToDate'];

    protected $alsoSearch = [
        'product.prd_name',
    ];

    // public $product;

    // filters
    public $filterProduct;
    public $filterStatus;
    public $filterWoCode;
    public $filterWoQueue;
    

    public function mount($product = null)
    {
        $this->stInit();
        if($product) {
            $this->showFilters = true;
            $this->filterProduct = $product->id;
        }
    }
    

    public function resetFilters()
    {
        $this->reset('filterProduct', 'filterStatus', 'filterWoCode', 'filterWoQueue');
    }

    private function advancedFilters()
    {
        return [ // and
            ['product_id' => $this->filterProduct], // or
            ['wo_status' => $this->filterStatus],
            ['wo_code' => $this->filterWoCode],
        ];
    }


    public function getProductsProperty()
    {
        return Product::getProducibleOnes();
    }

    public function getStatesProperty()
    {
        return $this->model::states();
    }

    public function getWoCodesProperty()
    {
        return WorkOrderService::getUniqueWoCodes();
    }


    
    public function exportToExcel()
    {
        return (new WorkOrdersExport($this->filteredQuery()))->download("İş emirleri(" . date('d.m.Y') . ').xlsx');
    }

    public function exportToPDF()
    {
        return (new WorkOrdersExport($this->filteredQuery()))->download("İş emirleri(" . date('d.m.Y') . ').pdf', \Maatwebsite\Excel\Excel::MPDF);
    }

}
