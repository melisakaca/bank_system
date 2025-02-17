<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\RolePermission;
use Illuminate\Support\Facades\DB;
class RolesPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
           
            $roles = [
                'admin' => ['manage_bankers'],
                'banker' => [
                    'manage_clients',
                    'approve_bank_accounts',
                    'approve_debit_cards',
                    'view_all_accounts',
                    'view_all_cards',
                    'view_all_transactions',
                    'approve_transactions'
                ],
                'client' => [
                    'request_bank_account',
                    'request_debit_card',
                    'view_own_accounts',
                    'view_own_cards',
                    'view_own_transactions',
                    'perform_transactions'
                ]
            ];
    
            
            foreach ($roles as $roleName => $permissions) {
                $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
    
                foreach ($permissions as $permissionName) {
                    $permission = Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'web']);
                    RolePermission::firstOrCreate(['role_id' => $role->id, 'permission_id' => $permission->id]);
                }
            }
    
            
            $adminUser = User::factory()->create([
                'name' => 'Administrator',
                'email' => 'admin@mbank.com',
                'password' => bcrypt('password'),
            ]);
            $adminUser->assignRole('admin');
            $adminUser->givePermissionTo($roles['admin']);
        });
    }
}
