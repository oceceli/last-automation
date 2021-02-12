<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'view_products']);
        Permission::create(['name' => 'create_update_products']);
        Permission::create(['name' => 'delete_products']);
        
        Permission::create(['name' => 'view_recipes']);
        Permission::create(['name' => 'create_update_recipes']);
        Permission::create(['name' => 'delete_recipes']);
        
        Permission::create(['name' => 'view_workorders']);
        Permission::create(['name' => 'create_update_workorders']);
        Permission::create(['name' => 'delete_workorders']);
        Permission::create(['name' => 'process_workorders']);
        
        Permission::create(['name' => 'view_stockmoves']);
        Permission::create(['name' => 'create_update_stockmoves']);
        Permission::create(['name' => 'delete_stockmoves']);

        Permission::create(['name' => 'view_companies']);
        Permission::create(['name' => 'create_update_companies']);
        Permission::create(['name' => 'delete_companies']);

        Permission::create(['name' => 'view_dispatchorders']);
        Permission::create(['name' => 'create_update_dispatchorders']);
        Permission::create(['name' => 'delete_dispatchorders']);
        Permission::create(['name' => 'process_dispatchorders']);
    }
}
