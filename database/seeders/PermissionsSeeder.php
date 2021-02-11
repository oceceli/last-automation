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
        Permission::create(['name' => 'create product']);
        Permission::create(['name' => 'update product']);
        Permission::create(['name' => 'delete product']);
        
        Permission::create(['name' => 'create recipe']);
        Permission::create(['name' => 'update recipe']);
        Permission::create(['name' => 'delete recipe']);
        
        Permission::create(['name' => 'create workorder']);
        Permission::create(['name' => 'update workorder']);
        Permission::create(['name' => 'delete workorder']);
    }
}
