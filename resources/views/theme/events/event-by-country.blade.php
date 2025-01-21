@extends($theme)
@inject(eventsData,'App\Event')
@inject(countries,'App\PaysList')
@inject(eventCat,'App\EventCategory')
@section('meta_title',setMetaData()->e_list_country_title.$pays)
@section('meta_description',setMetaData()->e_list_country_desc)
@section('meta_keywords',setMetaData()->e_list_country_keyword)
@section('content')

    <div class="list-bg page-title-special event-list">
        <h2 align="center">
            <strong> Événements en </strong>
        </h2>
    </div>
    @include("theme.events.event-mobile-search")
    <div class="container list-widget bg-effect">
        <div class="row mt-md-5 mt-sm-4 mt-4">
            @php $pays = ucwords(str_replace('_',' ', $pays)) @endphp
                @foreach($eventsData->getEventByCountry($pays) as $data)
                    @include('theme.events.event-unique-list')
                    {{--<div class="col-lg-4 col-md-6 col-sm-12 hover">
                        <div class="box" style="position: relative;">
                            <a href="{{ route('events.details',$event->event_slug) }}"><img
                                        src="{{ getImage($event->event_image, 'thumb') }}"
                                        alt="{{ $event->event_name }}"/></a>

                            <div class="box-content card__padding">
                                <h4 class="card-title"><a
                                            href="{{ route('events.details',$event->event_slug) }}">{{ $event->event_name }}</a>
                                </h4>

                                <div class="badge category" style="cursor: default">
							  <span class="">
								  {{ $event->this_event_category }}
							  </span>
                                </div>
                                <div class="badge prix f-right">
                                    <a href="{{ route('events.details',$event->event_slug) }}" class=""><span class="">
                    					@if($event->event_min_price == 0)
                                                FREE
                                            @else
                                                {!! use_currency()->symbol !!} {!! number_format($event->event_min_price, 0, "."," ") !!}
                                            @endif
                                            @if($event->event_min_price != $event->event_max_price)
                                                - {!! use_currency()->symbol !!} {!! number_format($event->event_max_price, 0, "."," ") !!}
                                            @endif
                 			 </span></a>
                                </div>
                                @php
                                /*$startdate = Carbon\Carbon::parse($event->event_start_datetime)->format('D j F Y');
                                $enddate = Carbon\Carbon::parse($event->event_end_datetime)->format('D, F j, Y');
                                $starttime = Carbon\Carbon::parse($event->event_start_datetime)->format('h:i A');
                                $endtime = Carbon\Carbon::parse($event->event_end_datetime)->format('h:i A');*/
                                Jenssegers\Date\Date::setLocale('fr');
                                $startdate 	= ucwords(Jenssegers\Date\Date::parse($event->event_start_datetime)->format('l j F Y'));
                                $enddate 	= ucwords(Jenssegers\Date\Date::parse($event->event_end_datetime)->format('l j F Y'));
                                $starttime	= Carbon\Carbon::parse($event->event_start_datetime)->format('H:i');
                                $endtime	= Carbon\Carbon::parse($event->event_end_datetime)->format('H:i');
                                @endphp
                                <div class="card__action">
								<span class="date-times bold third-color">
    								<i class="far fa-clock secondary-color"></i>
                                    @if($startdate == $enddate)
                                        {{ $startdate }} from {{ $starttime }} to {{ $endtime }}
                                    @else
                                        {{ $startdate }} at {{ $starttime }} -  {{ $enddate }} at {{ $endtime }}
                                    @endif
                                    <span class="bold"></span>
								</span>

                                    <div class="card__location">
                                        <div class="card__location-content">
                                            <i class="fas fa-map-marker-alt primary-color"></i>
                                            <a href="" rel="tag"
                                               class="third-color bold"> {{ $event->event_location }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-icon pull-right like-listing" id="userlike-{{$event->event_unique_id}}">
                                    @if(auth()->guard('frontuser')->check())
                                        @php $userid = auth()->guard('frontuser')->user()->id  @endphp
                                    @else
                                        @php $userid = ''  @endphp
                                    @endif
                                    <a href="javascript:void(0)" data-toggle="tooltip"
                                       data-original-title="@lang('words.events_box_tooltip.save_tooltip')"
                                       data-placement="right" id="save-event" class="save-event" data-user="{{$userid}}"
                                       data-event="{{ $event->event_unique_id }}" data-mark="0">
                                        @if(is_null(getbookmark($event->event_unique_id, $userid)))
                                            <i class="far fa-heart"></i>
                                        @else
                                            <i class="fas fa-heart"></i>
                                        @endif
                                    </a>
                                    <!-- <i class="fa fa-bookmark-o"><a href="#"></a></i> -->
                                </div>
                                <div class="box-icon pull-right share-listing">
                                    <a href="javascript:void()" data-toggle="tooltip"
                                       data-original-title="@lang('words.events_box_tooltip.share_tooltip')"
                                       data-placement="right" class="event-share"
                                       data-url="{{route('events.details',$event->event_slug)}}"
                                       data-name="{{ $event->event_name }}" data-loca="{{ $event->event_location }}">
                                        <i class="fas fa-share"></i>
                                    </a>
                                </div>
                                <div style="clear:both;"></div>
                            </div>
                        </div>
                    </div>--}}
                @endforeach
                {{--@foreach($events as $event)
                    <div class="col-lg-4 col-md-6 col-sm-12 hover">
                        <div class="box" style="position: relative;">
                            <a href="{{ route('events.details',$event->event_slug) }}"><img
                                        src="{{ getImage($event->event_image, 'thumb') }}"
                                        alt="{{ $event->event_name }}"/></a>

                            <div class="box-content card__padding">
                                <h4 class="card-title"><a
                                            href="{{ route('events.details',$event->event_slug) }}">{{ $event->event_name }}</a>
                                </h4>

                                <div class="badge category" style="cursor: default">
							  <span class="">
								  {{ $event->this_event_category }}
							  </span>
                                </div>
                                <div class="badge prix f-right">
                                    <a href="{{ route('events.details',$event->event_slug) }}" class=""><span class="">
                    					@if($event->event_min_price == 0)
                                                FREE
                                            @else
                                                {!! use_currency()->symbol !!} {!! number_format($event->event_min_price, 0, "."," ") !!}
                                            @endif
                                            @if($event->event_min_price != $event->event_max_price)
                                                - {!! use_currency()->symbol !!} {!! number_format($event->event_max_price, 0, "."," ") !!}
                                            @endif
                 			 </span></a>
                                </div>
                                @php
                                /*$startdate = Carbon\Carbon::parse($event->event_start_datetime)->format('D j F Y');
                                $enddate = Carbon\Carbon::parse($event->event_end_datetime)->format('D, F j, Y');
                                $starttime = Carbon\Carbon::parse($event->event_start_datetime)->format('h:i A');
                                $endtime = Carbon\Carbon::parse($event->event_end_datetime)->format('h:i A');*/
                                Jenssegers\Date\Date::setLocale('fr');
                                $startdate 	= ucwords(Jenssegers\Date\Date::parse($event->event_start_datetime)->format('l j F Y'));
                                $enddate 	= ucwords(Jenssegers\Date\Date::parse($event->event_end_datetime)->format('l j F Y'));
                                $starttime	= Carbon\Carbon::parse($event->event_start_datetime)->format('H:i');
                                $endtime	= Carbon\Carbon::parse($event->event_end_datetime)->format('H:i');
                                @endphp
                                <div class="card__action">
								<span class="date-times bold third-color">
    								<i class="far fa-clock secondary-color"></i>
                                    @if($startdate == $enddate)
                                        {{ $startdate }} from {{ $starttime }} to {{ $endtime }}
                                    @else
                                        {{ $startdate }} at {{ $starttime }} -  {{ $enddate }} at {{ $endtime }}
                                    @endif
                                    <span class="bold"></span>
								</span>

                                    <div class="card__location">
                                        <div class="card__location-content">
                                            <i class="fas fa-map-marker-alt primary-color"></i>
                                            <a href="" rel="tag"
                                               class="third-color bold"> {{ $event->event_location }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-icon pull-right like-listing" id="userlike-{{$event->event_unique_id}}">
                                    @if(auth()->guard('frontuser')->check())
                                        @php $userid = auth()->guard('frontuser')->user()->id  @endphp
                                    @else
                                        @php $userid = ''  @endphp
                                    @endif
                                    <a href="javascript:void(0)" data-toggle="tooltip"
                                       data-original-title="@lang('words.events_box_tooltip.save_tooltip')"
                                       data-placement="right" id="save-event" class="save-event" data-user="{{$userid}}"
                                       data-event="{{ $event->event_unique_id }}" data-mark="0">
                                        @if(is_null(getbookmark($event->event_unique_id, $userid)))
                                            <i class="far fa-heart"></i>
                                        @else
                                            <i class="fas fa-heart"></i>
                                        @endif
                                    </a>
                                    <!-- <i class="fa fa-bookmark-o"><a href="#"></a></i> -->
                                </div>
                                <div class="box-icon pull-right share-listing">
                                    <a href="javascript:void()" data-toggle="tooltip"
                                       data-original-title="@lang('words.events_box_tooltip.share_tooltip')"
                                       data-placement="right" class="event-share"
                                       data-url="{{route('events.details',$event->event_slug)}}"
                                       data-name="{{ $event->event_name }}" data-loca="{{ $event->event_location }}">
                                        <i class="fas fa-share"></i>
                                    </a>
                                </div>
                                <div style="clear:both;"></div>
                            </div>
                        </div>
                    </div>
                @endforeach--}}
        </div>
        {{--@if(isset($date1) && isset($date2))
            <div> {{ $date1.'  '.$date2 }}  </div> @endif
--}}
        <div class="row">
            <div class="col-md-12 col-xs-12 col-lg-8 col-sm-12 text-center">
                {!! $events->render() !!}
            </div>
        </div>

    </div>
    <!--call to action creation événements-->
    <section class="secondary-bg  newsletter-bloc text-center">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="mb5 inline-block p0-xs">Vous ne savez pas par où commencer ? </h3>
                    <br>
                    <a class="btn btn-filled mb0" href="{{ route('events.create') }}"> <i class="ti-plus">&nbsp;</i> @lang('words.user_menus.usr_mnu_log_3')</a>

                </div>
            </div>

        </div>

    </section>
    <!--call to action creation événements-->
    <!--txt s-e-o-->
    <section class="texte-paragraphs" style=" font-size: 14px;  line-height: 20px; text-align: justify">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p><span style="font-weight: 400;">Chaque jour, les organisateurs de spectacles mettent en ligne des <strong><a
                                        href="https://myplace-events.com/evenement/">événements</a> </strong>près de chez vous. Organisateurs ou spectateurs, chacun en tire un meilleur profit grâce à My place Events. La billetterie en ligne My Place Events, permet aux organisateurs de mieux gérer leurs événements. <strong>Le
                                site de vente de tickets en ligne</strong> donne l’occasion aux prestataires événementiels de contrôler la vente des billets et de faire une meilleure promotion. Quant aux spectateurs ils peuvent peuvent acheter leurs tickets de spectacles quelques jours avant sans se déplacer. Mais le plus est que sur le site My Place Events, vous retrouverez les événements qui vous siéent. Pour les férus de mode, retrouvez les défilés qui vous mettront toujours à la mode du jour, pour les mélomanes, les dernières sorties musicaux, les concerts sont sur My Place Events. Pour les plus studieux, des programmes de formation vous y attendent aussi. </span>
                    </p>

                    <p><span style="font-weight: 400;"><strong><a href="https://myplace-events.com/evenement/">Événements
                                    partout en Afrique francophone</a></strong> pour les fans de musique, football, exposition, mode, My Place Events est votre plate forme. Vous trouverez des endroits ou des idées géniaux pour vos envies sur notre site web de vente de ticket en ligne. </span>
                    </p>

                </div>
            </div>
        </div>
    </section>
    <!--txt s-e-o-->
@endsection

@section('pageScript')


    <script type="text/javascript">
        $(document).ready(function () {
            $('#home-search-form input[type="submit"]').on('click', function() {
                var i = 0;
                var selectEnfants = $('#home-search-form select[name="event_country"]').children();
                var selectNombreEnfant = selectEnfants.length;
            });

            $('#forDateContent').hide()
            $('#forDate').on('mousedown', function () {
                $('#forDateContent').toggle();
            });

            $('#forDateContent a').on('click', function () {
                var inputValue = $(this).text();
                $('#forDate').val(inputValue);
                $('#forDate').val().replace(' ', '');

                if ($('#forDate').val() == $('#forDateContent li:last').text()) {
                    $('#forDate').val('cdate');
                }
            });

            $('#custom_date').on('click', function () {
                $("#forDateContent li:last").toggle();
            });

            var div_cliquable = $('#forDate');
            $(document.body).click(function (e) {
                // Si ce n'est pas #ma_div ni un de ses enfants
                if (!$(e.target).is(div_cliquable) && !$.contains(div_cliquable[0], e.target) && !$(e.target).is($('#forDateContent')) && !$.contains($('#forDateContent')[0], e.target)) {
                    $('#forDateContent').hide(); // masque #ma_div en fondu
                }
            });

            /*var emptyDateF = $('#list-search-form input #forDate').val();
            var emptyDateD = $('#list-search-form input #forDate').val();
            $('#list-search-form input[type="submit"]').on('click', function () {
                if ((emptyDateF).empty() && !emptyDateD.empty()) {
                    $('#list-search-form input #forDate').val(emptyDateD);
                }
            });*/

        });
    </script>
    <script type="text/javascript" src="{{ asset('/js/events/event_search.js')}}"></script>
    <script type="text/javascript" src="{{ asset('/js/events/event-save-share.js')}}"></script>
    <!-- USER NOT LOGIN MODEL -->
    <div class="modal fade bd-example-modal-md" tabindex="-1" id="signupAlert" role="dialog"
         aria-labelledby="sighupalert" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content signup-alert">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('words.save_eve_title')</h5>

                    <p class="modal-text">@lang('words.save_eve_content')</p>

                    <div class="model-btn">
                        <a href="{{ route('user.signup') }}"
                           class="btn pro-choose-file text-uppercase">@lang('words.save_eve_signin_btn')</a>

                        <p class="modal-text-small">
                            @lang('words.save_eve_login_txt') <a
                                    href="{{ route('user.login') }}">@lang('words.save_eve_login_btn')</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- USER NOT LOGIN MODEL -->
    <!-- SHARE EVENT MODEL -->
    <div class="modal fade bd-example-modal-md" tabindex="-1" id="shareEvent" role="dialog" aria-labelledby="shareEvent"
         aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content signup-alert">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('words.share_title_popup')</h5>

                    <div class="share" id="share-body">
                        <a href="" class="social-button social-logo-detail facebook">
                            <i class="fa fa-facebook"></i>
                        </a>
                        <a href="" class="social-button social-logo-detail twitter">
                            <i class="fa fa-twitter"></i>
                        </a>
                        <a href="" class="social-button social-logo-detail linkedin">
                            <i class="fa fa-linkedin"></i>
                        </a>
                        <a href="" class="social-button social-logo-detail google">
                            <i class="fa fa-google"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- SHARE EVENT MODEL -->
@endsection
@section('pageScript')
    <script type="text/javascript" src="{{ asset('/js/events/event_search.js')}}"></script>
    <script type="text/javascript" src="{{ asset('/js/events/event-save-share.js')}}"></script>
    <!-- USER NOT LOGIN MODEL -->
    <div class="modal fade bd-example-modal-md" tabindex="-1" id="signupAlert" role="dialog"
         aria-labelledby="sighupalert" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content signup-alert">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('words.save_eve_title')</h5>

                    <p class="modal-text">@lang('words.save_eve_content')</p>

                    <div class="model-btn">
                        <a href="{{ route('user.signup') }}"
                           class="btn pro-choose-file text-uppercase">@lang('words.save_eve_signin_btn')</a>

                        <p class="modal-text-small">
                            @lang('words.save_eve_login_txt') <a
                                    href="{{ route('user.login') }}">@lang('words.save_eve_login_btn')</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- USER NOT LOGIN MODEL -->
    <!-- SHARE EVENT MODEL -->
    <div class="modal fade bd-example-modal-md" tabindex="-1" id="shareEvent" role="dialog" aria-labelledby="shareEvent"
         aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content signup-alert">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('words.share_title_popup')</h5>

                    <div class="share" id="share-body">
                        <a href="" class="social-button social-logo-detail facebook">
                            <i class="fa fa-facebook"></i>
                        </a>
                        <a href="" class="social-button social-logo-detail twitter">
                            <i class="fa fa-twitter"></i>
                        </a>
                        <a href="" class="social-button social-logo-detail linkedin">
                            <i class="fa fa-linkedin"></i>
                        </a>
                        <a href="" class="social-button social-logo-detail google">
                            <i class="fa fa-google"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- SHARE EVENT MODEL -->
@endsection
