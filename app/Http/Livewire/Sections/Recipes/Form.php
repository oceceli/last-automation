<?php

namespace App\Http\Livewire\Sections\Recipes;

use App\Http\Livewire\Form as BaseForm;
use App\Models\Product;
use App\Models\Recipe;
use \Illuminate\Support\Str;

class Form extends BaseForm
{

    public $model = Recipe::class;
    
    public $view = 'livewire.sections.recipes.form';


    public $product_id;
    public $code;
    


    protected function passToView()
    {
        return [
            //
        ];
    }

    public function getProductsProperty()
    {
        return Product::all();
    }

    public function random()
    {
        $string = $this->code;
        $number = 8;
        if($string) {
            $pos = strpos($string, '_');
            if(! $pos) {
                $this->code = $string . '_' . Str::random($number);
            } else {
                $string = substr($string, 0, $pos);
                $this->code = $string . '_' . Str::random($number);
            }
        } else {
            $this->code = Str::random($number);
        }
        
    }


}
