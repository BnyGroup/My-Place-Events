<?php

use Illuminate\Database\Seeder;
use App\Permission;
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
        	[
        		'name' => 'role-list',
        		'display_name' => 'Display Role Listing',
        		'description' => 'See only Listing Of Role'
        	],
        	[
        		'name' => 'role-create',
        		'display_name' => 'Create Role',
        		'description' => 'Create New Role'
        	],
        	[
        		'name' => 'role-edit',
        		'display_name' => 'Edit Role',
        		'description' => 'Edit Role'
        	],
        	[
        		'name' => 'role-delete',
        		'display_name' => 'Delete Role',
        		'description' => 'Delete Role'
        	],
            [
                'name' => 'dashboard-listing',
                'display_name' => 'Dashbaord List',
                'description' => 'See only Dashbaord',
            ],
            [
                'name' => 'change-password-box',
                'display_name' => 'Change Password',
                'description' => 'Display Change Password Box',
            ],
            [
                'name' => 'admin-user-cerate',
                'display_name' => 'Admin User Create',
                'description' => 'Admin User Create',   
            ],
            [
                'name' => 'admin-user-edit',
                'display_name' => 'Admin User Edit',
                'description' => 'Admin User Edit', 
            ],
            [
                'name' => 'admin-user-delete',
                'display_name' => 'Admin User Delete',
                'description' => 'Admin User Delete',    
            ],
            [
                'name' => 'admin-user-view',
                'display_name' => 'Admin User Profile View',
                'description' => 'Admin User Profile View',    
            ],
            [
                'name' => 'admin-user-listing',
                'display_name' => 'Admin User List',
                'description' => 'Admin User List', 
            ],
            [
                'name' => 'front-user-list',
                'display_name' => 'Front User List',
                'description' => 'Front User List',
            ],
            [
                'name' => 'front-user-view',
                'display_name' => 'Front User View',
                'description' => 'Front User View',
            ],
            [
                'name' => 'front-user-delete',
                'display_name' => 'Front User Delete',
                'description' => 'Front User Delete',
            ],
            [
                'name' => 'event-categories-create',
                'display_name' => 'Event Categories Create',
                'description' => 'Event Categories Create',    
            ],
            [
                'name' => 'event-categories-edit',
                'display_name' => 'Event Categories Edit',
                'description' => 'Event Categories Edit',    
            ],
            [
                'name' => 'event-categories-delete',
                'display_name' => 'Event Categories Delete',
                'description' => 'Event Categories Delete',    
            ],
            [
                'name' => 'event-categories-list',
                'display_name' => 'Event Categories List',
                'description' => 'Event Categories List',
            ],
            [
                'name' => 'event-view',
                'display_name' => 'Event view',
                'description' => 'Event view',
            ],
            [
                'name' => 'event-ban-revoke',
                'display_name' => 'Event Ban/Revoke',
                'description' => 'Event Ban/Revoke',
            ],
            [
                'name' => 'event-list',
                'display_name' => 'Event List',
                'description' => 'Event List',
            ],
            [
                'name' => 'organization-view',
                'display_name' => 'Organization view',
                'description' => 'Organization view',
            ],
            [
                'name' => 'organization-ban-revoke',
                'display_name' => 'Organization Ban/Revoke',
                'description' => 'Organization Ban/Revoke',
            ],
            [
                'name' => 'organization-list',
                'display_name' => 'Organization List',
                'description' => 'Organization List',
            ],
            [
                'name' => 'booking-list',
                'display_name' => 'Event Booking List',
                'description' => 'Event Booking List',
            ],
            [
                'name' => 'feedback-list',
                'display_name' => 'Feedback List',
                'description' => 'Feedback List',
            ],
            [
                'name' => 'feedback-delete',
                'display_name' => 'Feedback Delete',
                'description' => 'Feedback Delete',
            ],
            [
                'name' => 'pages-menu',
                'display_name' => 'Page Menu',
                'description' => 'Page Menu',
            ],
            [
                'name' => 'contact-page',
                'display_name' => 'Contact Page',
                'description' => 'Contact Page',
            ],
            [
                'name' => 'website-setting-data',
                'display_name' => 'Website Settings',
                'description' => 'Website Settings And Update',
            ],
            [
                'name' => 'seo-meta-settings',
                'display_name' => 'Seo Meta Settings',
                'description' => 'Seo Meta Settings And Update',
            ],
            [
                'name' => 'menu-setting',
                'display_name' => 'Menu Settings',
                'description' => 'Menu Settings',
            ],
            
        ];
        foreach ($permission as $key => $value) {
        	Permission::create($value);
        }
    }
    
}
