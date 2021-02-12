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
        Permission::create(['name' => 'view products']);
        Permission::create(['name' => 'create update products']);
        Permission::create(['name' => 'delete products']);
        
        Permission::create(['name' => 'view recipes']);
        Permission::create(['name' => 'create update recipes']);
        Permission::create(['name' => 'delete recipes']);
        
        Permission::create(['name' => 'view workorders']);
        Permission::create(['name' => 'create update workorders']);
        Permission::create(['name' => 'delete workorders']);
        Permission::create(['name' => 'process workorders']);
        
        Permission::create(['name' => 'view stockmoves']);
        Permission::create(['name' => 'create update stockmoves']);
        Permission::create(['name' => 'delete stockmoves']);

        Permission::create(['name' => 'view companies']);
        Permission::create(['name' => 'create update companies']);
        Permission::create(['name' => 'delete companies']);

        Permission::create(['name' => 'view dispatchorders']);
        Permission::create(['name' => 'create update dispatchorders']);
        Permission::create(['name' => 'delete dispatchorders']);
        Permission::create(['name' => 'process dispatchorders']);
        
        Permission::create(['name' => 'manage users']);
        
    }
}
