@inject(tdl,'App\TeteDeListe')
@inject(eventsData,'App\Event')
@inject(eventCat,'App\EventCategory')
@inject(sliders,'App\Slider')
@inject(ALaUne,'App\ALaUne')

@inject(services,'App\Service')
@inject(prestataires,'App\Prestataire')
@extends($theme)
{{-- @extends('layouts.master', ['body_class' => 'home-page']) --}}
@section('meta_title',setMetaData()->home_title)
@section('meta_description',setMetaData()->home_desc)
@section('meta_keywords',setMetaData()->home_keyword)
@section('pageClass', 'js-home-page')
@section('content')


 
<!--contentslider-->
<video id="mainvid" width="100%" height="70%" autoplay loop muted playsinline>
    <source src="{{URL::asset("/public/upload/PLACETER-2.mp4")}}" type="video/mp4">
    Your browser does not support the video tag.
</video>
<div class="calltoaction">
    <div class="linedivide"></div>
    <div class="cta_text marquee" style="height: 44px; overflow: hidden;"> Achat de tickets possible par mobile money ou carte bancaire &nbsp;&nbsp;&nbsp; Pour toute demande d informations, contactez-nous sur WhatsApp au +225 07 47 97 45 05.</div>
    <div class="linedivide"></div>    
</div>

