<?php


namespace App\Http\Livewire\Traits\Categories;

use App\Models\Category;

trait CategoriesFormTrait
{
    public $ctg_name;
    public $selectedCategory;

    public $categoryModal = false;

    public $ctgEditMode = false;



    protected function ctgRules()
    {
        return [
            'ctg_name' => 'required|unique:categories,ctg_name,' . optional($this->selectedCategory)->id,
        ];
    }



    public function ctgSubmit()
    {
        $ctgData = $this->validate($this->ctgRules());

        if($this->ctgEditMode && $this->selectedCategory) {
            if($this->selectedCategory->update($ctgData))
                $this->emit('categoryUpdated', $this->selectedCategory->id);
        } else {
            $category = Category::create($ctgData);
            $this->emit('categoryUpdated', $category->id);

            $this->selectedCategory = $category;
        }

        $this->closeCategoryModal();
        
    }



    public function ctgAdd()
    {
        $this->categoryModal = true;
    }


    public function ctgEdit()
    {
        if($this->selectedCategory) {
            $this->ctgEditMode = true;
            $this->categoryModal = true;
            $this->ctg_name = $this->selectedCategory->ctg_name;
        }
    }




    public function ctgDelete()
    {
        if($this->selectedCategory) {
            $this->selectedCategory->delete();
            $this->emit('categoryUpdated');
            $this->selectedCategory = null;
        }
    }



    private function closeCategoryModal()
    {
        $this->reset('categoryModal', 'ctg_name', 'ctgEditMode');
    }


    public function updatedCategoryModal($bool)
    {
        if($bool == false) $this->closeCategoryModal();
    }


    

    private function setCtgEditMode($category)
    {
        if($category) {
            $this->ctgEditMode = true;
            $this->selectedCategory = $category;
            $this->ctg_name = $category->ctg_name;
        }
    }
}