<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $su = User::create([
            'name' => 'Super Man',
            'email' => 'superman@oceceli.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$O3tk5grgZZCzi37R9/P7FuZZ3NPbuQf.GqT7U333wg8IX1kyketPi',
            'remember_token' => Str::random(10),
        ]);
        
        $su->assignRole('super user');

        
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make(env('ADMIN_PASS', 'secureadmin2021')),
            'remember_token' => Str::random(10),
        ]);
        
        $admin->assignRole('admin');
        
        $adminRole = Role::findByName('admin');
        $adminRole->givePermissionTo(Permission::all());


        $unauthorizedUser = User::create([
            'name' => 'unauthorized user',
            'email' => 'aaa@aaa.com',
            'email_verified_at' => now(),
            'password' => Hash::make('qwerty123456'),
            'remember_token' => Str::random(10),
        ]);


        User::factory()->count(20)->create();

    }
}
