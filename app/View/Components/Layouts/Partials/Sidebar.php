<?php 

namespace App\View\Components\Layouts\Partials;

use Illuminate\View\Component;

class Sidebar extends Component
{

    public $user;

    public $activeMenuGroupKey;


    

    public function __construct()
    {
        $this->user = auth()->user();
        $this->decideOpenedDropdown();
    }


    
    public function decideOpenedDropdown()
    {
        foreach($this->menuItems() as $index => $menuItem) {
            if(array_key_exists('submenus', $menuItem) && is_array($menuItem['submenus'])) {
                foreach($menuItem['submenus'] as $submenu) {
                    if(route($submenu['name']) === url()->current()) 
                        $this->activeMenuGroupKey = $index;
                }
            } else {
                if(route($menuItem['name']) === url()->current()) 
                        $this->activeMenuGroupKey = $index;
            }
        }
    }


    public function render()
    {
        return view('web.layouts.partials.sidebar');
    }



    public function menuItems()
    {
        return [
            [
                'name' => 'dashboard', 
                'label' => 'dashboard',
                'icon' => 'icon large dashboard', 
            ],
            [
                'name' => 'products.index', 
                'label' => 'products', 
                'icon' => 'icon large brown box', 
                'submenus' => [
                    [
                        'name' => 'products.index', 
                        'label' => 'products_list', 
                        'icon' => 'list icon',
                    ],
                    [
                        'name' => 'products.create', 
                        'label' => 'define_product', 
                        'icon' => 'plus icon',
                    ],
                ]
            ],
            [
                'name' => 'work-orders.index', 
                'label' => 'work-orders', 
                'icon' => 'icon large project diagram', 
                'submenus' => [
                    [
                        'name' => 'work-orders.create', 
                        'label' => 'create', 
                        'icon' => 'plus icon',
                    ],
                    [
                        'name' => 'work-orders.index', 
                        'label' => 'all_workorders', 
                        'icon' => 'list icon',
                    ],
                    [
                        'name' => 'work-orders.daily', 
                        'label' => 'work-orders-daily', 
                        'icon' => 'icon settings',
                    ],
                ]
            ],
            [
                'name' => 'recipes.index', 
                'label' => 'recipes', 
                'icon' => 'icon large mortar pestle', 
                'submenus' => [
                    [
                        'name' => 'recipes.create', 
                        'label' => 'recipes-create', 
                        'icon' => 'icon large mortar pestle',
                    ],
                ]
            ],
            
            [
                'name' => 'stock-moves.index', 
                'label' => 'stocks', 
                'icon' => 'large truck packing icon', 
                'submenus' => [
                    [
                        'name' => 'inventory.index', 
                        'label' => 'inventory', 
                        'icon' => 'large warehouse icon',
                    ],
                ]
            ],
            [
                'name' => 'units.create', 
                'label' => 'unit-create', 
                'icon' => 'icon large weight', 
                'submenus' => [
                    [
                        'name' => 'units.create', 
                        'label' => 'unit-create', 
                        'icon' => 'icon large weight',
                    ],
                ]
            ],
        ];
    }
}


            // ['name' => 'work-orders.create', 'label' => 'work-orders_create', 'icon' => 'icon large project diagram', 'submenus' => [['name' => 'testvalue'], ['name' => 'test2']]],
            // ['name' => 'stock-moves.create', 'label' => 'stock-moves-create', 'icon' => 'large truck packing icon', 'submenus' => [['name' => 'testvalue'], ['name' => 'test2']]],
