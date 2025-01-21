<div class="col-lg-4 col-md-6 col-sm-12 hover" style="display: {{ $style = ($data->event_name == 'Event Test' || $data->event_name == 'Event test')?'none':'' }};" >
    <div class="box" style="position: relative;">
        <a href="{{ route('events.details',$data->event_slug) }}"><img
                    src="{{ getImage($data->event_image, 'thumb') }}"
                    alt="{{ $data->event_name }}"/></a>

        <div class="box-content card__padding">
            <h4 class="card-title"><a  href="{{ route('events.details',$data->event_slug) }}">{{ $data->event_name }}</a>
            </h4>

            <div class="badge category col-sm-4 col-sm-offset-1" style="cursor: default">
                  <span class="">
                  @if(Route::currentRouteName() === 'index')
                      {{ $data->this_event_category }}
                    @else
                        {{App\Event::getCategoryById($data->event_category)}}
                    @endif
                  </span>
            </div>
            <div class="badge prix f-right col-sm-7">
                <a href="{{ route('events.details',$data->event_slug) }}" class=""><span class="">
                    	@if($data->event_min_price == 0)
                            GRATUIT
                        @else
                             {!! number_format($data->event_min_price, 0, "."," ") !!} {!! use_currency()->symbol !!}
                        @endif
                        @if($data->event_min_price != $data->event_max_price)
                            - {!! number_format($data->event_max_price, 0, "."," ") !!} {!! use_currency()->symbol !!}
                        @endif
                 			 </span></a>
            </div>
            @php
                /*$startdate = Carbon\Carbon::parse($event->event_start_datetime)->format('D j F Y');
                $enddate = Carbon\Carbon::parse($event->event_end_datetime)->format('D, F j, Y');
                $starttime = Carbon\Carbon::parse($event->event_start_datetime)->format('h:i A');
                $endtime = Carbon\Carbon::parse($event->event_end_datetime)->format('h:i A');*/

                $startdate 	= ucwords(Jenssegers\Date\Date::parse($data->event_start_datetime)->format('D j F Y'));
                $enddate 	= ucwords(Jenssegers\Date\Date::parse($data->event_end_datetime)->format('D j F Y'));
                $starttime	= Carbon\Carbon::parse($data->event_start_datetime)->format('H:i');
                $endtime	= Carbon\Carbon::parse($data->event_end_datetime)->format('H:i');
            @endphp
            <div class="card__action">
                                    @if($startdate == $enddate)
                            <span class="date-times bold third-color">
    								<i class="far fa-clock secondary-color"></i>
                                        {{ $startdate }}{{-- {{ $starttime }} - {{ $endtime }}--}}
                        	</span>
                                    @else
                        <span class="date-times bold third-color">
    								<i class="far fa-clock secondary-color"></i>
                        {{ $startdate }} - {{ $enddate }}
                                      {{--{{ $startdate }} {{ $starttime }} - {{ $enddate }} : {{ $endtime }}--}}
                        </span>
                        {{--<span class="date-times bold third-color">--}}
    								{{--<i class="far fa-clock secondary-color"></i>--}}
                        {{-- {{ $starttime }} - {{ $endtime }}--}}
                        {{-- {{ $startdate }} {{ $starttime }} - {{ $enddate }} - {{ $endtime }}--}}
                        {{--</span>--}}

                                    @endif
                                    <span class="bold"></span>


                <div class="card__location">
                    <div class="card__location-content">
                        <i class="fas fa-map-marker-alt primary-color"></i>
                        <a href="" rel="tag"
                           class="third-color bold"> {{ $data->event_location }}</a>
                    </div>
                </div>
            </div>
            <div class="box-icon pull-right like-listing"  id="userlike-{{$data->event_unique_id}}">
                @if(auth()->guard('frontuser')->check())
                    @php $userid = auth()->guard('frontuser')->user()->id  @endphp
                @else
                    @php $userid = ''  @endphp
                @endif
                <a href="javascript:void(0)" data-toggle="tooltip"
                   data-original-title="@lang('words.events_box_tooltip.save_tooltip')"
                   data-placement="right" id="save-event" class="save-event" data-user="{{$userid}}"
                   data-event="{{ $data->event_unique_id }}" data-mark="0">
                    @if(is_null(getbookmark($data->event_unique_id, $userid)))
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
                   data-url="{{route('events.details',$data->event_slug)}}"
                   data-name="{{ $data->event_name }}" data-loca="{{ $data->event_location }}">
                    <i class="fas fa-share"></i>
                </a>
            </div>
            <div style="clear:both;"></div>
        </div>
    </div>

