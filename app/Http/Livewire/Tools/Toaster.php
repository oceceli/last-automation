<?php

namespace App\Http\Livewire\Tools;

use Livewire\Component;

class Toaster extends Component
{

    protected $listeners = ['toast' => 'set'];

    public $icon;
    public $class;
    public $classProgress;
    public $showMethod;


    public $types = [
        'success' => [
            'icon' => 'checkmark',
            'class' => 'success',
            'classProgress' => 'success',
            'showMethod' => 'scale',
        ],
        'warning' => [
            'icon' => 'warning',
            'class' => 'orange',
            'classProgress' => 'warning',
            'showMethod' => 'shake',
        ],
        'error' => [
            'icon' => 'times',
            'class' => 'error',
            'classProgress' => 'error',
            'showMethod' => 'shake',
        ],
        'info' => [
            'icon' => 'info',
            'class' => 'secondary',
            'classProgress' => 'teal',
            'showMethod' => 'slide left',
        ],
    ];


    public function set($title, $message, $type = null, $icon = 'info', $class = 'white', $classProgress = 'red', $showImage = null, $position = 'bottom right', $closeIcon = false, $showMethod = 'scale')
    {

        if($type && array_key_exists($type, $this->types)) {
            foreach($this->types[$type] as $key => $value) {
                $this->$key = $value;
            }
        } else {
            $this->icon = $icon;
            $this->class = $class;
            $this->classProgress = $classProgress;
            $this->showMethod = $showMethod;
        }

        $this->dispatchBrowserEvent('stamp-toast', [
            'title' => ucfirst(__($title)), 
            'message' => ucfirst(__($message)), 
            'showImage' => $showImage,
            
            'icon' => $this->icon, 
            'class' => $this->class, 
            'classProgress' => $this->classProgress, 
            'showMethod' => $this->showMethod,
            
            'position' => $position, 
            'closeIcon' => $closeIcon, 
        ]);

    }
    

    public function render()
    {
        return view('livewire.tools.toaster');
    }
}
