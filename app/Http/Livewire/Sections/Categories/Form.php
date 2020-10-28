<?php

namespace App\Http\Livewire\Sections\Categories;

use App\Http\Livewire\Form as Baseform;
use App\Models\Category;

class Form extends BaseForm
{
    public $model = Category::class;
    public $view = 'livewire.sections.categories.form';

    public $name;

    

}
