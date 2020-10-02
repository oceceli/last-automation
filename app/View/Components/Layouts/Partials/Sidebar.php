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
            ['name' => 'products.index', 'label' => 'products', 'icon' => 'icon large dove'],
            ['name' => 'products.create', 'label' => 'products-create', 'icon' => 'icon large home'],
            ['name' => 'work-orders.index', 'label' => 'work-orders', 'icon' => 'icon large home'],
            ['name' => 'work-orders.create', 'label' => 'work-orders_create', 'icon' => 'icon large home'],
            ['name' => 'recipes.index', 'label' => 'recipes', 'icon' => 'icon large home'],
            ['name' => 'recipes.create', 'label' => 'recipes-create', 'icon' => 'icon large home'],
            ['name' => 'stock-moves.index', 'label' => 'stock-moves', 'icon' => 'icon large box'],
        ];
    }
}