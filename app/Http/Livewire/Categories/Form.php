<?php

namespace App\Http\Livewire\Categories;

use App\Http\Livewire\Form as Baseform;
use App\Models\Category;

class Form extends BaseForm
{
    public $model = Category::class;
    public $view = 'livewire.categories.form';

    public $name;

    public function submit()
    {
        $this->create();
        $this->emit('categoryUpdated', $this->created->id);
    }

}
