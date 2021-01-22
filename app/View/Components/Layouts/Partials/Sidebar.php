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
                'label' => 'common.dashboard',
                'icon' => 'icon dashboard', 
            ],
            [
                'name' => 'products.index', 
                'label' => 'common.products', 
                'icon' => 'icon box', 
                'submenus' => [
                    [
                        'name' => 'products.create', 
                        'label' => 'common.define_product', 
                        'icon' => 'plus icon',
                    ],
                    [
                        'name' => 'products.index', 
                        'label' => 'common.products_list', 
                        'icon' => 'th list icon',
                    ],
                    [
                        'name' => 'categories.create', 
                        'label' => 'common.create_category', 
                        'icon' => 'group layer icon',
                    ],
                    [
                        'name' => 'units.create', 
                        'label' => 'common.units',
                        'icon' => 'icon balance scale', 
                    ],
                ]
            ],
            [
                'name' => 'work-orders.index', 
                'label' => 'common.work-orders', 
                'icon' => 'icon project diagram', 
                'submenus' => [
                    [
                        'name' => 'work-orders.create', 
                        'label' => 'common.create', 
                        'icon' => 'plus icon',
                    ],
                    [
                        'name' => 'work-orders.index', 
                        'label' => 'common.all_workorders', 
                        'icon' => 'th list icon',
                    ],
                    [
                        'name' => 'work-orders.daily', 
                        'label' => 'common.work-orders-daily', 
                        'icon' => 'icon settings',
                    ],
                ]
            ],
            [
                'name' => 'recipes.index', 
                'label' => 'common.recipes', 
                'icon' => 'icon mortar pestle', 
                'submenus' => [
                    [
                        'name' => 'recipes.create', 
                        'label' => 'common.recipes-create', 
                        'icon' => 'plus icon',
                    ],
                    [
                        'name' => 'recipes.index', 
                        'label' => 'common.recipes', 
                        'icon' => 'th list icon',
                    ],
                ]
            ],
            
            [
                'name' => 'inventory.index', 
                'label' => 'common.stock', 
                'icon' => 'warehouse icon', 
                'submenus' => [
                    [
                        'name' => 'stock-moves.create', 
                        'label' => 'stockmoves.stock_moves_create', 
                        'icon' => 'sign dolly flatbed icon',
                    ],
                    [
                        'name' => 'stock-moves.index', 
                        'label' => 'common.stock_moves', 
                        'icon' => 'exchange icon',
                    ],
                    [
                        'name' => 'inventory.index', 
                        'label' => 'common.inventory', 
                        'icon' => 'warehouse icon',
                    ],
                ]
            ],
            [
                'name' => 'companies.index', 
                'label' => 'companies.companies', 
                'icon' => 'building icon',
                'submenus' => [
                    [
                        'name' => 'companies.create', 
                        'label' => 'companies.create_company', 
                        'icon' => 'plus icon',
                    ],
                    [
                        'name' => 'companies.index', 
                        'label' => 'companies.companies', 
                        'icon' => 'list icon',
                    ],
                ],
            ],
            [
                'name' => 'dispatchorders.index', 
                'label' => 'dispatchorders.dispatch', 
                'icon' => 'truck icon',
                'submenus' => [
                    [
                        'name' => 'dispatchorders.create', 
                        'label' => 'dispatchorders.create_dispatchorder', 
                        'icon' => 'plus icon',
                    ],
                    [
                        'name' => 'dispatchorders.index', 
                        'label' => 'dispatchorders.dispatchorders', 
                        'icon' => 'list icon',
                    ],
                    [
                        'name' => 'dispatchorders.daily', 
                        'label' => 'dispatchorders.do_daily', 
                        'icon' => 'angle shipping fast icon',
                    ],
                ],
            ],
            // [
            //     'name' => 'addresses.index', 
            //     'label' => 'addresses.addresses', 
            //     'icon' => 'book icon',
            //     'submenus' => [
            //         [
            //             'name' => 'addresses.create', 
            //             'label' => 'addresses.create_address',
            //             'icon' => 'plus icon',
            //         ],
            //         [
            //             'name' => 'addresses.index', 
            //             'label' => 'addresses.addresses', 
            //             'icon' => 'list icon',
            //         ],
            //     ],
            // ],
        ];
    }
}