<style>
	
	@media  screen and (min-width: 601px){
		.slick-list.draggable .slick-track{
			min-width: 1200px;
		}
	}
	@media  screen and (max-width: 600px){
		.opny .slick-list.draggable .slick-track{
			transform: unset !important
		}
	}
    .calltoaction{
        background: #000000 0% 0% no-repeat padding-box;
            margin-top: -7px;
    }
    .linedivide{
        height: 5px;
        background: transparent linear-gradient(90deg, var(--unnamed-color-000d8b) 0%, #D100A0 53%, var(--unnamed-color-fcb605) 100%) 0% 0% no-repeat padding-box;
        background: transparent linear-gradient(90deg, #000D8B 0%, #D100A0 53%, #FCB605 100%) 0% 0% no-repeat padding-box;
    }
    .cta_text{
        padding: 10px;
        color: #FFFFFF;
        text-align: center
    }
    .cta_text span{
        color: #FEB00A
    }

  
</style>
<!--contentslider end-->
<!--CONTENT START-->
<section class="section-bg home-section-bg" style="padding-bottom:0">

	
<?php if(count($eventsData->geteventlistbycat(8))>0){ ?>   
 <!--top festival box-->
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center content-title">
        <h1 style="margin-bottom: 0;" class="section-title"><a href="{{ route('events',['','cat=festival']) }}">Top @lang('words.Title_page.festival')s</a></h1>
      </div>
    </div>
          <div class="topcat-slide">             
      @php $i = 1 @endphp
      @foreach($eventsData->geteventlistbycat(8) as $key => $data)
          @if($data->event_status == 1)
                 
              @include('theme.events.event-topcat-list')  
                 
          @endif
      @endforeach              
        </div> 
    
  </div>
  <!--End top festival -->
    
<?php } ?>	
	
<?php if(count($eventsData->geteventlistbycat(4))>0){ ?>    
  <!--top concert box-->
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center content-title">
        <h1 style="margin-bottom: 0;" class="section-title"><a href="{{ route('events',['','cat=concert']) }}">Top @lang('words.Title_page.concert')s</a></h1>
      </div>
    </div>
    <div class="topcat-slide">             
      @php $i = 1 @endphp
      @foreach($eventsData->geteventlistbycat(4) as $key => $data)
          @if($data->event_status == 1)

              @include('theme.events.event-topcat-list')  

          @endif
      @endforeach              
    </div> 

    
  </div>
  <!--End top concert -->
 	
	
<?php } ?>	   
    
  
 	
	
  <!--D�but Les immanquables-->
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center content-title">
        <h1 style="margin-bottom: 0;" class="section-title nosection-titleafter"><a href="javascript:void(0)">@lang('words.unmissable')</a></h1>
      </div>
    </div>
  </div>
	
  <div class="immslide" style="overflow: hidden">  	
	<?php

	 foreach($bannerImm as $evimm){
	
			if($evimm->image!=null){	

				$mainColor="1A1A1A";
	 ?>	

				  <div class="row" style="background-color: #{{$mainColor}}; width: 100%">
					  <div class="container">
						  <div class="row">
								<div class="col-lg-12">             
										<a href="{{$evimm->url}}" title="{{ $evimm->title }}">
											<img src="{{ getImage($evimm->image) }}" alt="{{ $evimm->event_name }}" style="width: 100%; max-width: 100%" />
										</a>
										<div class="" style="position: absolute; bottom: 20px; right: 25px">    
												<a class="btn btn-primary ImmBut" href="{{$evimm->url}}" title="{{ $evimm->title }}">@lang('words.know_more') <i class="fa fa-chevron-right" aria-hidden="true"></i></a>	 					
										</div> 
								</div> 
						  </div>
					  </div>
				  </div>
	 <?php } 
	 } ?>	
</div>
  <!--End Les immanquables -->
	
	
	

	
<?php if(count($eventsData->geteventlistbycat(15))>0){ ?>    
  <!--top Formation box-->
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center content-title">
        <h1 style="margin-bottom: 0;" class="section-title"><a href="{{ route('events',['','cat=conference']) }}">Top @lang('words.Title_page.conference')s</a></h1>
      </div>
    </div>
    <div class="topcat-slide">             
      @php $i = 1 @endphp
      @foreach($eventsData->geteventlistbycat(15) as $key => $data)
          @if($data->event_status == 1)

              @include('theme.events.event-topcat-list')  

          @endif
      @endforeach              
    </div> 

    
  </div>
  <!--End top Formation -->
    
<?php } ?>	
	
<?php if(count($eventsData->geteventlistbycat(14))>0){ ?>    
  <!--top exposition box-->
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center content-title">
        <h1 style="margin-bottom: 0;" class="section-title"><a href="{{ route('events',['','cat=comedie']) }}">Top @lang('words.Title_page.comedy')s</a></h1>
      </div>
    </div>
    <div class="topcat-slide">             
      @php $i = 1 @endphp
      @foreach($eventsData->geteventlistbycat(14) as $key => $data)
          @if($data->event_status == 1)

              @include('theme.events.event-topcat-list')  

          @endif
      @endforeach              
    </div> 

 
  </div>
  <!--End top exposition -->  

<?php } ?>	
	
	
	
<?php if(count($eventsData->geteventlistbycat(2))>0){ ?>   
  <!--top Formation box-->
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center content-title">
        <h1 style="margin-bottom: 0;" class="section-title"><a href="{{ route('events',['','cat=formation']) }}">Top Formations</a></h1>
      </div>
    </div>
    <div class="topcat-slide">             
      @php $i = 1 @endphp
      @foreach($eventsData->geteventlistbycat(2) as $key => $data)
          @if($data->event_status == 1)

              @include('theme.events.event-topcat-list')  

          @endif
      @endforeach              
    </div> 
 
  </div>
  <!--End top Formation -->  	
<?php } ?>	
	
<?php if(count($eventsData->geteventlistbycat(3))>0){ ?>	
  <!--top Comp�tition box-->
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center content-title">
        <h1 style="margin-bottom: 0;" class="section-title"><a href="{{ route('events',['','cat=competition']) }}">Top Competitions</a></h1>
      </div>
    </div>
    <div class="topcat-slide">             
      @php $i = 1 @endphp
      @foreach($eventsData->geteventlistbycat(3) as $key => $data)
          @if($data->event_status == 1)

              @include('theme.events.event-topcat-list')  

          @endif
      @endforeach              
    </div> 
 
  </div>
  <!--End top Comp�tition -->  		
	
<?php } ?>	
	
<?php if(count($eventsData->geteventlistbycat(7))>0){ ?>		
  <!--top Exposition box-->
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center content-title">
        <h1 style="margin-bottom: 0;" class="section-title"><a href="{{ route('events',['','cat=exposition']) }}">Top Expositions</a></h1>
      </div>
    </div>
    <div class="topcat-slide">             
      @php $i = 1 @endphp
      @foreach($eventsData->geteventlistbycat(7) as $key => $data)
          @if($data->event_status == 1)

              @include('theme.events.event-topcat-list')  

          @endif
      @endforeach              
    </div> 
 
  </div>
  <!--End top Exposition -->  		
<?php } ?>	
	
<?php if(count($eventsData->geteventlistbycat(11))>0){ ?>		
  <!--top Soir�e box-->
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center content-title">
        <h1 style="margin-bottom: 0;" class="section-title"><a href="{{ route('events',['','cat=soiree']) }}">Top @lang('words.Title_page.partys')</a></h1>
      </div>
    </div>
    <div class="topcat-slide">             
      @php $i = 1 @endphp
      @foreach($eventsData->geteventlistbycat(11) as $key => $data)
          @if($data->event_status == 1)

              @include('theme.events.event-topcat-list')  

          @endif
      @endforeach              
    </div> 
 
  </div>
  <!--End top Soir�e --> 
<?php } ?>	
	
<?php if(count($eventsData->geteventlistbycat(13))>0){ ?>	
  <!--top Tourisme box-->
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center content-title">
        <h1 style="margin-bottom: 0;" class="section-title"><a href="{{ route('events',['','cat=tourisme']) }}">Top @lang('words.Title_page.tourism')s</a></h1>
      </div>
    </div>
    <div class="topcat-slide">             
      @php $i = 1 @endphp
      @foreach($eventsData->geteventlistbycat(13) as $key => $data)
          @if($data->event_status == 1)

              @include('theme.events.event-topcat-list')  

          @endif
      @endforeach              
    </div> 
 
    
  </div>
  <!--End top Tourisme -->  	
<?php } ?>	
 
	
	<div class="container" style="margin-bottom: 30px;padding-right: 55px;">
		  <div class="row" style="align-items: end; flex-direction: column;">
			  <a href="{{ route('events') }}" class="btn btn-primary allEventButton mb-2 third-bg">@lang('words.Title_page.all_events') <i class="fa fa-chevron-right">&nbsp;</i></a>
    	</div>
  </div>
	
<?php if(count($tdl->getList())>0){ ?> 
<!--Pub-->
<section class="" >
  @foreach($tdl->getList() as $tetedeliste)
  <a href="{{ $tetedeliste->url_entete }}" target="_blank">
    <img src="{{ url($tetedeliste->image_entete) }}" alt="" class="img-fluid" style="min-height: 100px; background-color: #eee;">
  </a>
  @endforeach
</section>
<!--Pub-->
<?php } ?>    
    

<style>
@media screen and (max-width: 600px){
 
   /* .home-section-bg .slick-slide{
        margin: 0px 23px 0px -9px !important;
        width: 320px !important;
        border:2px solid red;
    }*/
    .topcat-slide {
        margin-left: -17px;
        margin-right: -17px; 
    }
    
@media screen and (max-width: 360px){
    .home-section-bg .right_innerbox .datexp > div.both:first-child, .right_innerbox .datexp > div.both:last-child {
        width: 38% !important;
    }
}    
</style>
 

  <!-- container over-->
  <!--container start-->
  <div class="container" style="display: none;">
    <div class="row">
      <div class="col-lg text-center categories-browse-title">
        <h1>@lang('words.home_content.cat_title')</h1>
      </div>
    </div>
    @php $i=1; @endphp
    <div class="row image-drawer">
      @foreach($eventCat->getList() as $key => $value)
      @if($i == 1 || $i == 7)
      @php $image = ($value->category_image != '')? getImage($value->category_image, 'resize'): asset('/default/thumb-image-not-found.jpg') ;  @endphp
      <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 img-draw">
        <div class="hovereffect">
          {{--                <a href="{{ route('events',['','cat='.$value->id]) }}">--}}
            <a href="{{ url('events/categories/'.$value->id) }}">
              <img class="img-responsive" src="{!! $image !!}" alt="">
              <div class="overlay">
                <p class="image-text">{{$value->category_name}}</p>
              </div>
            </a>
          </div>
        </div>
        @else
        @php $image = ($value->category_image != '')? getImage($value->category_image, 'thumb'): asset('/default/thumb-image-not-found.jpg') ;  @endphp
        <div class="col-lg-4 col-md-4 col-sm-12 img-draw">
          <div class="hovereffect">
            <a {{--href="{{ route('events',['','cat='.$value->id]) }}"--}}href="{{ url('events/categories/'.$value->id) }}">
              <img class="img-responsive" src="{!! $image !!}" alt="">
              <div class="overlay">
                <p class="image-text">{{ $value->category_name }}</p>
              </div>
            </a>
          </div>
        </div>
        @endif
        @php $i= ($i==10)?0:'' @endphp
        @php $i++; @endphp
        @endforeach
        <!--end container -->
      </div>
    </div>
  </section>
  @endsection

  @section('pageScript')
	
	<script type="text/javascript" src="{{ asset('/js/jquery.marquee.js')}}"></script>
	
	<script>
	$(".slider").not('.slick-initialized').slick();
	</script>	
	
    <script type="text/javascript" src="{{ asset('/js/events/event-save-share.js')}}"></script>
    
   <script type="text/javascript">
   
    $(document).ready(function(){
     // $(".slick-current.slick-active").next().css({"color": "red", "border": "2px solid red","left":"-27px"});
		var element_=$('.topcat-slide');
		element_.each(function(i, obj) {
			var top=$(this).find('.col-lg-4');
			console.log("Div-"+i);			 
			console.log("xxx : "+top.length);
			if(top.length==1){
				var el = element_.eq(i);
				el.addClass('opny');
				//$('.opny').slick('unslick');

				/*$(this).find('.slick-track').css("border","2px solid red !important")
				$(this).find('.slick-track').css("transform","unset !important")*/
			}
		});

    });
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

   <script type="text/javascript">
        $('#mobile-home-search-form input[type="submit"]').on('click', function() {
          var i = 0;
          var selectEnfants = $('#mobile-home-search-form select[name="event_country"]').children();
          var selectNombreEnfant = selectEnfants.length;
        });
	   if($('#mobile-forDate').length!=0){
			$('#mobile-forDateContent').hide()
			$('#mobile-forDate').on('mousedown', function () {
			  $('#mobile-forDateContent').toggle();
			});

			$('#mobile-forDateContent a').on('click', function () {
			  var inputValue = $(this).text();
			  $('#mobile-forDate').val(inputValue);
			  $('#mobile-forDate').val().replace(' ', '');

			  if ($('#mobile-forDate').val() == $('#mobile-forDateContent li:last').text()) {
				$('#mobile-forDate').val('cdate');
			  }
			});

			$('#mobile-custom_date').on('click', function () {
			  $("#mobile-forDateContent li:last").toggle();
			});

			var div_cliquable = $('#mobile-forDate');
			$(document.body).click(function (e) {
			// Si ce n'est pas #ma_div ni un de ses enfants
			if (!$(e.target).is(div_cliquable) && !$.contains(div_cliquable[0], e.target) && !$(e.target).is($('#mobile-forDateContent')) && !$.contains($('#mobile-forDateContent')[0], e.target)) {
				$('#mobile-forDateContent').hide(); // masque #ma_div en fondu
			  }
			});
		}
      </script>

   <script>

    // options
    var speed = 500; //transition speed - fade
    var autoswitch = true; //auto slider options
    var autoswitch_speed = 5000; //auto slider speed

    // add first initial active class
    $(".slide").first().addClass("active");

    // hide all slides
    $(".slide").hide;

    // show only active class slide
    $(".active").show();

    // Next Event Handler
    $('#next').on('click', nextSlide);// call function nextSlide

    // Prev Event Handler
    $('#prev').on('click', prevSlide);// call function prevSlide

    // Auto Slider Handler
    if(autoswitch == true){
      setInterval(nextSlide,autoswitch_speed);// call function and value 4000
    }

    // Switch to next slide
    function nextSlide(){
      $('.active').removeClass('active').addClass('oldActive');
      if($('.oldActive').is(':last-child')){
        $('.slide').first().addClass('active');
      } else {
        $('.oldActive').next().addClass('active');
      }
      $('.oldActive').removeClass('oldActive');
      $('.slide').fadeOut(speed);
      $('.active').fadeIn(speed);
    }

    // Switch to prev slide
    function prevSlide(){
      $('.active').removeClass('active').addClass('oldActive');
      if($('.oldActive').is(':first-child')){
        $('.slide').last().addClass('active');
      } else {
        $('.oldActive').prev().addClass('active');
      }
      $('.oldActive').removeClass('oldActive');
      $('.slide').fadeOut(speed);
      $('.active').fadeIn(speed);
    }
    /*});*/
  </script>
 
 
  <script>
 
/* Do this every time window gets resized */
$(function() {
	var wi=$(window).width();
  
 
   /* If we are above mobile breakpoint unslick the slider */
   if (wi > "990") 
   {   
        $('.topcat-slide').slick({
		  slidesToShow: 3,
		  slidesToScroll: 1,
		  autoplay: true,
		  lazyLoad: 'ondemand',
		  autoplaySpeed: 3500,
		  pauseOnHover: true,
		  prevArrow: "<button type='button' class='slick-prev'></button>",
		  nextArrow: "<button type='button' class='slick-next slick-arrow'></button>",
		});  
	
		$('.marquee').marquee({
		  speed: 120,
		  gap: 50,
		  delayBeforeStart: 0,
		  direction: 'left',
		  duplicated: true,
		  pauseOnHover: true
		});
	
   }else if ($(window).width() <= 990 & $(window).width()>600){   
	   
        $('.topcat-slide').slick({
		  slidesToShow: 2,
		  slidesToScroll: 1,
		  autoplay: true,
		  lazyLoad: 'ondemand',
		  autoplaySpeed: 3500,
		  pauseOnHover: true,
		  prevArrow: "<button type='button' class='slick-prev'></button>",
		  nextArrow: "<button type='button' class='slick-next slick-arrow'></button>",
		});  
	
		$('.marquee').marquee({
		  speed: 120,
		  gap: 50,
		  delayBeforeStart: 0,
		  direction: 'left',
		  duplicated: true,
		  pauseOnHover: true
		});
	   
   }else if ($(window).width() <= 600) 
   {  
	     
        $('.topcat-slide').slick({
		  slidesToShow: 1,
		  slidesToScroll: 1,
		  autoplay: true,
		  lazyLoad: 'ondemand',
		  autoplaySpeed: 3500,
		  pauseOnHover: true,
		  centerMode: true,
  focusOnSelect: true,
  centerPadding: '40px',
		  prevArrow: "<button type='button' class='slick-prev'></button>",
		  nextArrow: "<button type='button' class='slick-next slick-arrow'></button>",
		}); 
	   
	   $('.marquee').marquee({
		  speed: 60,
		  gap: 50,
		  delayBeforeStart: 0,
		  direction: 'left',
		  duplicated: true,
		  pauseOnHover: true
		});
		
		$("#mainvid > source").attr("src","{{URL::asset("/public/upload/PLACETER-2.mp4")}}");
		$("#mainvid")[0].load();
		$("#mainvid")[0].play();
		$("#mainvid")[0].volume = 0.5;

   } 
    
});
	  
$('.immslide').slick({
	  slidesToShow: 1,
	  slidesToScroll: 1,
	  autoplay: true,
	  lazyLoad: 'ondemand',
	  autoplaySpeed: 3500,
	  pauseOnHover: true,
	  prevArrow: "<button type='button' class='slick-prev'></button>",
	  nextArrow: "<button type='button' class='slick-next slick-arrow'></button>",
	}); 	  

$(window).trigger('resize');
 
  $('.topcat-slidexxx').slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      autoplay: true,
      lazyLoad: 'ondemand',
      autoplaySpeed: 3500,
 	  pauseOnHover: true,
      prevArrow: "<button type='button' class='slick-prev'></button>",
      nextArrow: "<button type='button' class='slick-next slick-arrow'></button>",
      responsive: [
      {
        breakpoint: 1024,
        settings: {
          arrows: true,
          slidesToShow: 3,
          slidesToScroll: 1,
          infinite: true,
          dots: false
        }
      },
      {
        breakpoint: 990,
        settings: {
          arrows: true,
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 600,
        settings: {
          centerMode: true,
          arrows: true,
          slidesToShow: 1,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 380,
        settings: {
          centerMode: false,
          arrows: true,
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
      // You can unslick at a given breakpoint now by adding:
      // settings: "unslick"
      // instead of a settings object
      ]
    });  

  </script>
 
    
  <!-- USER NOT LOGIN MODEL -->
  <div class="modal fade bd-example-modal-md" tabindex="-1" id="signupAlert" role="dialog" aria-labelledby="sighupalert" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content signup-alert">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="modal-body">
          <h5 class="modal-title" id="exampleModalLabel">@lang('words.save_eve_title')</h5>
          <p class="modal-text">@lang('words.save_eve_content')</p>
          <div class="model-btn">
            <a href="{{ route('user.signup') }}" class="btn pro-choose-file text-uppercase">@lang('words.save_eve_signin_btn')</a>
            <p class="modal-text-small">
              @lang('words.save_eve_login_txt') <a href="{{ route('user.login') }}">@lang('words.save_eve_login_btn')</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- USER NOT LOGIN MODEL -->
  
    <!-- USER NOT LOGIN MODEL -->
  <div class="modal fade bd-example-modal-md" tabindex="-1" id="signupAlertLike" role="dialog" aria-labelledby="sighupalert" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content signup-alert">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="modal-body">
          <h5 class="modal-title" id="exampleModalLabel">@lang('words.save_this_event')</h5>
          <p class="modal-text">@lang('words.connect_to_like')</p>
          <div class="model-btn">
            <a href="javascript:openRegisterBox()" class="btn pro-choose-file text-uppercase">@lang('words.save_eve_signin_btn')</a>
            <p class="modal-text-small">
              @lang('words.save_eve_login_txt') <a href="javascript:openConnexinBox()" class="">@lang('words.save_eve_login_btn')</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- USER NOT LOGIN MODEL -->
  
  
  <!-- SHARE EVENT MODEL -->
  <div class="modal fade bd-example-modal-md" tabindex="-1" id="shareEvent" role="dialog" aria-labelledby="shareEvent" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content signup-alert">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="modal-body">
          <h5 class="modal-title" id="exampleModalLabel">@lang('words.share_title_popup')</h5>
          <div class="share" id="share-body">
            <a href="" class="social-button social-logo-detail facebook" >
              <i class="fab fa-facebook"></i>
            </a>
            <a href="" class="social-button social-logo-detail twitter">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="" class="social-button social-logo-detail linkedin">
              <i class="fab fa-linkedin"></i>
            </a>
            <a href="" class="social-button social-logo-detail google">
              <i class="fab fa-google"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- SHARE EVENT MODEL -->
 	
  <!-- USER NOT LOGIN MODEL -->
  <div class="modal fade bd-example-modal-md modal-design" id="signupAlert" role="dialog" aria-labelledby="sighupalert" aria-hidden="true">
  	<div class="modal-dialog modal-md">
  		<div class="modal-content signup-alert" style="padding-bottom: 0">
  			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  			<div class="modal-body">
  				<div class="row">
  					<div class="col-sm-12" style="text-align:center;">
  						<h5 class="modal-title col-sm-12" id="exampleModalLabel2">@lang('words.guest_popup.pop_title_2')</h5><br>
                        <a href="{{route('user.login')}}" class="btn btn-block btn-lg custom-rounded login" style="width: 100%;line-height: inherit"></i> @lang('words.connect_register')</a><br>
                        <div class="facebook-login detail" style="width: 100%;text-align: center">
                           <a href="{{url('oauth/facebook')}}" class="btn btn-block btn-lg facebook custom-rounded facebook-bg" style="width: 100%;line-height: inherit"><i class="fab fa-facebook"></i> Facebook</a>
                           <a href="{{url('oauth/google') }}" class="btn btn-block btn-lg google custom-rounded google-bg"  style="width: 100%;line-height: inherit"><i class="fab fa-google"></i> Google </a>
                       </div>
                       <br>
                       <span class="text-align-center" style="background-color: #f5f5f5;padding: 0 15px"> Ou / Or </span>
                       <hr style="border: 1px solid #e2e2e2;">
                   </div>
                   <div class="col-sm-12">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('words.guest_popup.pop_title')</h5>
                    <p class="modal-text">@lang('words.guest_popup.pop_desc') <!-- {{ forcompany() }}. --></p>
                    <div class="model-btn">
                       {!! Form::open(['method'=>'post','route'=>'guest.login', 'id'=>'guestLogin']) !!}
                       <div id="result" class="form-group text-center">
                          	<input id="phone" type="tel" name="guestUserPhone" value="" placeholder="+2250000000000" class="tel form-control form-textbox" minlength="10" maxlength="14" required style="width: 250px;margin:0 auto" />
                          	<span id="valid-msg" class="hide"><i class="fa fa-check" aria-hidden="true"></i> Valide</span>
      						<span id="error-msg" class="hide"></span>
                      </div>
                       <div class="form-group text-center">
                          <!-- <label class="label-text">@lang('words.guest_popup.pop_name')</label> -->
                          <input type="text" name="guestuserName" value="" placeholder="@lang('words.guest_popup.pop_name')" class="form-control form-textbox" style="width: 250px;margin:0 auto" required/>
                      </div>
                      <div class="form-group text-center">
                          <!-- <label class="label-text">@lang('words.guest_popup.pop_email')</label> -->
                          <input type="text" name="guestUserEmail" value="" placeholder="@lang('words.guest_popup.pop_email')" class="form-control form-textbox" style="width: 250px;margin:0 auto" required/>
                      </div>
                      <div class="form-group payment-btn">
                          <input type="submit" class="btn btn-payment text-uppercase" name="booking" value="@lang('words.guest_popup.pop_btn')" disabled />
                      </div>
                      
                      {!! Form::close() !!}
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
</div>
	
  <script src="{{ asset('/js/isValidNumber.js')}}"></script>
  <script src="{{ asset('/js/script.js')}}"></script>
<!-- USER NOT LOGIN MODEL -->

<!-- USER NOT LOGIN MODEL -->
<!-- TICKETS REGISTER MODEL -->
<div class="modal fade bd-example-modal-lg buyticket" tabindex="-1" id="registration" role="dialog" aria-labelledby="registration" aria-hidden="true">
 <div class="modal-dialog modal-lg">
    <div class="modal-content ticket-registion">
       <div class="modal-header" style="">
          <h5 class="modal-title" id="exampleModalLabel">--</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
		
      {!! Form::open(['method'=>'post','route'=>'ticket.booking', 'id'=>'booktickets', 'files'=>'true']) !!}
		
      <div class="modal-body">
		  	
		  <div class="geoclass">
			  <div style="border-radius: 12px;width: 60%;text-overflow: ellipsis;white-space: nowrap;border: 1px solid #707070;padding: 10px;overflow: hidden;"><i class="fa fa-map-marker" aria-hidden="true"></i><?php /*?> {{ $startdate }} | {{ $event->event_location }}<?php */?></div></div>
		  
          <input type="hidden" name="event_id" value="" >
          <input type="hidden" name="event_uid" value="" >
		  <?php /*?><div class="dumping">
          @if(auth()->guard('frontuser')->check())
			  @if(is_null(auth()->guard('frontuser')->user()->cellphone))
				<input id="phone" type="tel" name="userCellphone" value="" placeholder="+2250000000000" class="tel form-control form-textbox" pattern="^+\d+" style="margin:0 auto" required/>
			  @endif
          @endif
          @if(!is_null($event_tickets))
			  @foreach(($event_tickets->active_event_tickets($event->event_unique_id)) as $tkey => $ticket)
				 <div class="bd-callout bd-callout-info tickets-info" 
					  <?php
					  if(count($event_tickets->active_event_tickets($event->event_unique_id))==1){ echo"style='max-width:34%'"; }else 
					  if(count($event_tickets->active_event_tickets($event->event_unique_id))==2){ echo"style='max-width:45%'"; }?>>
					 <div class="row">
						<div class="col-md-12">
						   <h3 class="ticket-title" >{{$ticket->ticket_title}}</h3>
						   <input type="hidden" name="ticket_id[]" value="{{$ticket->ticket_id}}">
						   <input type="hidden" name="tid[]" value="{{$ticket->id}}" >
						   <p class="ticket-price">
							  @if($ticket->ticket_type == 2)
							  <strong>DONATION</strong>
							  <p>{{--Fees will be calculated before you place your order.--}} Les frais seront calcul�s avant de passer votre commande. </p>
							  @else
							  @if($ticket->ticket_price_actual == 0)
							  <span>Gratuit</span>
							  @else
							  <span>{{number_format($ticket->ticket_price_buyer,0, "."," ")}} {{--{{number_format($ticket->ticket_price_actual,0, "."," ")}} {!! use_currency()->symbol !!} + {{ number_format($ticket->ticket_price_buyer - $ticket->ticket_price_actual, 0, "."," ")}}--}} {!! use_currency()->symbol !!} {{--Fees--}}{{--Commission = {{ number_format($ticket->ticket_price_buyer, 0, "."," ") }} {!! use_currency()->symbol !!}--}} </span>
							  @endif
							  @endif
							  @if($event->event_remaining  == 1)
							  <span class="ticket-remaiming x-ticket">{{$ticket->ticket_remaning_qty}} {{--Remaining--}}Restant</span>
							  @endif
						  </p>
						  @if($ticket->ticket_desc_status == 1 && $ticket->ticket_description != '')
						  <div class="ticket-desc">
							  <a href="javascript:void(0)" class="btn btn-primary des-show showDesc">Afficher la description</a>
							  <p class="ticket-description">
								 {{$ticket->ticket_description}}
							 </p>
						 </div>
						 @endif
					 </div>
					 <div class="col-md-12">
					   @if($ticket->ticket_type == 2)
					   <span class="dntmain">
						  {!! use_currency()->symbol !!} <input type="text" name="ticket_type_dns[{{$tkey}}]" data-qty="1" onkeypress="return isNumberKey(event)" class="form-control form-textbox dnsprice text-right" style="width: calc(100% - 15px);display:inline-block;" placeholder="0" />
						  <input type="hidden" name="ticket_type_qty[{{$tkey}}]" data-amount="0.00" class="form-control form-textbox ticket" />
					  </span>
					  @else
					  @if($ticket->ticket_remaning_qty>0)
					   
					 
					 <div class="changek" data-id="{{$ticket->ticket_id}}">
						<a href="#" data-way="up" title="+" class="upk">+</a>
						 <input type="text" name="ticket_type_qty[{{$tkey}}]" id="input-{{$ticket->ticket_id}}" class="selnumticket ticket" value="0" min="0" max="{{ $ticket->ticket_remaning_qty }}" data-amount="{{ $ticket->ticket_price_buyer }}" />
						<a href="#" data-way="down" title="-" class="downk">-</a>
					 </div> 
					  @else
					  <label>Sold Out</label>
					  @endif
					  @endif
				  </div>
			  </div>
			  </div>
			  @endforeach
			  @if($event->event_code != '')
				<div class=" bd-callout bd-callout-info tickets-info">
					 <div class="row">
						<div class="col-lg-9">
						   <h3 class="ticket-title">Code d'acc�s</h3>
					   </div>
					   <div class="col-lg-3">
						   <input type="text" name="event_code" class="form-control form-textbox" required="" autocomplete="off">
					   </div>
				   </div>
				</div>
			  @endif
     		</div>
			<!-- discount coupon area -->
			<div class="discount-coupon-area">
				<div class="row" style="width: 100%">
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					<div class="col-lg-9">
						<input type="text" name="coupon" id="coupon_input" class="form-control" placeholder="{{ __('Entrez votre code coupon') }}" value="{{ request()->coupon ?? '' }}">
					</div>
					<button id="applyCoupon" class="col-lg-3 btn btn-flat btn-primary" disabled type="button" style="height: 52px; line-height: normal;">Appliquer le Coupon</button>
				</div>
				<span id="status_text" class="text-danger" style="display: block"></span>
			</div>     
     
@endif<?php */?>
</div>
<div class="modal-footer">
  <input type="hidden" name="total_ticket" id="total_qty_txt" />
  <input type="hidden" name="total_amount" id="total_amount_txt" />
  <input type="hidden" name="total_remise" id="total_remise_txt" />
  <input type="hidden" name="total_remise_type" id="total_remise_type_txt" />
  <input type="hidden" name="codecoupon" id="lecodecoupon" />
    
    
  <span class="total-qty">@lang('words.ticke_popup.ticket_qty') : <b id="total_qty">0</b></span>
  <span class="remise">Remise : <b id="remise">0</b></span>
  <span class="total-amount">@lang('words.ticke_popup.ticket_amount') : <b id="total_amount">0</b> {{ use_currency()->symbol }} </span>
  <input type="submit" id="btnBookTicket" class="btn btn-flat btn-primary" value="@lang('words.ticke_popup.ticket_btn')" disabled>
</div>
{!! Form::close() !!}
</div>
</div>
</div>
<!-- Header scrolling Start -->
@endsection