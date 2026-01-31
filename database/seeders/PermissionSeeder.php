<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();


         // Remove all existing role-user assignments
       // Remove all existing role-user assignments
        DB::table('model_has_roles')->delete();
        DB::table('model_has_permissions')->delete();
        DB::table('role_has_permissions')->delete();
        DB::table('permissions')->delete();
        DB::table('roles')->delete();


        $permissions = [

            // Lead Master
            'lead.list',
            'lead.add',
            'lead.edit',
            'lead.delete',
            'lead.approve',

            // Client
            'client.list',
            'client-create',
            'client-edit',
            'client-delete',

            // Service Master
            'service.list',
            'service.add',
            'service.edit',
            'service.delete',

            // Quotation
            'quotation.list',
            'quotation.add',
            'quotation.edit',
            'quotation.print',
            'quotation.approve',

            // Invoice
            'invoice.list',
            'invoice.add',
            'invoice.approve',
            'invoice.payment_add',
            'invoice.print',

            // Payment Receipt
            'payment_receipt.download',

            // Service Category
            'service_category.list',
            'service_category.add',
            'service_category.edit',
            'service_category.delete',

            // Service Type
            'service_type.list',
            'service_type.add',
            'service_type.edit',
            'service_type.delete',

            // Staff
            'staff.list',
            'staff.add',
            'staff.assign_customer_list',
            'staff.assign_customer',
            'staff.view_report',

            // Project
            'project.list',
            'project.add',
            'project.edit',
            'project.status',

            // Vendor Receipt
            'vendor_receipt.list',
            'vendor_receipt.add',

            // Vendor
            'vendor.list',
            'vendor.add',
            'vendor.edit',
            'vendor.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Admin role
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        // Admin gets all permissions
        $adminRole->syncPermissions(Permission::all());

        /**
         * Assign Admin role to users where sub_admin = 0
         */
        $adminUsers = User::where('sub_admin', 0)->get();

        foreach ($adminUsers as $user) {
            if (! $user->hasRole('Admin')) {
                $user->assignRole($adminRole);
            }
        }
    }
}
