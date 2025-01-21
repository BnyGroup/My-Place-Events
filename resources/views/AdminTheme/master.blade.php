<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
 

  <title>@yield('title')</title>
  
  @include('AdminTheme.css')
  <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('/img/favicon.png') }}">
	
  @yield('style')
</head>
<!-- <body @unless(empty($body_class)) class="hold-transition skin-blue sidebar-mini fixed  {{$body_class}} " @else class="hold-transition skin-blue sidebar-mini fixed   @endunless onbeforeunload="HandleBackFunctionality()"> --></body>
<body class="hold-transition skin-blue sidebar-mini fixed @yield('pageClass') " onbeforeunload="HandleBackFunctionality()">
 <style type="text/css">
  #loading{
    position: absolute;
    background: rgba(0,0,0,0.5);
    width: 100%;
    height: 100%;
    z-index: 9999;
    text-align: center;
  }
  #loading img{
    width: 80px;
    height: 80px;
    margin-top:20%;
  }
 </style> 
<div id="loading" style="display: none;">
    <img src="{{ asset('/default/loader.svg') }}">
</div>
<div class="wrapper">
  <header class="main-header">
    @include('AdminTheme.header')
  </header>

  <aside class="main-sidebar">
    @include('AdminTheme.sidebar')
  </aside>

  <div class="content-wrapper">
    <section class="content-header">
      @yield('content-header')
    </section>
    <section class="content">
      @yield('content')
    </section>
  </div>

  <footer class="main-footer">
    @include('AdminTheme.footer')
  </footer>
</div>
  @include('AdminTheme.script')
  @yield('page-level-script')
</body>
</html>
