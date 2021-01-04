<?php

namespace App\Models\Traits\StockMove;


trait HasDeletingRules
{
    public function delete() // !! deleting disabled
    {
        
        // if($this->isProduction()) return;        

        // if($this->siblings->where('direction', false)->count() > 0) return;
        
        // // perform delete
        // parent::delete();
    }

}




// return [
//     'message' => '!!! Üretime ait bir stok hareketi yalnızca iş emrini silerek yapılabilir...', 
//     'type' => 'error',
// ];