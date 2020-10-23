<?php

namespace App\Http\Livewire\Tools;

use Livewire\Component;

class Toaster extends Component
{

    protected $listeners = ['toast' => 'set'];

    public $title;
    public $message;
    public $type;
    public $position;
    public $pbpos;

    public function mount($message = "Kayıt işlemi başarılı oldu...", $title = "Başarılı", 
        $position = 'bottom right', $type = 'secondary', $pbpos = 'bottom')
    {
        $this->message = $message;
        $this->type = $type;
        $this->position = $position;
        $this->title = $title;
    }

    public function set()
    {
        $this->dispatchBrowserEvent('stamp-toast');
    }

    public function render()
    {
        return view('livewire.tools.toaster');
    }
}
