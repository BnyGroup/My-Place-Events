<html lang="fr">

<head>
    <title>@yield('page.title') | E-WALLET</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="expires" content="-1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{ asset('/wallet/assets/images/FAV.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('/wallet/assets/images/FAV.png') }}" type="image/x-icon">
    @include('layouts.css')
    <link rel="stylesheet" type="text/css" href="{{ asset('/wallet/assets/css/style.css') }}">
    @stack('page.css')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
</head>

<body>
    <div class="img-loeader" style="display: none;">
        <img src="{{ asset('/default/loader.svg') }}">
    </div>
    <div id="fb-root"></div>
    <div class="container-fluid" style="padding:0;">@include('layouts.header', ['wallet'=> ''])</div>
    <div id="main-container">
        <div class="container wallet">
            <div id="wrapper">
                @yield('page.content')
            </div>
        </div>
    </div>
    <div class="container-fluid footer-wrapper">@include('layouts.footer')</div>
    <div class="xs-12 footer-icon" id="footer-icon">
        <div class="container">
            <div class="IconZone navbar navbar-expand-lg" id="navbarSupportedContent" style="justify-content: center!important">
                <ul class="navbar-nav">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <li class="nav-item lang">
                        @if($properties['native'] === 'Français')
                        <a class="nav-link" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" data-toggle="tooltip" title="Français" data-placement="bottom">
                            <img src="/public/img/Fr.png" alt="" />
                        </a>
                        @elseif($properties['native'] === 'English')
                        <a class="nav-link" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" data-toggle="tooltip" title="Anglais" data-placement="bottom">
                            <img src="/public/img/En.png" alt="" />
                        </a>
                        @endif
                        </a>
                    </li>
                    @endforeach

                    <li class="nav-item">
                        <a class="nav-link" href="https://www.facebook.com/myplaceeventscom/" target="_blank"><i class="ti-facebook"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://www.instagram.com/myplace_events/" target="_blank"><i class="ti-instagram"></i></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="https://www.youtube.com/channel/UCHAgMo7VQLKQ_BcXAhmGuIw" target="_blank"><i class="ti-youtube"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @include('layouts.script')
    @stack('page.scripts')
</body>

</html>