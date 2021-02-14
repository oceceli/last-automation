<?php

namespace App\Http\Livewire;


trait Deletable
{

    public $deleteModal = false;
    public $subjectId;

    public function delete($subjectId)
    {
        $this->deleteModal = true;
        $this->subjectId = $subjectId;
    }


    public function confirmDelete()
    {
        if(!$this->subjectId) return;

        $this->model::findAndDelete($this->subjectId);
        $this->reset('subjectId', 'deleteModal');

        $this->emit('toast', '', __('common.context_deleted'), 'info');
    }

}