<?php

namespace App\Http\Livewire\DispatchOrders;

use App\Contracts\ExportsContract;
use App\Exports\DispatchOrderDetailedExport;
use App\Http\Livewire\SmartTable;
use App\Http\Livewire\Traits\Exportable;
use App\Models\Address;
use App\Models\DispatchOrder;
use App\Models\SalesType;
use App\Services\Company\CompanyService;
use Livewire\Component;

class Datatable extends Component implements ExportsContract
{
    use SmartTable;
    use Exportable;

    public $detailsModal = false;
    public $selectedDo;

    public $model = DispatchOrder::class;
    public $view = 'livewire.dispatch-orders.datatable';

    protected $alsoSearch = [
        'company.cmp_name', 
        'company.cmp_current_code',
        'address.adr_name',
        'salesType.st_name',
        'salesType.st_abbr',
    ];

    // models
    public $filterCompany;
    public $filterAddress;
    public $filterSalesType;
    public $filterDoNumber;
    public $filterDoStatus;

    public $selectedCompany;

    protected $queryString = ['filterFromDate', 'filterToDate', 'showFilters', 'filterCompany', 'filterAddress', 'filterSalesType', 'filterDoNumber', 'filterDoStatus'];


    public function mount($product = null)
    {
        $this->stInit();
        if($product) { // ! seçilen ürüne göre filtrele
            $this->showFilters = true;
            // $this->filterProduct = $product->id;
        }
    }


    private function resetFilters()
    {
        $this->reset('filterCompany', 'filterAddress', 'filterSalesType', 'filterDoNumber', 'filterDoStatus');
    }

    private function advancedFilters()
    {
        return [
            ['do_number' => $this->filterDoNumber],
            ['company_id' => $this->filterCompany],
            ['address_id' => $this->filterAddress],
            ['sales_type_id' => $this->filterSalesType],
            ['do_status' => $this->filterDoStatus],
        ];
    }

    public function getCompaniesProperty()
    {
        return CompanyService::getCustomers(['id', 'cmp_commercial_title']);
    }

    public function getSalesTypesProperty()
    {
        return SalesType::all();
    }

    public function getDoStatesProperty()
    {
        return DispatchOrder::states();
    }
    

    public function updatedFilterCompany($companyId)
    {
        $this->reset('filterAddress');
        $this->selectedCompany = $this->companies->find($companyId);   
    }



    public function openDetailsModal($dispatchOrderId)
    {
        $this->selectedDo = DispatchOrder::find($dispatchOrderId);
        $this->detailsModal = true;
    }

    public function updatedDetailsModal($bool)
    {
        if($bool == false) $this->reset('selectedDo', 'detailsModal');
    }


    public function exportDispatchOrderDetailed()
    {
        return (new DispatchOrderDetailedExport($this->selectedDo->query()))->toExcel();
    }

}
