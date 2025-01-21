@inject('datacout',App\Booking)
@inject(countries,'App\PaysList')
@inject(eventCat,'App\EventCategory')
@php
$id = auth()->guard('frontuser')->check()?auth()->guard('frontuser')->user()->id:'';
$upcount = $datacout->upCounts($id);
Jenssegers\Date\Date::setLocale('fr');
@endphp

<?php
$currentPageURL = URL::current();
$pageArray = explode('/', $currentPageURL);
$pageArray[3] = !isset($pageArray[3]) ? '':$pageArray[3];
$pageActive = isset($pageArray[3]) ? $pageArray[3] : '';
$pageActive_sub = isset($pageArray[5]) ? $pageArray[5] : '';
$pageActive_subsub = isset($pageArray[6]) ? $pageArray[6] : '';
?>

 


<div class="">
    <nav style="height:46px" class="navbar navbar-expand-lg navbar-light bg-light @if (Route::currentRouteName() == 'shop' || Route::currentRouteName() == 'shop_item.create' || Route::currentRouteName() == 'shop_cart.index')primary-bg @else secondary-bg @endif" id="super-header" >
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                 

            @if(auth()->guard('frontuser')->check())
            <ul class="navbar-nav right-super non-connecte">

                <li class="compte-infos Wallet">
                    <a href="https://myplace-events.com/user/wallet" class="user-link" data-toggle="tooltip"
                    title="@lang('words.header.wallet')"
                    data-placement="left">
                    @if((auth()->guard('frontuser')->user()->oauth_provider)== null)
                    <img src="/public/default/Wallet.png"
                    class="user-profile" alt="Wallet">
                    @else
                    <img src="/public/default/Wallet.png"
                    class="user-profile" alt="Wallet">
                    @endif
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="">@lang('words.header.Solde')
                            <span class="label"> {{number_format($wallet, 0,'', ' ')}} F CFA </span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="compte-infos Shop">
                <a href="{{route('shop_cart.index')}}" class="user-link" data-toggle="tooltip" title="@lang('words.header.Shop')" data-placement="left">
                @if((auth()->guard('frontuser')->user()->oauth_provider)== null)
                <img src="/public/default/ShopIco.png" class="user-profile" alt="Panier"><div style="background-color:#f08f24;width:18px;height:18px;border-radius:100%;position: relative;bottom:42px;left:22px"><span style="color:#000D8C;display:block;position:relative;right:2px;position: relative;left: 5px;font-size:.8em;font-weight:bold;bottom: 1px;;">{{Cart::count()}}</span></div>
                @else
                <img src="/public/default/ShopIco.png" class="user-profile" alt="Panier">
                @endif
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="">@if(Cart::count() > 1 ){{Cart::count()}} @lang('words.header.content1') @else {{Cart::count()}} @lang('words.header.content') @endif
                        </a>
                    </li>
                </ul>
            </li>

        <li class="compte-infos UserIcon">
            <!-- {{ route('users.pro') }} -->
            <a href="https://myplace-events.com/user/events/upcoming" class="user-link" data-toggle="tooltip"
            title="{{ auth()->guard('frontuser')->user()->firstname }} {{ auth()->guard('frontuser')->user()->lastname }}"
            data-placement="left">
            @if((auth()->guard('frontuser')->user()->oauth_provider)== null)
            <img src="{{ setThumbnail(auth()->guard('frontuser')->user()->profile_pic) }}"
            class="user-profile" alt="user">
            @else
            <img src="{{ url(auth()->guard('frontuser')->user()->profile_pic) }}"
            class="user-profile" alt="user">
            @endif
            </a>
            <ul class="sub-menu">
                <li>
                    <a href="{{ route('user.bookmarks','upcoming') }}">@lang('words.user_menus.usr_mnu_log_1')
                        <span class="label">{{ $upcount }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.bookmarks','saved') }}">@lang('words.user_menus.usr_mnu_log_2')</a>
                </li>
                <li><span class="line"></span></li>
                <li><a href="{{ route('events.manage') }}">@lang('words.user_menus.usr_mnu_log_3')</a></li>
                <li><span class="line"></span></li>
                <li><a href="{{ route('shop.item.manage') }}">@lang('words.user_menus.usr_mnu_log_10')</a></li>
                <li><span class="line"></span></li>
                <li><a href="{{ route('org.index') }}">@lang('words.user_menus.usr_mnu_log_5')</a></li>
                <li><span class="line"></span></li>
                <li><a href="{{ route('users.pro','profile') }}">@lang('words.user_menus.usr_mnu_log_8')</a></li>
                <li>
                    <a href="{{ route('pre.index') }}">@lang('words.user_menus.usr_mnu_log_6')</a>
                </li>
                <li><span class="line"></span></li>
                <li><a href="{{ route('user.logout') }}">@lang('words.user_menus.usr_mnu_log_9')</a></li>
            </ul>
        </li>
        @if (Route::currentRouteName() == 'shop' || Route::currentRouteName() == 'shop_item.create' || Route::currentRouteName() == 'shop_cart.index') 
    <li class="nav-item btn-create-event">
        <a href="{{ route('shop_item.create') }}" class="btn no-rad secondary-bg"><i class="ti-plus">&nbsp;</i>@lang('words.user_menus.usr_mnu_log_11')
        </a>
    </li> 
    @else
    <li class="nav-item btn-create-event">
        <a href="{{ route('events.create') }}"
        class="btn no-rad"><i class="ti-plus">&nbsp;</i> @lang('words.user_menus.usr_mnu_log_4')
    </a>
</li>
@endif
</ul>
@else
<ul class="navbar-nav right-super connecte">
    <li>
        <a href="{{ route('user.login') }}" class="@if(Route::currentRouteName() == 'shop')btn no-rad @else signin-btn @endif" >@lang('words.header_menu.menu3') / @lang('words.header_menu.menu4')</a>
    </li>

    @if (Route::currentRouteName() == 'shop') 
    <li class="nav-item btn-create-event">
        <a href="{{ route('shop_item.create') }}"
        class="btn no-rad secondary-bg">@lang('words.user_menus.usr_mnu_log_10')
    </a>
</li>
@else
<li class="nav-item btn-create-event">
    <a href="{{ route('events.create') }}"
    class="btn no-rad">@lang('words.user_menus.usr_mnu_log_3')
</a>
</li>
@endif
</ul>
@endif

</div>
</div>
</nav>
</div>

 
<!--Mobile navigation -->
<div class="mobile-nav navbar-fixed-top hidden-md hidden-lg">
    <div class="m-header">
        <a href="#menuMobile"><span></span></a>
        <a href="{{ url('/') }}" class="logo-mobile"> <img class="" alt="" src="{{ for_logo() }}"></a>

        <!--Search-->
        <a href="" class=" btn-recherche-header" data-toggle="modal" data-target="#recherche-events"><i class="fas fa-search"></i></a>

        <!-- Modal -->
        <div class="modal fade" id="recherche-events" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content secondary-bg">
                    <div class="modal-header secondary-bg" style="border:none">
                        <h5 class="modal-title third-text" id="exampleModalLabel">Rechercher un événement</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 32px;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body secondary-bg">
                        @include("theme.events.event-mobile-search")
                    </div>

                </div>
            </div>
        </div>
        <!--Search-->


        <!--Connect-->
        <ul>
         <li class="compte-infos">
             @if(auth()->guard('frontuser')->check())
             <!-- {{ route('users.pro') }} -->
             <a href="{{--https://myplace-event.com/user/events/upcoming--}}{{ url('user/events/upcoming') }}" class="user-link"
             title="{{ auth()->guard('frontuser')->user()->firstname }} {{ auth()->guard('frontuser')->user()->lastname }}">
             @if((auth()->guard('frontuser')->user()->oauth_provider) == null)
             <img src="{{ setThumbnail(auth()->guard('frontuser')->user()->profile_pic) }}"
             class="user-profile" alt="user">
             @else
             <img src="{{ url(auth()->guard('frontuser')->user()->profile_pic) }}"
             class="user-profile" alt="user">
             @endif
         </a>
         @else
         <a href="{{--https://myplace-event.com/signin--}}{{ url('signin') }}" style=" font-size: 26px; top: 12px !important;"><i class="fas fa-sign-in-alt"></i></a>
         @endif
     </li>
 </ul>


 <!--Connect-->

</div>
</div>
<div class="mobile-space"></div>
<!--Mobile navigation -->
