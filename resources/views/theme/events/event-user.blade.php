@extends($theme)

@section('meta_title',setMetaData()->e_manage_title )
@section('meta_description',setMetaData()->e_manage_desc)
@section('meta_keywords',setMetaData()->e_manage_keyword)

@section('content')
    <div class="page-main-contain">
        <div class="col-md-12 user-events" style="border-top: 1px solid #dfdfdf;">
            <div class="row">

                @include('layouts.sidebar')

                <div class="col-lg-10 col-12">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="text-heading" align="center">@lang('words.mng_eve.mng_eve_tit')</h2>
                        </div>

                        <div class="col-md-12">
                            @if($success = Session::get('success'))
                                <div class="alert alert-success">{{ $success }}</div>
                            @endif
                        </div>
                    </div>
                    <br>
                    <!--Horizontal Tabs Events list -->
                    <div class="row">
                            <div class="col-md-12">
                                <div class="card-tabs-3">
                                    <div class="nav-center">
                                        <ul class="nav nav-tabs ">
                                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab-7" role="tab"><i class="fas fa-upload"></i> <span class="d-none d-sm-block">@lang('words.mng_eve.mng_eve_pus')</span> <span
                                                            class="label">{{ $totalcount }}</span></a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-8" role="tab"><i class="fas fa-trash-alt"></i> <span class="d-none d-sm-block">@lang('words.mng_eve.mng_eve_drf')</span> <span
                                                            class="label">{{ $darftCount }}</span></a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-9" role="tab"><i class="fas fa-arrow-alt-circle-up"></i> <span class="d-none d-sm-block">@lang('words.mng_eve.mng_eve_fea')</span> <span
                                                            class="label">{{ $currenEve }}</span></a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-10" role="tab"><i class="fas fa-arrow-alt-circle-right"></i> <span class="d-none d-sm-block">@lang('words.mng_eve.mng_eve_com')</span><span
                                                            class="label">{{ $futereve }}</span></a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-11" role="tab"><i class="fas fa-arrow-alt-circle-left"></i> <span class="d-none d-sm-block">@lang('words.mng_eve.mng_eve_past')</span> <span
                                                            class="label">{{ $pastevev }}</span></a></li>
                                        </ul>
                                    </div>
                                    <div class="card-block mb-5">
                                        <div class="tab-content">

                                            <!--Tab événement publiés-->
                                            <div class="tab-pane active" id="tab-7">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h4 class="mt-3 mb-4" align="center">@lang('words.mng_eve.mng_eve_pus')</h4>
                                                    </div>
                                                </div>
                                                @if(!empty($uEvents) && count($uEvents) > 0)
                                                <div class="row">
                                                    @foreach($uEvents as $event)
                                                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">

                                                        <div class="card mb-4">
                                                            <!--Badges-->
                                                            @if(Carbon\Carbon::today()->format('Y-m-d') == Carbon\Carbon::parse($event->event_start_datetime)->format('Y-m-d'))
                                                            <span class="badge badge-pill badge-primary label-float-l" style="background-color: #007bff; color:white">Aujourd'hui</span>
                                                            @elseif(Carbon\Carbon::today()->format('Y-m-d') < Carbon\Carbon::parse($event->event_start_datetime)->format('Y-m-d'))
                                                            <span class="badge badge-pill badge-warning label-float-l">@lang('words.mng_eve.mng_eve_fea')</span>
                                                            @else
                                                                <span class="badge badge-pill badge-warning label-float-l">@lang('words.mng_eve.mng_eve_past')</span>
                                                            @endif
                                                                @if($event->event_status == 1)
                                                                    <span class="badge badge-pill label-publish label-float-r">@lang('words.mng_eve.mng_eve_pus')</span>
                                                                @else
                                                                    <span class="badge badge-pill label-draft label-float-r">@lang('words.mng_eve.mng_eve_drf')</span>
                                                                @endif
                                                                @if($event->ban == 1)
                                                                    <span class="badge badge-pill label-ban label-float-r"><i
                                                                                class="fa fa-ban"></i> @lang('words.mng_eve.mng_eve_ban')</span>
                                                                @endif
                                                                        <!--Badges-->
                                                              <a href="{{ route('events.details',$event->event_slug) }}" target="_blank"><img class="card-img-top" src="{{ getImage($event->event_image, 'thumb') }}" alt="{{ $event->event_name }}"></a>
                                                            <div class="card-body text-center">
                                                                <h5 class="card-title">{{ $event->event_name }}</h5>
                                                                <p class="card-text mb-2">
                                                                    <small>
                                                                        <i class="far fa-clock"></i>
                                                                        {{ /*Carbon\Carbon::parse($event->event_start_datetime)->format('D, F j, Y')*/ ucwords(Jenssegers\Date\Date::parse($event->event_start_datetime)->format('l j F Y')) }}
                                                                        à
                                                                        {{ Carbon\Carbon::parse($event->event_start_datetime)->format('H:i') }}
                                                                    </small>

                                                                </p>
                                                                <a href="{{ route('events.dshaboard',$event->event_unique_id) }}" class="btn btn-primary btn-sm"><i
                                                                            class="fa fa-cog"></i> @lang('words.mng_eve.mng_eve_mng')</a>
                                                                <a href="{{ route('events.edit',$event->event_unique_id) }}" class="btn btn-primary btn-sm"><i
                                                                            class="fa fa-edit"></i> @lang('words.mng_eve.mng_eve_edt')</a>
                                                                <a href="{{ route('events.details',$event->event_slug) }}" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-eye"></i> @lang('words.mng_eve.mng_eve_vew')</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                        {{ $uEvents->render() }}
                                                </div>
                                                @else
                                                    <div class="eventbox-events">
                                                        <div class="eventbox">
                                                          <p class="wordwap" align="center">@lang('words.eve_not_fou')</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <!--./Tab événement publiés-->

                                            <!--Tab événement Brouillon-->
                                            <div class="tab-pane" id="tab-8">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h4 class="mt-3 mb-4" align="center">@lang('words.mng_eve.mng_eve_drf')</h4>
                                                    </div>
                                                </div>
                                                @if(!empty($draft) && count($draft) > 0)
                                                    <div class="row">
                                                        @foreach($draft as $event)
                                                            <div class="col-lg-3 col-md-4 col-sm-6 col-12">

                                                                <div class="card mb-4">
                                                                    <!--Badges-->
                                                                    @if(Carbon\Carbon::today()->format('Y-m-d') == Carbon\Carbon::parse($event->event_start_datetime)->format('Y-m-d'))
                                                                        <span class="badge badge-pill badge-primary label-float-l" style="background-color: #007bff; color:white">Aujourd'hui</span>
                                                                    @elseif(Carbon\Carbon::today()->format('Y-m-d') < Carbon\Carbon::parse($event->event_start_datetime)->format('Y-m-d'))
                                                                        <span class="badge badge-pill badge-warning label-float-l">@lang('words.mng_eve.mng_eve_fea')</span>
                                                                    @else
                                                                        <span class="badge badge-pill badge-warning label-float-l">@lang('words.mng_eve.mng_eve_past')</span>
                                                                    @endif
                                                                    @if($event->event_status == 1)
                                                                        <span class="badge badge-pill label-publish label-float-r">@lang('words.mng_eve.mng_eve_pus')</span>
                                                                    @else
                                                                        <span class="badge badge-pill label-draft label-float-r">@lang('words.mng_eve.mng_eve_drf')</span>
                                                                    @endif
                                                                    @if($event->ban == 1)
                                                                        <span class="badge badge-pill label-ban label-float-r"><i
                                                                                    class="fa fa-ban"></i> @lang('words.mng_eve.mng_eve_ban')</span>
                                                                        @endif
                                                                                <!--Badges-->
                                                                          <a href="{{ route('events.details',$event->event_slug) }}" target="_blank"><img class="card-img-top" src="{{ getImage($event->event_image, 'thumb') }}" alt="{{ $event->event_name }}"></a>
                                                                        <div class="card-body text-center">
                                                                            <h5 class="card-title">{{ $event->event_name }}</h5>
                                                                            <p class="card-text mb-2">
                                                                                <small>
                                                                                    <i class="far fa-clock"></i>
                                                                                {{ /*Carbon\Carbon::parse($event->event_start_datetime)->format('D, F j, Y')*/ ucwords(Jenssegers\Date\Date::parse($event->event_start_datetime)->format('l j F Y')) }}
                                                                                à
                                                                                {{ Carbon\Carbon::parse($event->event_start_datetime)->format('H:i') }}
                                                                                </small>
                                                                            </p>
                                                                            <a href="{{ route('events.dshaboard',$event->event_unique_id) }}" class="btn btn-primary btn-sm"><i
                                                                                        class="fa fa-cog"></i> @lang('words.mng_eve.mng_eve_mng')</a>
                                                                            <a href="{{ route('events.edit',$event->event_unique_id) }}" class="btn btn-primary btn-sm"><i
                                                                                        class="fa fa-edit"></i> @lang('words.mng_eve.mng_eve_edt')</a>
                                                                            <a href="{{ route('events.details',$event->event_slug) }}" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-eye"></i> @lang('words.mng_eve.mng_eve_vew')</a>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="eventbox-events">
                                                        <div class="eventbox">
                                                              <p class=" wordwap" align="center">@lang('words.eve_not_fou')</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <!--Tab événement Brouillon-->

                                         <!--Evenements actuels-->
                                            <div class="tab-pane" id="tab-9">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h4 class="mt-3 mb-4" align="center">@lang('words.mng_eve.mng_eve_fea')</h4>
                                                    </div>
                                                </div>
                                                @if(!empty($curentEven) && count($curentEven) > 0)
                                                    <div class="row">
                                                        @foreach($curentEven as $event)
                                                            <div class="col-lg-3 col-md-4 col-sm-6 col-12">

                                                                <div class="card mb-4">
                                                                    <!--Badges-->
                                                                    @if(Carbon\Carbon::today()->format('Y-m-d') == Carbon\Carbon::parse($event->event_start_datetime)->format('Y-m-d'))
                                                                        <span class="badge badge-pill badge-primary label-float-l" style="background-color: #007bff; color:white">Aujourd'hui</span>
                                                                    @elseif(Carbon\Carbon::today()->format('Y-m-d') < Carbon\Carbon::parse($event->event_start_datetime)->format('Y-m-d'))
                                                                        <span class="badge badge-pill badge-warning label-float-l">@lang('words.mng_eve.mng_eve_fea')</span>
                                                                    @else
                                                                        <span class="badge badge-pill badge-warning label-float-l">@lang('words.mng_eve.mng_eve_past')</span>
                                                                    @endif
                                                                    @if($event->event_status == 1)
                                                                        <span class="badge badge-pill label-publish label-float-r">@lang('words.mng_eve.mng_eve_pus')</span>
                                                                    @else
                                                                        <span class="badge badge-pill label-draft label-float-r">@lang('words.mng_eve.mng_eve_drf')</span>
                                                                    @endif
                                                                    @if($event->ban == 1)
                                                                        <span class="badge badge-pill label-ban label-float-r"><i
                                                                                    class="fa fa-ban"></i> @lang('words.mng_eve.mng_eve_ban')</span>
                                                                        @endif
                                                                                <!--Badges-->
                                                                        <a href="{{ route('events.details',$event->event_slug) }}" target="_blank">  <a href="{{ route('events.details',$event->event_slug) }}" target="_blank"><img class="card-img-top" src="{{ getImage($event->event_image, 'thumb') }}" alt="{{ $event->event_name }}"></a></a>
                                                                        <div class="card-body text-center">
                                                                            <h5 class="card-title">{{ $event->event_name }}</h5>
                                                                            <p class="card-text mb-2">
                                                                                <small>
                                                                                    <i class="far fa-clock"></i>
                                                                                {{ /*Carbon\Carbon::parse($event->event_start_datetime)->format('D, F j, Y')*/ucwords(Jenssegers\Date\Date::parse($event->event_start_datetime)->format('l j F Y')) }}
                                                                                à
                                                                                {{ Carbon\Carbon::parse($event->event_start_datetime)->format('H:i') }}
                                                                                </small>
                                                                            </p>
                                                                            <a href="{{ route('events.dshaboard',$event->event_unique_id) }}" class="btn btn-primary btn-sm"><i
                                                                                        class="fa fa-cog"></i> @lang('words.mng_eve.mng_eve_mng')</a>
                                                                            <a href="{{ route('events.edit',$event->event_unique_id) }}" class="btn btn-primary btn-sm"><i
                                                                                        class="fa fa-edit"></i> @lang('words.mng_eve.mng_eve_edt')</a>
                                                                            <a href="{{ route('events.details',$event->event_slug) }}" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-eye"></i> @lang('words.mng_eve.mng_eve_vew')</a>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="eventbox-events">
                                                        <div class="eventbox">
                                                              <p class=" wordwap" align="center">@lang('words.eve_not_fou')</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                         <!--Evenements actuels-->


                                            <!--Evenements Futurs-->
                                            <div class="tab-pane" id="tab-10">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h4 class="mt-3 mb-4" align="center">@lang('words.mng_eve.mng_eve_com')</h4>
                                                    </div>
                                                </div>
                                                @if(!empty($futerseve) && count($futerseve) > 0)
                                                    <div class="row">
                                                        @foreach($futerseve as $event)
                                                            <div class="col-lg-3 col-md-4 col-sm-6 col-12">

                                                                <div class="card mb-4">
                                                                    <!--Badges-->
                                                                    @if(Carbon\Carbon::today()->format('Y-m-d') == Carbon\Carbon::parse($event->event_start_datetime)->format('Y-m-d'))
                                                                        <span class="badge badge-pill badge-primary label-float-l" style="background-color: #007bff; color:white">Aujourd'hui</span>
                                                                    @elseif(Carbon\Carbon::today()->format('Y-m-d') < Carbon\Carbon::parse($event->event_start_datetime)->format('Y-m-d'))
                                                                        <span class="badge badge-pill badge-warning label-float-l">@lang('words.mng_eve.mng_eve_fea')</span>
                                                                    @else
                                                                        <span class="badge badge-pill badge-warning label-float-l">@lang('words.mng_eve.mng_eve_past')</span>
                                                                    @endif
                                                                    @if($event->event_status == 1)
                                                                        <span class="badge badge-pill label-publish label-float-r">@lang('words.mng_eve.mng_eve_pus')</span>
                                                                    @else
                                                                        <span class="badge badge-pill label-draft label-float-r">@lang('words.mng_eve.mng_eve_drf')</span>
                                                                    @endif
                                                                    @if($event->ban == 1)
                                                                        <span class="badge badge-pill label-ban label-float-r"><i
                                                                                    class="fa fa-ban"></i> @lang('words.mng_eve.mng_eve_ban')</span>
                                                                        @endif
                                                                                <!--Badges-->
                                                                          <a href="{{ route('events.details',$event->event_slug) }}" target="_blank"><img class="card-img-top" src="{{ getImage($event->event_image, 'thumb') }}" alt="{{ $event->event_name }}"></a>
                                                                        <div class="card-body text-center">
                                                                            <h5 class="card-title">{{ $event->event_name }}</h5>
                                                                            <p class="card-text mb-2">
                                                                                <small>
                                                                                    <i class="far fa-clock"></i>
                                                                                {{ /*Carbon\Carbon::parse($event->event_start_datetime)->format('D, F j, Y')*/ ucwords(Jenssegers\Date\Date::parse($event->event_start_datetime)->format('l j F Y'))}}
                                                                                at
                                                                                {{ Carbon\Carbon::parse($event->event_start_datetime)->format('H:i') }}
                                                                                </small>
                                                                            </p>
                                                                            <a href="{{ route('events.dshaboard',$event->event_unique_id) }}" class="btn btn-primary btn-sm"><i
                                                                                        class="fa fa-cog"></i> @lang('words.mng_eve.mng_eve_mng')</a>
                                                                            <a href="{{ route('events.edit',$event->event_unique_id) }}" class="btn btn-primary btn-sm"><i
                                                                                        class="fa fa-edit"></i> @lang('words.mng_eve.mng_eve_edt')</a>
                                                                            <a href="{{ route('events.details',$event->event_slug) }}" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-eye"></i> @lang('words.mng_eve.mng_eve_vew')</a>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="eventbox-events">
                                                        <div class="eventbox">
                                                              <p class=" wordwap" align="center">@lang('words.eve_not_fou')</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <!--Evenements Futurs-->

                                            <!--Evenements passés-->
                                            <div class="tab-pane" id="tab-11">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h4 class="mt-3 mb-4" align="center">@lang('words.mng_eve.mng_eve_past')</h4>
                                                    </div>
                                                </div>
                                                @if(!empty($pastevents) && count($pastevents) > 0)
                                                    <div class="row">
                                                        @foreach($pastevents as $event)
                                                            <div class="col-lg-3 col-md-4 col-sm-6 col-12">

                                                                <div class="card mb-4">
                                                                    <!--Badges-->
                                                                    @if(Carbon\Carbon::today()->format('Y-m-d') == Carbon\Carbon::parse($event->event_start_datetime)->format('Y-m-d'))
                                                                        <span class="badge badge-pill badge-primary label-float-l" style="background-color: #007bff; color:white">Aujourd'hui</span>
                                                                    @elseif(Carbon\Carbon::today()->format('Y-m-d') < Carbon\Carbon::parse($event->event_start_datetime)->format('Y-m-d'))
                                                                        <span class="badge badge-pill badge-warning label-float-l">@lang('words.mng_eve.mng_eve_fea')</span>
                                                                    @else
                                                                        <span class="badge badge-pill badge-warning label-float-l">@lang('words.mng_eve.mng_eve_past')</span>
                                                                    @endif
                                                                    @if($event->event_status == 1)
                                                                        <span class="badge badge-pill label-publish label-float-r">@lang('words.mng_eve.mng_eve_pus')</span>
                                                                    @else
                                                                        <span class="badge badge-pill label-draft label-float-r">@lang('words.mng_eve.mng_eve_drf')</span>
                                                                    @endif
                                                                    @if($event->ban == 1)
                                                                        <span class="badge badge-pill label-ban label-float-r"><i
                                                                                    class="fa fa-ban"></i> @lang('words.mng_eve.mng_eve_ban')</span>
                                                                        @endif
                                                                                <!--Badges-->
                                                                          <a href="{{ route('events.details',$event->event_slug) }}" target="_blank"><img class="card-img-top" src="{{ getImage($event->event_image, 'thumb') }}" alt="{{ $event->event_name }}"></a>
                                                                        <div class="card-body text-center">
                                                                            <h5 class="card-title">{{ $event->event_name }}</h5>
                                                                            <p class="card-text mb-2">
                                                                                <small>
                                                                                    <i class="far fa-clock"></i>
                                                                                {{ /*Carbon\Carbon::parse($event->event_start_datetime)->format('D, F j, Y')*/  ucwords(Jenssegers\Date\Date::parse($event->event_start_datetime)->format('l j F Y')) }}
                                                                                at
                                                                                {{ Carbon\Carbon::parse($event->event_start_datetime)->format('H:i') }}
                                                                                </small>
                                                                            </p>
                                                                            <a href="{{ route('events.dshaboard',$event->event_unique_id) }}" class="btn btn-primary btn-sm"><i
                                                                                        class="fa fa-cog"></i> @lang('words.mng_eve.mng_eve_mng')</a>
                                                                            <a href="{{ route('events.edit',$event->event_unique_id) }}" class="btn btn-primary btn-sm"><i
                                                                                        class="fa fa-edit"></i> @lang('words.mng_eve.mng_eve_edt')</a>
                                                                            <a href="{{ route('events.details',$event->event_slug) }}" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-eye"></i> @lang('words.mng_eve.mng_eve_vew')</a>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="eventbox-events">
                                                        <div class="eventbox">
                                                              <p class=" wordwap" align="center">@lang('words.eve_not_fou')</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <!--Evenements passés-->



                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <!--Horizontal Tabs Events list -->

                    {{--<div class="row">--}}
                        {{--<div class="col-lg-3 col-md-4 col-sm-12">--}}
                            {{--<div class="event-sidebar margin-top">--}}
                                {{--<ul class="nav nav-tabs" role="tablist">--}}
                                    {{--<li class="nav-item"><a class="nav-link active" href="#publish" role="tab"--}}
                                                            {{--data-toggle="tab">@lang('words.mng_tab.mng_tab_1') <span--}}
                                                    {{--class="label">{{ $totalcount }}</span></a></li>--}}
                                    {{--<li class="nav-item"><a class="nav-link" href="#draft" role="tab"--}}
                                                            {{--data-toggle="tab">@lang('words.mng_tab.mng_tab_2') <span--}}
                                                    {{--class="label">{{ $darftCount }}</span></a></li>--}}
                                    {{--<li class="nav-item"><a class="nav-link" href="#current" role="tab"--}}
                                                            {{--data-toggle="tab">@lang('words.mng_tab.mng_tab_3') <span--}}
                                                    {{--class="label">{{ $currenEve }}</span></a></li>--}}
                                    {{--<li class="nav-item"><a class="nav-link" href="#feature" role="tab"--}}
                                                            {{--data-toggle="tab">@lang('words.mng_tab.mng_tab_4') <span--}}
                                                    {{--class="label">{{ $futereve }}</span></a></li>--}}
                                    {{--<li class="nav-item"><a class="nav-link" href="#past" role="tab"--}}
                                                            {{--data-toggle="tab">@lang('words.mng_tab.mng_tab_5') <span--}}
                                                    {{--class="label">{{ $pastevev }}</span></a></li>--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-lg-9 col-md-8 col-sm-12">--}}
                            {{--<div class="tab-content">--}}
                                {{--<div role="tabpanel" class="tab-pane fade in active" id="publish">--}}
                                    {{--<div class="eventbox-main">--}}
                                        {{--<div class="eventbox-header">--}}
                                            {{--<h2>@lang('words.mng_eve.mng_eve_list')</h2>--}}
                                        {{--</div>--}}
                                        {{--@if(!empty($uEvents) && count($uEvents) > 0)--}}
                                            {{--<div class="eventbox-events">--}}
                                                {{--@foreach($uEvents as $event)--}}
                                                    {{--<div class="eventbox">--}}
                                                        {{--<h3 class="event-title wordwap">{{ $event->event_name }}</h3>--}}

                                                        {{--<p class="event-time">--}}
                                                            {{--{{ Carbon\Carbon::parse($event->event_start_datetime)->format('D, F j, Y') }}--}}
                                                            {{--at--}}
                                                            {{--{{ Carbon\Carbon::parse($event->event_start_datetime)->format('h:i:A') }}--}}
                                                        {{--</p>--}}

                                                        {{--<div class="event-link">--}}
                                                            {{--<a href="{{ route('events.dshaboard',$event->event_unique_id) }}"><i--}}
                                                                        {{--class="fa fa-cog"></i> @lang('words.mng_eve.mng_eve_mng')--}}
                                                            {{--</a>--}}
                                                            {{--<a href="{{ route('events.edit',$event->event_unique_id) }}"><i--}}
                                                                        {{--class="fa fa-edit"></i> @lang('words.mng_eve.mng_eve_edt')--}}
                                                            {{--</a>--}}
                                                            {{--<a href="{{ route('events.details',$event->event_slug) }}"><i--}}
                                                                        {{--class="fa fa-eye"></i> @lang('words.mng_eve.mng_eve_vew')--}}
                                                            {{--</a>--}}
                                                            {{--<a href="{{ route('events.refund',[$event->event_unique_id,'pending']) }}"><i--}}
                                                                        {{--class="fa fa-cog"></i> Remboursement</a>--}}
                                                        {{--</div>--}}
                                                        {{--<div class="event-label">--}}
                                                            {{--@if(Carbon\Carbon::today()->format('Y-m-d') == Carbon\Carbon::parse($event->event_start_datetime)->format('Y-m-d'))--}}
                                                                {{--<label class="event-label label-status">Today</label>--}}
                                                            {{--@elseif(Carbon\Carbon::today()->format('Y-m-d') < Carbon\Carbon::parse($event->event_start_datetime)->format('Y-m-d'))--}}
                                                                {{--<label class="event-label label-status">@lang('words.mng_eve.mng_eve_fea')</label>--}}
                                                            {{--@else--}}
                                                                {{--<label class="event-label label-status">@lang('words.mng_eve.mng_eve_past')</label>--}}
                                                            {{--@endif--}}
                                                            {{--@if($event->event_status == 1)--}}
                                                                {{--<label class="event-label label-publish">@lang('words.mng_eve.mng_eve_pus')</label>--}}
                                                            {{--@else--}}
                                                                {{--<label class="event-label label-draft">@lang('words.mng_eve.mng_eve_drf')</label>--}}
                                                            {{--@endif--}}
                                                            {{--@if($event->ban == 1)--}}
                                                                {{--<label class="event-label label-ban"><i--}}
                                                                            {{--class="fa fa-ban"></i>&nbsp;&nbsp; @lang('words.mng_eve.mng_eve_ban')--}}
                                                                {{--</label>--}}
                                                            {{--@endif--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--@endforeach--}}
                                                {{--{{ $uEvents->render() }}--}}
                                            {{--</div>--}}
                                        {{--@else--}}
                                            {{--<div class="eventbox-events">--}}
                                                {{--<div class="eventbox">--}}
                                                    {{--<h3 class="event-title wordwap">@lang('words.eve_not_fou')</h3>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div role="tabpanel" class="tab-pane fade" id="draft">--}}
                                    {{--<div class="eventbox-main">--}}
                                        {{--<div class="eventbox-header">--}}
                                            {{--<h2>@lang('words.mng_tab.mng_tab_2')</h2>--}}
                                        {{--</div>--}}
                                        {{--@if(!empty($draft) && count($draft) > 0)--}}
                                            {{--<div class="eventbox-events">--}}
                                                {{--@foreach($draft as $event)--}}
                                                    {{--<div class="eventbox">--}}
                                                        {{--<h3 class="event-title wordwap">{{ $event->event_name }}</h3>--}}

                                                        {{--<p class="event-time">--}}
                                                            {{--{{ Carbon\Carbon::parse($event->event_start_datetime)->format('D, F j, Y') }}--}}
                                                            {{--at--}}
                                                            {{--{{ Carbon\Carbon::parse($event->event_start_datetime)->format('h:i:A') }}--}}
                                                        {{--</p>--}}

                                                        {{--<div class="event-link">--}}
                                                            {{--<a href="{{ route('events.dshaboard',$event->event_unique_id) }}"><i--}}
                                                                        {{--class="fa fa-cog"></i> @lang('words.mng_eve.mng_eve_mng')</a>--}}
                                                            {{--<a href="{{ route('events.edit',$event->event_unique_id) }}"><i--}}
                                                                        {{--class="fa fa-edit"></i> @lang('words.mng_eve.mng_eve_edt')</a>--}}
                                                            {{--<a href="{{ route('events.details',$event->event_slug) }}"><i--}}
                                                                        {{--class="fa fa-eye"></i> @lang('words.mng_eve.mng_eve_vew')</a>--}}
                                                        {{--</div>--}}
                                                        {{--<div class="event-label">--}}
                                                            {{--@if(Carbon\Carbon::today()->format('Y-m-d') == Carbon\Carbon::parse($event->event_start_datetime)->format('Y-m-d'))--}}
                                                                {{--<label class="event-label label-status">Today</label>--}}
                                                            {{--@elseif(Carbon\Carbon::today()->format('Y-m-d') < Carbon\Carbon::parse($event->event_start_datetime)->format('Y-m-d'))--}}
                                                                {{--<label class="event-label label-status">@lang('words.mng_eve.mng_eve_fea')</label>--}}
                                                            {{--@else--}}
                                                                {{--<label class="event-label label-status">@lang('words.mng_eve.mng_eve_past')</label>--}}
                                                            {{--@endif--}}
                                                            {{--@if($event->event_status == 1)--}}
                                                                {{--<label class="event-label label-publish">@lang('words.mng_eve.mng_eve_pus')</label>--}}
                                                            {{--@else--}}
                                                                {{--<label class="event-label label-draft">@lang('words.mng_eve.mng_eve_drf')</label>--}}
                                                            {{--@endif--}}
                                                            {{--@if($event->ban == 1)--}}
                                                                {{--<label class="event-label label-ban"><i--}}
                                                                            {{--class="fa fa-ban"></i>&nbsp;&nbsp; @lang('words.mng_eve.mng_eve_ban')--}}
                                                                {{--</label>--}}
                                                            {{--@endif--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--@endforeach--}}
                                            {{--</div>--}}
                                        {{--@else--}}
                                            {{--<div class="eventbox-events">--}}
                                                {{--<div class="eventbox">--}}
                                                    {{--<h3 class="event-title wordwap">@lang('words.eve_not_fou')</h3>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div role="tabpanel" class="tab-pane fade" id="current">--}}
                                    {{--<div class="eventbox-main">--}}
                                        {{--<div class="eventbox-header">--}}
                                            {{--<h2>@lang('words.mng_tab.mng_tab_3')</h2>--}}
                                        {{--</div>--}}
                                        {{--@if(!empty($curentEven) && count($curentEven) > 0)--}}
                                            {{--<div class="eventbox-events">--}}
                                                {{--@foreach($curentEven as $event)--}}
                                                    {{--<div class="eventbox">--}}
                                                        {{--<h3 class="event-title wordwap">{{ $event->event_name }}</h3>--}}

                                                        {{--<p class="event-time">--}}
                                                            {{--{{ Carbon\Carbon::parse($event->event_start_datetime)->format('D, F j, Y') }}--}}
                                                            {{--at--}}
                                                            {{--{{ Carbon\Carbon::parse($event->event_start_datetime)->format('h:i:A') }}--}}
                                                        {{--</p>--}}

                                                        {{--<div class="event-link">--}}
                                                            {{--<a href="{{ route('events.dshaboard',$event->event_unique_id) }}"><i--}}
                                                                        {{--class="fa fa-cog"></i> @lang('words.mng_eve.mng_eve_mng')</a>--}}
                                                            {{--<a href="{{ route('events.edit',$event->event_unique_id) }}"><i--}}
                                                                        {{--class="fa fa-edit"></i> @lang('words.mng_eve.mng_eve_edt')</a>--}}
                                                            {{--<a href="{{ route('events.details',$event->event_slug) }}"><i--}}
                                                                        {{--class="fa fa-eye"></i> @lang('words.mng_eve.mng_eve_vew')</a>--}}
                                                        {{--</div>--}}
                                                        {{--<div class="event-label">--}}
                                                            {{--@if(Carbon\Carbon::today()->format('Y-m-d') == Carbon\Carbon::parse($event->event_start_datetime)->format('Y-m-d'))--}}
                                                                {{--<label class="event-label label-status">Today</label>--}}
                                                            {{--@elseif(Carbon\Carbon::today()->format('Y-m-d') < Carbon\Carbon::parse($event->event_start_datetime)->format('Y-m-d'))--}}
                                                                {{--<label class="event-label label-status">@lang('words.mng_eve.mng_eve_fea')</label>--}}
                                                            {{--@else--}}
                                                                {{--<label class="event-label label-status">@lang('words.mng_eve.mng_eve_past')</label>--}}
                                                            {{--@endif--}}
                                                            {{--@if($event->event_status == 1)--}}
                                                                {{--<label class="event-label label-publish">@lang('words.mng_eve.mng_eve_pus')</label>--}}
                                                            {{--@else--}}
                                                                {{--<label class="event-label label-draft">@lang('words.mng_eve.mng_eve_drf')</label>--}}
                                                            {{--@endif--}}
                                                            {{--@if($event->ban == 1)--}}
                                                                {{--<label class="event-label label-ban"><i--}}
                                                                            {{--class="fa fa-ban"></i>&nbsp;&nbsp; @lang('words.mng_eve.mng_eve_ban')--}}
                                                                {{--</label>--}}
                                                            {{--@endif--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--@endforeach--}}
                                            {{--</div>--}}
                                        {{--@else--}}
                                            {{--<div class="eventbox-events">--}}
                                                {{--<div class="eventbox">--}}
                                                    {{--<h3 class="event-title wordwap">@lang('words.eve_not_fou')</h3>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div role="tabpanel" class="tab-pane fade" id="feature">--}}
                                    {{--<div class="eventbox-main">--}}
                                        {{--<div class="eventbox-header">--}}
                                            {{--<h2>@lang('words.mng_tab.mng_tab_4')</h2>--}}
                                        {{--</div>--}}
                                        {{--@if(!empty($futerseve) && count($futerseve) > 0)--}}
                                            {{--<div class="eventbox-events">--}}
                                                {{--@foreach($futerseve as $event)--}}
                                                    {{--<div class="eventbox">--}}
                                                        {{--<h3 class="event-title wordwap">{{ $event->event_name }}</h3>--}}

                                                        {{--<p class="event-time">--}}
                                                            {{--{{ Carbon\Carbon::parse($event->event_start_datetime)->format('D, F j, Y') }}--}}
                                                            {{--at--}}
                                                            {{--{{ Carbon\Carbon::parse($event->event_start_datetime)->format('h:i:A') }}--}}
                                                        {{--</p>--}}

                                                        {{--<div class="event-link">--}}
                                                            {{--<a href="{{ route('events.dshaboard',$event->event_unique_id) }}"><i--}}
                                                                        {{--class="fa fa-cog"></i> @lang('words.mng_eve.mng_eve_mng')</a>--}}
                                                            {{--<a href="{{ route('events.edit',$event->event_unique_id) }}"><i--}}
                                                                        {{--class="fa fa-edit"></i> @lang('words.mng_eve.mng_eve_edt')</a>--}}
                                                            {{--<a href="{{ route('events.details',$event->event_slug) }}"><i--}}
                                                                        {{--class="fa fa-eye"></i> @lang('words.mng_eve.mng_eve_vew')</a>--}}
                                                        {{--</div>--}}
                                                        {{--<div class="event-label">--}}
                                                            {{--@if(Carbon\Carbon::today()->format('Y-m-d') == Carbon\Carbon::parse($event->event_start_datetime)->format('Y-m-d'))--}}
                                                                {{--<label class="event-label label-status">Today</label>--}}
                                                            {{--@elseif(Carbon\Carbon::today()->format('Y-m-d') < Carbon\Carbon::parse($event->event_start_datetime)->format('Y-m-d'))--}}
                                                                {{--<label class="event-label label-status">@lang('words.mng_eve.mng_eve_fea')</label>--}}
                                                            {{--@else--}}
                                                                {{--<label class="event-label label-status">@lang('words.mng_eve.mng_eve_past')</label>--}}
                                                            {{--@endif--}}
                                                            {{--@if($event->event_status == 1)--}}
                                                                {{--<label class="event-label label-publish">@lang('words.mng_eve.mng_eve_pus')</label>--}}
                                                            {{--@else--}}
                                                                {{--<label class="event-label label-draft">@lang('words.mng_eve.mng_eve_drf')</label>--}}
                                                            {{--@endif--}}
                                                            {{--@if($event->ban == 1)--}}
                                                                {{--<label class="event-label label-ban"><i--}}
                                                                            {{--class="fa fa-ban"></i>&nbsp;&nbsp; @lang('words.mng_eve.mng_eve_ban')--}}
                                                                {{--</label>--}}
                                                            {{--@endif--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--@endforeach--}}
                                            {{--</div>--}}
                                        {{--@else--}}
                                            {{--<div class="eventbox-events">--}}
                                                {{--<div class="eventbox">--}}
                                                    {{--<h3 class="event-title wordwap">@lang('words.eve_not_fou')</h3>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div role="tabpanel" class="tab-pane fade" id="past">--}}
                                    {{--<div class="eventbox-main">--}}
                                        {{--<div class="eventbox-header">--}}
                                            {{--<h2>@lang('words.mng_tab.mng_tab_5')</h2>--}}
                                        {{--</div>--}}
                                        {{--@if(!empty($pastevents) && count($pastevents) > 0)--}}
                                            {{--<div class="eventbox-events">--}}
                                                {{--@foreach($pastevents as $event)--}}
                                                    {{--<div class="eventbox">--}}
                                                        {{--<h3 class="event-title wordwap">{{ $event->event_name }}</h3>--}}

                                                        {{--<p class="event-time">--}}
                                                            {{--{{ Carbon\Carbon::parse($event->event_start_datetime)->format('D, F j, Y') }}--}}
                                                            {{--at--}}
                                                            {{--{{ Carbon\Carbon::parse($event->event_start_datetime)->format('h:i:A') }}--}}
                                                        {{--</p>--}}

                                                        {{--<div class="event-link">--}}
                                                            {{--<a href="{{ route('events.dshaboard',$event->event_unique_id) }}"><i--}}
                                                                        {{--class="fa fa-cog"></i> @lang('words.mng_eve.mng_eve_mng')</a>--}}
                                                            {{--<a href="{{ route('events.edit',$event->event_unique_id) }}"><i--}}
                                                                        {{--class="fa fa-edit"></i> @lang('words.mng_eve.mng_eve_edt')</a>--}}
                                                            {{--<a href="{{ route('events.details',$event->event_slug) }}"><i--}}
                                                                        {{--class="fa fa-eye"></i> @lang('words.mng_eve.mng_eve_vew')</a>--}}
                                                        {{--</div>--}}
                                                        {{--<div class="event-label">--}}
                                                            {{--@if(Carbon\Carbon::today()->format('Y-m-d') == Carbon\Carbon::parse($event->event_start_datetime)->format('Y-m-d'))--}}
                                                                {{--<label class="event-label label-status">Today</label>--}}
                                                            {{--@elseif(Carbon\Carbon::today()->format('Y-m-d') < Carbon\Carbon::parse($event->event_start_datetime)->format('Y-m-d'))--}}
                                                                {{--<label class="event-label label-status">@lang('words.mng_eve.mng_eve_fea')</label>--}}
                                                            {{--@else--}}
                                                                {{--<label class="event-label label-status">@lang('words.mng_eve.mng_eve_past')</label>--}}
                                                            {{--@endif--}}
                                                            {{--@if($event->event_status == 1)--}}
                                                                {{--<label class="event-label label-publish">@lang('words.mng_eve.mng_eve_pus')</label>--}}
                                                            {{--@else--}}
                                                                {{--<label class="event-label label-draft">@lang('words.mng_eve.mng_eve_drf')</label>--}}
                                                            {{--@endif--}}
                                                            {{--@if($event->ban == 1)--}}
                                                                {{--<label class="event-label label-ban"><i--}}
                                                                            {{--class="fa fa-ban"></i>&nbsp;&nbsp; @lang('words.mng_eve.mng_eve_ban')--}}
                                                                {{--</label>--}}
                                                            {{--@endif--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--@endforeach--}}
                                            {{--</div>--}}
                                        {{--@else--}}
                                            {{--<div class="eventbox-events">--}}
                                                {{--<div class="eventbox">--}}
                                                    {{--<h3 class="event-title wordwap">@lang('words.eve_not_fou')</h3>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>


        </div>
    </div>
    </div>
@endsection
@section('pageScript')
@endsection