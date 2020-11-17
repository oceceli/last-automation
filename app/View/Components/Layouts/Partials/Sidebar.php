<?php 

namespace App\View\Components\Layouts\Partials;

use Illuminate\View\Component;

class Sidebar extends Component
{

    public $user;


    public function __construct()
    {
        $this->user = auth()->user();
    }


    public function render()
    {
        return view('web.layouts.partials.sidebar');
    }


    public function routes()
    {
        return [
            ['name' => 'dashboard', 'label' => 'dashboard', 'icon' => 'icon large dashboard'],
            ['name' => 'products.index', 'label' => 'products', 'icon' => 'icon large box'],
            ['name' => 'products.create', 'label' => 'products-create', 'icon' => 'icon large box'],
            ['name' => 'work-orders.index', 'label' => 'work-orders', 'icon' => 'icon large project diagram'],
            ['name' => 'work-orders.create', 'label' => 'work-orders_create', 'icon' => 'icon large project diagram'],
            ['name' => 'work-orders.daily', 'label' => 'work-orders-daily', 'icon' => 'icon large settings'],
            ['name' => 'recipes.index', 'label' => 'recipes', 'icon' => 'icon large mortar pestle'],
            ['name' => 'recipes.create', 'label' => 'recipes-create', 'icon' => 'icon large mortar pestle'],
            ['name' => 'stock-moves.index', 'label' => 'stock-moves', 'icon' => 'large truck packing icon'],
            ['name' => 'stock-moves.create', 'label' => 'stock-moves-create', 'icon' => 'large truck packing icon'],
            ['name' => 'units.create', 'label' => 'unit-create', 'icon' => 'icon large weight'],
        ];
    }
}