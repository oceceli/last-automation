<?php

namespace App\Http\Livewire\Categories;

use App\Http\Livewire\Traits\Categories\CategoriesFormTrait;
use Livewire\Component;


class Form extends Component
{
    use CategoriesFormTrait;


    public function render()
    {
        return view('livewire.categories.form');
    }

}
