@extends('layouts.master')

@section('meta_title',setMetaData()->pnf_title)
@section('meta_description',setMetaData()->pnf_desc)
@section('meta_keywords',setMetaData()->pnf_keyword)


@section('content')
  <div class="container-fluid about-wrapper">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 about-parents-wrapper-min">
            <h2 class="text-uppercase about-title">@lang('words.home_content.404PageTitle')</h2>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-lg-12 col-md-12 parent-about-content text-center">
        <div class="margin-top">
          <img src="{{ asset('/default/404.png')}}" height="300">
          @if($exception->getMessage() == null)          
            <h2 class="text-uppercase"><b>@lang('words.home_content.404PageTexte')</b></h2>
          @else
           <h2 class="text-uppercase">@lang('words.home_content.404PageTexte')</h2>
          @endif
          <br>
          {{--<a href="{{ url()->previous() }}" class="margin-top pro-choose-file text-uppercase">@lang('words.home_content.404PageBack')</a>--}}
          <a href="{{ route('index') }}" class="margin-top pro-choose-file text-uppercase">@lang('words.home_content.404PageBack')</a>
          <br>
          <br>
        </div>
      </div>
    </div>
  </div>
@endsection