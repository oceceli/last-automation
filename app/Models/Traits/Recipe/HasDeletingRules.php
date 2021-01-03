<?php

namespace App\Models\Traits\Recipe;

use App\Models\WorkOrder;

trait HasDeletingRules
{
    public function delete()
    {
        if($this->recipeUsedInActiveWorkOrders() > 0) {
            return ['message' => '!!! Bu reçeteye ait aktif iş emri/emrileri olduğu için silinemez!', 'type' => 'error'];
        } 
            
        $this->ingredients()->detach();
        parent::delete();
        return ['message' => __('sections/recipes.recipe_deleted_successfully'), 'type' => 'success'];
        
    }



    private function recipeUsedInActiveWorkOrders() 
    {
        return WorkOrder::where('product_id', $this->product->id)
                        ->where(function($query){
                            $query->where('status', 'active')
                                  ->orWhere('status', 'suspended')
                                  ->orWhere('status', 'in_progress');
                        })->count();
    }
}