</div>

{{--
<div class="col-lg-4 col-md-6 col-sm-12 hover">
    <div class="box" style="position: relative;">
        <a href="{{ route('events.details',$data->event_slug) }}">
            <div class="card__image border-tlr-radius">
                <img src="{{ getImage($data->event_image,'thumb') }}" alt="{{ $data->event_name }}" />
            </div>
        </a>
        <div class="box-content card__padding">
            <h4 class="card-title"><a href="{{ route('events.details',$data->event_slug) }}">{{ $data->event_name }}</a>
            </h4>
            <div class="badge category" style="cursor: default">
                  <span class="">
                      {{ $data->this_event_category }}
                  </span>
            </div>
            <div class="badge prix f-right">
                <a href="{{ route('events.details',$data->event_slug) }}" class=""><span class="">
                    @if($data->event_min_price == 0)
                            Gratuit
                        @else
                            {!! number_format($data->event_min_price,0, "."," ") !!}  {!! use_currency()->symbol !!}
                        @endif
                        @if($data->event_min_price != $data->event_max_price)
                            -  {!! number_format($data->event_max_price,0, "."," ") !!} {!! use_currency()->symbol !!}
                        @endif
                  </span></a>
            </div>

            @php Jenssegers\Date\Date::setLocale('fr') @endphp
            <div class="card__action">
                    <span class="date-times bold third-color">
                        <i class="far fa-calendar-alt secondary-color"></i>
                            --}}
{{--{{ Carbon\Carbon::parse($data->event_start_datetime)->format('D, M j, Y') }} AT {{ Carbon\Carbon::parse($data->event_start_datetime)->format('h:i A') }}--}}{{--

                        {{ Jenssegers\Date\Date::parse($data->event_start_datetime)->format('l j F Y') }}
                        --}}
{{--A {{ Carbon\Carbon::parse($data->event_start_datetime)->format('H:i') }}--}}{{--

                        <span class="bold"></span>
                    </span>
                <div class="card__location">
                    <div class="card__location-content">
                        <i class="fas fa-map-marker-alt primary-color"></i>
                        <a href="" rel="tag" class="third-color bold"> {{ $data->event_location }}</a>
                    </div>
                </div>
            </div>

            <div class="box-icon pull-right like-listing"  id="userlike-{{$data->event_unique_id}}">
                @if(auth()->guard('frontuser')->check())
                    @php $userid = auth()->guard('frontuser')->user()->id  @endphp
                @else
                    @php $userid = ''  @endphp
                @endif
                <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="@lang('words.events_box_tooltip.save_tooltip')" data-placement="right" id="save-event" class="save-event" data-user="{{$userid}}" data-event="{{ $data->event_unique_id }}" data-mark="0" >
                    @if(is_null(getbookmark($data->event_unique_id, $userid)))
                        <i class="far fa-heart"></i>
                    @else
                        <i class="fas fa-heart"></i>
                    @endif
                </a>
                <!-- <i class="fa fa-bookmark-o"><a href="#"></a></i> -->
            </div>
            <div class="box-icon pull-right share-listing">
                <a href="javascript:void()" data-toggle="tooltip" data-original-title="@lang('words.events_box_tooltip.share_tooltip')" data-placement="right" class="event-share" data-url="{{route('events.details',$data->event_slug)}}" data-name="{{ $data->event_name }}" data-loca="{{ $data->event_location }}">
                    <i class="fas fa-share"></i>
                </a>
            </div>
            <div style="clear:both;"></div>
        </div>
    </div>
</div>--}}
