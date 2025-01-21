<div class="col-lg-4 col-md-6 col-sm-12 hover" style="display: {{ $style = ($data->item_name == 'Event Test' || $data->item_name == 'Event test')?'none':'' }};" >
    <div class="box" style="position: relative;">
        <a href="{{ route('shop_item.details',$data->item_slug) }}"><img
                    src="{{ getImage($data->item1_image, 'thumb') }}"
                    alt="{{ $data->item_name }}"/></a>

        <div class="box-content card__padding">
            <h4 class="card-title"><a
                        href="{{ route('shop_item.details',$data->item_slug) }}"> {{App\Event::find($data->event_id)->event_name}} | {{ $data->item_name }}</a>
            </h4>

            <div class="badge category col-sm-4 col-sm-offset-1" style="cursor: default">
                  <span class="">
                  @if(Route::currentRouteName() === 'index')
                      {{ $data->this_event_category }}
                    @else
                        {{App\Event::getCategoryById($data->item_category)}}
                    @endif
                  </span>
            </div>
            <div class="badge prix f-right col-sm-7">
                <a href="{{ route('shop_item.details',$data->item_slug) }}" class=""><span class="">
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

                $startdate 	= ucwords(Jenssegers\Date\Date::parse($data->item_start_datetime)->format('D j F Y'));
                $enddate 	= ucwords(Jenssegers\Date\Date::parse($data->item_end_datetime)->format('D j F Y'));
                $starttime	= Carbon\Carbon::parse($data->item_start_datetime)->format('H:i');
                $endtime	= Carbon\Carbon::parse($data->item_end_datetime)->format('H:i');
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
                           class="third-color bold"> {{ $data->item_location }}</a>
                    </div>
                </div>
                <form action="{{route('shop_cart.store')}}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="gadget_id" value="{{$data->id}}">

                    <div class="row">
                        <div class="col-sm-5" style="height:40px;line-height:36px" >
                            <select class="form-control form-textbox k-state" name="event_ticket" id="event_ticket" required>
                                @foreach(($event_tickets->active_event_tickets($data->item_unique_id)) as $event_ticket)
                                    <option value="{{$event_ticket->ticket_price_buyer}}">{{ $event_ticket->ticket_price_buyer }} </option>
                                @endforeach
                            </select>
                            @if($errors->has('event_ticket')) <span class="error">{{ $errors->first('event_ticket') }}</span> @endif
                        </div>

                        <div class="col-sm-4" style="height:40px;line-height:36px" >
                            @if(json_decode($data->item_color))
                                <select class="form-control form-textbox k-state" name="color" id="color">
                                    @foreach(json_decode($data->item_color) as $color)
                                        <option value="{{$color}}" selected="selected">{{ $color }} </option>
                                    @endforeach
                                </select>
                                @if($errors->has('color')) <span class="error">{{ $errors->first('color') }}</span> @endif
                            @else
                                <select class="form-control form-textbox k-state" name="color" id="color" disabled>
                                    <option ></option>
                                </select>
                            @endif
                        </div>

                        <div class="col-sm-3" style="height:40px;line-height:36px" >
                            @if(json_decode($data->item_size))
                                <select class="form-control form-textbox k-state" name="size" id="size">
                                    @foreach(json_decode($data->item_size) as $size)
                                        <option value="{{$size}}" selected="selected">{{ $size }} </option>
                                    @endforeach
                                </select>
                                @if($errors->has('size')) <span class="error">{{ $errors->first('size') }}</span> @endif
                            @else
                                <select class="form-control form-textbox k-state" name="size" id="size" disabled>
                                    <option ></option>
                                </select>
                            @endif
                        </div>
                    </div>
                    <p>
                        <button href="#" type="submit" class="btn" style="width:100%;margin-top:20px;line-height:36px">@lang('words.cre_gad_page.add_to_cart')</button>
                    </p>
                </form>
            </div>
            <div class="box-icon pull-right like-listing">
                @if(auth()->guard('frontuser')->check())
                    @php $userid = auth()->guard('frontuser')->user()->id  @endphp
                @else
                    @php $userid = ''  @endphp
                @endif
                <a href="javascript:void(0)" data-toggle="tooltip"
                   data-original-title="@lang('words.events_box_tooltip.save_tooltip1')"
                   data-placement="right" id="save-event" class="save-event" data-user="{{$userid}}"
                   data-event="{{ $data->item_unique_id }}" data-mark="0">
                    @if(is_null(getbookmark($data->item_unique_id, $userid)))
                        <i class="far fa-heart"></i>
                    @else
                        <i class="fas fa-heart"></i>
                    @endif
                </a>
                <!-- <i class="fa fa-bookmark-o"><a href="#"></a></i> -->
            </div>
            <div class="box-icon pull-right share-listing">
                <a href="javascript:void()" data-toggle="tooltip"
                   data-original-title="@lang('words.events_box_tooltip.share_tooltip1')"
                   data-placement="right" class="event-share"
                   data-url="{{route('shop_item.details',$data->item_slug)}}"
                   data-name="{{ $data->item_name }}" data-loca="{{ $data->item_location }}">
                    <i class="fas fa-share"></i>
                </a>
            </div>
            <div style="clear:both;"></div>
        </div>
    </div>

</div>

