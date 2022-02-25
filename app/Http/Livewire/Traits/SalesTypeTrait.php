<?php


namespace App\Http\Livewire\Traits;

use App\Models\SalesType;

trait SalesTypeTrait
{
    public $st_name;
    public $st_abbr;

    public $stEditMode = false;
    public $salesType;

    protected function salesTypeRules()
    {
        return [
            'st_name' => 'required',
            'st_abbr' => 'required',
            // 'st_name' => 'required|unique:sales_types,' . optional($this->salesType)->id,
            // 'st_abbr' => 'required|unique:sales_types,' . optional($this->salesType)->id,
        ];
    }

    public function stEdit($salesTypeId)
    {
        $this->stEditMode = true;

        $salesType = $this->salesType = SalesType::find($salesTypeId);

        $this->st_name = $salesType->st_name;
        $this->st_abbr = $salesType->st_abbr;
    }

    public function stDelete($salesTypeId)
    {
        SalesType::findAndDelete($salesTypeId);
        $this->emit('st_updated');
    }


    public function submitSalesType()
    {
        $data = $this->validate($this->salesTypeRules());

        if($this->stEditMode) {
            $this->salesType->update($data);
            $this->emit('st_updated', $this->salesType->id);
        } else {
            $salesType = SalesType::create($data);
            $this->emit('st_updated', $salesType->id);
        }
        
        $this->emit('toast', '', __('common.saved.saved_successfully'), 'success');
        $this->reset('st_name', 'st_abbr', 'stEditMode', 'salesType');
    }

}
