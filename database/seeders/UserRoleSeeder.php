<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $default_user_value = [
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];

        DB::beginTransaction();
        try {
            
            $staff = User::create(array_merge([
                'name' => 'staff',
                'email' => 'staff@gmail.com',
                'password' => Hash::make('password'),
            ], $default_user_value));
            
            $spv = User::create(array_merge([
                'name' => 'spv',
                'email' => 'spv@gmail.com',
                'password' => Hash::make('password'),
            ], $default_user_value));
            
            $manager = User::create(array_merge([
                'name' => 'manager',
                'email' => 'manager@gmail.com',
                'password' => Hash::make('password'),
            ], $default_user_value));
    
            $role_staff = Role::create(['name' => 'staff']);
            $role_spv = Role::create(['name' => 'spv']);
            $role_manager = Role::create(['name' => 'manager']);
    
            $permission = Permission::create(['name' => 'read role']);
            $permission = Permission::create(['name' => 'create role']);
            $permission = Permission::create(['name' => 'update role']);
            $permission = Permission::create(['name' => 'delete role']);
    
            $staff->assignRole('staff');
            $staff->assignRole('spv');
            $spv->assignRole('spv');
            $manager->assignRole('$manager');

            //kalau berhasil di commit
            DB::commit();
        } catch (\Throwable $th) {
            //kalau error rollback DB terlebih dahulu
            DB::rollBack();
        }
    }
}
