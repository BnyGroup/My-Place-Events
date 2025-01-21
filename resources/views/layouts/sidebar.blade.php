@php

$currentPageURL = URL::current();
$pageArray = explode('/', $currentPageURL);
$pageActive = isset($pageArray[4]) ? $pageArray[4] : '';
$pageActive_sub = isset($pageArray[5]) ? $pageArray[5] : '';
$pageActive_subsub = isset($pageArray[6]) ? $pageArray[6] : '';

@endphp

<aside class="col-lg-2 px-0 side-bar-nav " id="left" data-spy="affix" data-offset-top="197">
    <div class="list-group w-100">
        <a href="{{ route('user.bookmarks','upcoming') }}" class="list-group-item {{ ($pageActive_sub == 'upcoming')?'active':'' }}" style="border-top: 0"><i class="fas fa-ticket-alt"></i> @lang('words.user_menus.usr_mnu_log_1')</a>
        <a href="{{ route('user.bookmarks','saved') }}" class="list-group-item {{ ($pageActive_sub=='saved')?'active':'' }}"><i class="fas fa-calendar-check"></i> @lang('words.user_menus.usr_mnu_log_2')</a>
        <a href="{{ route('events.manage') }}" class="list-group-item {{ ($pageActive=='manage')?'active':'' }}"><i class="far fa-calendar-alt"></i> @lang('words.user_menus.usr_mnu_log_3')</a>
        <a href="{{ route('shop.item.manage') }}" class="list-group-item {{ ($pageActive=='manage')?'active':'' }}"><i class="fas fa-building"></i> @lang('words.user_menus.usr_mnu_log_10')</a>
        <a href="{{ route('events.create') }}" class="list-group-item "><i class="far fa-calendar-plus"></i> @lang('words.user_menus.usr_mnu_log_4')</a>
        <a href="{{ route('alu.index') }}" class="list-group-item {{ ($pageArray[3]=='a_la_une' && $pageActive=='index')?'active':'' }}"><i class="far fa-calendar-plus"></i> @lang('words.user_menus.usr_mnu_log_5')</a>
        <a href="{{ route('org.index')  }}" class="list-group-item {{ ($pageArray[3]=='org' && $pageActive=='index')?'active':'' }}"><i class="fas fa-building"></i> @lang('words.user_menus.usr_mnu_log_6')</a>
        <a href="{{ route('pre.index') }}" class="list-group-item {{ ($pageArray[3]=='prestataire' && $pageActive=='index')?'active':'' }}"><i class="fas fa-utensils"></i> @lang('words.user_menus.usr_mnu_log_7')</a>
        <a href="{{ route('users.pro','profile') }}" class="list-group-item "><i class="fas fa-user"></i> @lang('words.user_menus.usr_mnu_log_8')</a>
        <a href="{{ route('user.logout') }}" class="list-group-item"><i class="fas fa-sign-out-alt"></i> @lang('words.user_menus.usr_mnu_log_9')</a>
    </div>
</aside>

<!--Footer nav account-->
<div class="col-md-12" id="footNav">
    <div class="row">
        <div class="content-foot">
            <a href="{{ route('user.bookmarks','upcoming') }}" class="{{ ($pageActive_sub == 'upcoming')?'active':'' }}" ><i class="fas fa-ticket-alt"></i>
                <span>Tickets</span></a>
            <a href="{{ route('events.manage') }}" class="{{ ($pageActive=='manage')?'active':'' }}"><i class="far fa-calendar-alt"></i>
                <span>G. Events</span></a>
            <a href="{{ route('events.create') }}"><i class="far fa-calendar-plus"></i>
                <span>C. Event</span></a>
            <a href="{{ route('org.index')  }}" class="{{ ($pageArray[3]=='org' && $pageActive=='index')?'active':'' }}"><i class="fas fa-building"></i>
                <span>G. org</span></a>
            <a href="{{ route('pre.index') }}" class="{{ ($pageArray[3]=='prestataire' && $pageActive=='index')?'active':'' }}"><i class="fas fa-utensils"></i>
                <span>G. Presta.</span></a>

        </div>
    </div>
</div>
<!--Footer nav account-->