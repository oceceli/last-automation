<?php

namespace App\Http\Livewire\StockMoves;

use App\Http\Livewire\SmartTable;
use App\Models\StockMove;
use Livewire\Component;

class Datatable extends Component
{
    use SmartTable;

    public $model = StockMove::class;
    public $view = 'livewire.stock-moves.datatable';

    protected $orderByDefault = [
        'column' => 'datetime',
        'direction' => 'asc',
    ];


    public function delete($id) // !! bunu bir trait yardımıyla tüm componentlere ekleyebilirim.
    {
        $result = $this->model::findAndDelete($id);
        if(is_array($result) && $result['type'] == 'error') {
            $this->emit('toast', __('common.error.title'), $result['message'], 'warning');
        } 
        // else {
        //     $this->emit('toast', '', $result['message'], 'success');
        //     $this->reset();
        // }
    }

}
