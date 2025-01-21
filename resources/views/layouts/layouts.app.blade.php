<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo">
            <span class="logo-mini"><b>E</b></span>
            <span class="logo-lg"><b>{{ forcompany() }}</b></span>
        </a>
        <!-- Navbar -->
        <nav class="navbar navbar-static-top">
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            @if((auth()->user()->oauth_provider)== null)
                                <img src="{{ setThumbnail(auth()->user()->profile_pic) }}" class="user-image" alt="User Image">
                            @else
                                <img src="{{ url(auth()->user()->profile_pic) }}" class="user-image" alt="User Image">
                            @endif
                            <span class="hidden-xs">{{ auth()->user()->firstname }} {{ auth()->user()->lastname }} </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img src="{{ setThumbnail(auth()->user()->profile_pic) }}" class="img-circle" alt="User Image">
                                <p>
                                    {{ str_limit(auth()->user()->firstname,13)}} {{ str_limit(auth()->user()->lastname,7) }} <br>
                                    @if(auth()->user()->admin_type == 0){{--Master Admin--}}Admin principal @else {{--Sub Admin--}}Second Admin</p>@endif
                                    <small>{{--Member since --}}Membre depuis{{ date_format(auth()->user()->created_at,'M Y') }}</small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ route('user.index') }}" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a class="btn btn-default btn-flat" href="{{ route('logout') }}">
                                        {{--Sign out--}}Se D�connecter
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <section class="content">
            @yield('content')
        </section>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
