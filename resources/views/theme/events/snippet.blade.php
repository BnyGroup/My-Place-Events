<!DOCTYPE html>
<html>
<head>
  <title>{{ $data->event_name }} {{--Snippet--}}Fragment</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('/public/css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('/css/custom.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('/css/custom_2.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('/css/style.css') }}">
</head>
<body>
  <a href="{{ route('events.details',[$slug,'snippet']) }}">
   {{-- <section>
      	<div class="container">
        <div class="row">
			--}}{{--@include('theme.events.event-unique-list)--}}{{--
          <div class="col-lg-12 text-center content-title">
            <h1>{{ $data->event_name }}</h1>
          </div>
        </div>
        <div class="row">
            <div class="col-12">
              	<div class="box snip-box">              	
                	<a href="{{ route('events.details',[$slug,'snippet']) }}" target="_blank"><img src="{{ getImage($data->event_image) }}" alt="{{$data->event_name}}" /></a>
                  	<a href="{{ route('events.details',[$slug,'snippet']) }}" target="_blank">
                  		<span class="label-text-title">{!! use_currency()->symbol !!} {{ $data->event_min_price }} - {!! use_currency()->symbol !!} {{ $data->event_max_price }}</span>
                  	</a>
                  	<div style="margin-top: 15px;">   
    	              	<div style="margin-top:5px;">
    	              		<strong>Event Location</strong> : <span>{{ $data->event_location }}</span>
    	              	</div>
    	              	<div style="margin-top:5px;">
    	              		<strong>Event Start On</strong> : <span>{{ dateFormat($data->event_start_datetime) }}</span>
    	            	</div>
    	            </div>
                	<div style="clear:both;"></div>
              	</div>
            </div>
        </div>
      </div>
    </section>--}}
	  @include('theme.events.event-unique-list')
  </a>
</body>
</html>
