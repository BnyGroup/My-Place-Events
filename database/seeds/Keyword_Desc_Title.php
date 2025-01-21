<?php

use Illuminate\Database\Seeder;
use App\Seometa;

class Keyword_Desc_Title extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
    		/* DEFAULT META DATA */
        	[
        		'name'      => 'Site',
                'slug'      => 'site',
                'title'     => 'Eventz',
                'desc'      => 'Discover Great Events or Create Your Own &amp; Sell Tickets',
        		'keyword'   => 'Eventz, Event, Events, Create event, Manage event',
        	],[
                'name'      => 'Page Not Found',
                'slug'      => 'pnf',
                'title'     => '404 - page Not Found',
                'desc'      => 'Discover Great Events or Create Your Own &amp; Sell Tickets',
                'keyword'   => 'Eventz, Event, Events, Create event, Manage event',
            ],[
                'name'      => 'Common Pages',
                'slug'      => 'page',
                'title'     => 'All',
                'desc'      => 'Discover Great Events or Create Your Own &amp; Sell Tickets',
                'keyword'   => 'Eventz, Event, Events, Create event, Manage event',
            ],[
                'name'      => 'Home',
                'slug'      => 'home',
                'title'     => 'Home Page',
                'desc'      => 'Discover Great Events or Create Your Own &amp; Sell Tickets',
                'keyword'   => 'Eventz, Event, Events, Create event, Manage event',
            ],[
                'name'      => 'Events List',
                'slug'      => 'e_list',
                'title'     => 'Events',
                'desc'      => 'Discover Great Events or Create Your Own &amp; Sell Tickets',
                'keyword'   => 'Eventz, Event, Events, Create event, Manage event',
            ],[
                'name'      => 'Create Events',
                'slug'      => 'e_create',
                'title'     => 'Create Events',
                'desc'      => 'Discover Great Events or Create Your Own &amp; Sell Tickets',
                'keyword'   => 'Eventz, Event, Events, Create event, Manage event',
            ],[
                'name'      => 'Update Events',
                'slug'      => 'e_update',
                'title'     => 'Update Events',
                'desc'      => 'Discover Great Events or Create Your Own &amp; Sell Tickets',
                'keyword'   => 'Eventz, Event, Events, Create event, Manage event',
            ],[
                'name'      => 'Manage Events',
                'slug'      => 'e_manage',
                'title'     => 'Manage Events',
                'desc'      => 'Discover Great Events or Create Your Own &amp; Sell Tickets',
                'keyword'   => 'Eventz, Event, Events, Create event, Manage event',
            ],[
                'name'      => 'Event Dashboard',
                'slug'      => 'e_deshbrd',
                'title'     => 'Event Dashboard',
                'desc'      => 'Discover Great Events or Create Your Own &amp; Sell Tickets',
                'keyword'   => 'Eventz, Event, Events, Create event, Manage event',
            ],[
                'name'      => 'Event Single',
                'slug'      => 'e_single',
                'title'     => 'Event Single',
                'desc'      => 'Discover Great Events or Create Your Own &amp; Sell Tickets',
                'keyword'   => 'Eventz, Event, Events, Create event, Manage event',
            ],[
                'name'      => 'Order Cancel',
                'slug'      => 'bking_cancel',
                'title'     => 'Order Cancel',
                'desc'      => 'Discover Great Events or Create Your Own &amp; Sell Tickets',
                'keyword'   => 'Eventz, Event, Events, Create event, Manage event',
            ],[
                'name'      => 'Events Success',
                'slug'      => 'bking_success',
                'title'     => 'Success',
                'desc'      => 'Discover Great Events or Create Your Own &amp; Sell Tickets',
                'keyword'   => 'Eventz, Event, Events, Create event, Manage event',
            ],[
                'name'      => 'Event Booking',
                'slug'      => 'bking_ticket',
                'title'     => 'Event Booking',
                'desc'      => 'Discover Great Events or Create Your Own &amp; Sell Tickets',
                'keyword'   => 'Eventz, Event, Events, Create event, Manage event',
            ],[
                'name'      => 'Booking Payment',
                'slug'      => 'bking_payment',
                'title'     => 'Booking Payment',
                'desc'      => 'Discover Great Events or Create Your Own &amp; Sell Tickets',
                'keyword'   => 'Eventz, Event, Events, Create event, Manage event',
            ],[
                'name'      => 'Order Id',
                'slug'      => 'bking_order',
                'title'     => 'Order Id',
                'desc'      => 'Discover Great Events or Create Your Own &amp; Sell Tickets',
                'keyword'   => 'Eventz, Event, Events, Create event, Manage event',
            ],[
                'name'      => 'Bookmark',
                'slug'      => 'bookmark',
                'title'     => 'Bookmark',
                'desc'      => 'Discover Great Events or Create Your Own &amp; Sell Tickets',
                'keyword'   => 'Eventz, Event, Events, Create event, Manage event',
            ],[
                'name'      => 'Organiser',
                'slug'      => 'org',
                'title'     => 'Organiser',
                'desc'      => 'Discover Great Events or Create Your Own &amp; Sell Tickets',
                'keyword'   => 'Eventz, Event, Events, Create event, Manage event',
            ],[
                'name'      => 'Organiser Single',
                'slug'      => 'org_single',
                'title'     => 'Organiser',
                'desc'      => 'Discover Great Events or Create Your Own &amp; Sell Tickets',
                'keyword'   => 'Eventz, Event, Events, Create event, Manage event',
            ],[
                'name'      => 'Create Organiser',
                'slug'      => 'org_create',
                'title'     => 'Create Organiser',
                'desc'      => 'Discover Great Events or Create Your Own &amp; Sell Tickets',
                'keyword'   => 'Eventz, Event, Events, Create event, Manage event',
            ],[
                'name'      => 'Organiser Profile Update',
                'slug'      => 'org_update',
                'title'     => 'Organiser Profile Update',
                'desc'      => 'Discover Great Events or Create Your Own &amp; Sell Tickets',
                'keyword'   => 'Eventz, Event, Events, Create event, Manage event',
            ],[
                'name'      => 'User Signin',
                'slug'      => 'user_loging',
                'title'     => 'Let\'s Get Started',
                'desc'      => 'Discover Great Events or Create Your Own &amp; Sell Tickets',
                'keyword'   => 'Eventz, Event, Events, Create event, Manage event',
            ],[
                'name'      => 'User Signup',
                'slug'      => 'user_signup',
                'title'     => 'Create Your Eventz Account',
                'desc'      => 'Discover Great Events or Create Your Own &amp; Sell Tickets',
                'keyword'   => 'Eventz, Event, Events, Create event, Manage event',
            ],[
                'name'      => 'User Account',
                'slug'      => 'user_account',
                'title'     => 'Account - Contact Information',
                'desc'      => 'Discover Great Events or Create Your Own &amp; Sell Tickets',
                'keyword'   => 'Eventz, Event, Events, Create event, Manage event',
            ],[
                'name'      => 'Reset Password',
                'slug'      => 'pass_reset',
                'title'     => 'Reset Password',
                'desc'      => 'Discover Great Events or Create Your Own &amp; Sell Tickets',
                'keyword'   => 'Eventz, Event, Events, Create event, Manage event',
            ],[
                'name'      => 'Update Password',
                'slug'      => 'pass_update',
                'title'     => 'Update Password',
                'desc'      => 'Discover Great Events or Create Your Own &amp; Sell Tickets',
                'keyword'   => 'Eventz, Event, Events, Create event, Manage event',
            ]
        ];
        foreach ($permission as $key => $value) {
        	Seometa::create($value);
        }
    }
}
