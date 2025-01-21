@inject(cat,'App\PrestataireCategory')
@inject(presta,'App\Prestataire')
@inject(pays,'App\PaysList')
@inject('souscPrestataire','App\SouscPrestataire')
@extends($theme)
{{-- @extends('layouts.master', ['body_class' => 'home-page']) --}}
@section('meta_title',setMetaData()->home_title)
@section('meta_description',setMetaData()->home_desc)
@section('meta_keywords',setMetaData()->home_keyword)
@section('pageClass', 'js-home-page')
@section('content')



    @php
        $currentPageURL = URL()->current();
        $pageArray 		= explode('/', $currentPageURL);
    @endphp



<style>
#tabs .topmenuRow .nav-item{
    padding-top: 39px;
	font-size: 15px;
}
#tabs .presta a.active{
	color: #FFFFFF !important;
}
#tabs .top-presta a{
	color: #FFFFFF !important;
}
#tabs .content-title .top-presta:before {
	color: #FCBD0D !important;
} 
#tabs .content-title .top-presta:after{
	content: "" !important;
}
</style>
 <!-- Tabs -->

<?php
$def__=""; $cuisine__=""; $musique__=""; $sono__=""; $deco__=""; $design__=""; $beaute__="";

if(isset($_GET['cat'])){
	 if(intval($_GET['cat'])==3){ $cuisine__="active"; }
	 if(intval($_GET['cat'])==7){ $musique__="active"; }
	 if(intval($_GET['cat'])==8){ $sono__="active"; }
	 if(intval($_GET['cat'])==5){ $deco__="active"; }
	 if(intval($_GET['cat'])==9){ $design__="active"; }
	 if(intval($_GET['cat'])==2){ $beaute__="active"; }
	 $_cat=intval($_GET['cat']);
	
}else{
	$def__="active";
    $_cat=0;
}

?>
<section id="tabs" class="prestataire-section">
 		<div class="row topmenuRow">
  				<nav class="container">
					<div class="nav nav-tabs nav-fill presta" id="nav-tab" role="tablist">
						<div class="nav-item nav-link {{$def__}}" data-cat="all" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><a class="">Tous les Prestataire</a></div>
						<div class="nav-item nav-link {{$cuisine__}}" data-cat="3" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><a class="cuisines">Cuisines</a></div>
                        <div class="nav-item nav-link {{$musique__}}" data-cat="7" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><a class=" musiques">Musiques, MC & DJ</a></div>
						<div class="nav-item nav-link {{$sono__}} " data-cat="8" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false"><a class="sono">Sono & Lumière</a></div>
						<div class="nav-item nav-link {{$deco__}}" data-cat="5" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-about" aria-selected="false"><a class="decoration ">Décoration & Espaces</a></div>
                        <div class="nav-item nav-link {{$design__}}" data-cat="9" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-about" aria-selected="false"><a class="design ">Design & Impression</a></div>
                        <div class="nav-item nav-link {{$beaute__}}" data-cat="2" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-about" aria-selected="false"><a class="beaute ">Beauté & Stylisme</a></div>
					</div>
				</nav>
        </div>    
        <div class="row" style="background-color: #001C96" id="topcatbox">    
            <div class="container">
				
				<div class="row">
				  <div class="col-lg-12 text-center content-title">
					<h1 style="margin-bottom: 0; " class="top-presta section-title"><a href="#">Top Prestataire</a></h1>
				  </div>
				</div>

                <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent" style="margin-top: -60px;">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" style="background: none">
                       <div class="row mt-md-5 mt-sm-4 mt-4 alleventcontainer">
						   
						   @php $i = 1 @endphp
							  @foreach($presta->getPrestListByCatTop($_cat) as $key => $data)
								  @if($data->status == 1)
 
									  @include('theme.services.prestataires.prestataire-topcat-list')

								  @endif
							  @endforeach   

                        </div>
						
						<div class="loaderBox">
                            <img src="{{ asset('/img/spinner.gif')}}" >
                        </div>
                       
                    </div> 
                </div>
                

            </div>		 
	    </div>
</section>
    
<section  class="prestataire-section">
    <!--CONTENT START-->
    <div class="">
 
        <!--Moteur de recherche-->
        @include('theme.services.prestataires.prestataire-search')
        <!--Moteur de recherche-->


		<div class="container">
			<div class="mt-md-5 mt-sm-4 mt-4 row allprestataires">
			 @php $i = 1 @endphp
			  @foreach($presta->getPrestListByCat($_cat) as $key => $data)
				  @if($data->status == 1)
 
					  @include('theme.services.prestataires.prestataire-topcat-list')

				  @endif
			  @endforeach    
			</div>
		</div>
</section>	        
        
         <div class="container" style="margin-bottom: 70px;">
             <center><button type="button" onClick="fetchData()" class="btn btn-primary allEventButton third-bg" style="float: none">En savoir plus</button></center>
             <input type="hidden" id="start" value="0">
             <input type="hidden" id="rowperpage" value="1">
             <input type="hidden" id="totalrecords" value="<?php echo $presta->getPrestListByCat(0)->total() ?>">
         </div>
        
        
         <style>
            .loaderBox{
                display: none;  
                text-align: center;
            }
             .loaderBox img{
                 width: 120px;
             }
         </style>	
		
		
		
		
		
		
		
    <section class="section-bg home-section-bg mt-md-5 artistes-card">
        <div class="container">

            <!--popular events box-->
            <div class="row mt-md-5 mt-sm-4 mt-4">
				
				<div class="downBoadPresta">
					<div class="row">
						<div class="col-lg-7 text-center content-title">

						</div>
						<div class="col-lg-5 text-center content-title">
								<div style="font-size: 30px; margin-bottom: 30px; margin-top: 30px; color: #FFFFFF; font-weight: bold">Vous proposez des services ?<br>Créez votre page “Prestataire”</div>
								

									<a href="{{ route('pre.create') }}" class="register-btn presta presthover">Créer un compte prestataire</a>

									<a href="javascript:void(0)" data-toggle="modal" data-target="#demandeService" class="register-btn presta presthover">@lang('words.Prest.texte_4')</a>
							
      							   @include("theme.services.prestataires.form-service-prestataire")
							 
						</div>
					</div>
				</div>
                 
            </div>
            
        </div>
        <!--popular events box over-->

         
         
    </section>
 
<style>
	.nav-item.nav-link{
		padding-top: 40px !important;
   		padding-bottom: 15px !important;
	}
	.nav-item.nav-link a{
		font-weight: bold !important
	}
	#nav-tabContent{
		margin-top: -10px !important;
	}
@media screen and (max-width: 600px){	
	.prestataire-section .hover .box {
        height: 450px !important;
	}
	
}

</style>
 
@endsection
		
@section('pageScript')		
<script type="text/javascript" src="{{ asset('/js/events/event-save-share.js')}}"></script>		
<script type="text/javascript">
$(document).ready(function(){
	
			var wi=$(window).width();

		   /* If we are above mobile breakpoint unslick the slider */
		   if (wi <= "600") 
		   {    
				$('#nav-tab').slick({
				  slidesToShow: 2,
				  slidesToScroll: 1,
				  autoplay: false,
				  lazyLoad: 'ondemand',
				  autoplaySpeed: 3500,
				  pauseOnHover: true,
				  prevArrow: "<button type='button' class='slick-prev'></button>",
				  nextArrow: "<button type='button' class='slick-next slick-arrow'></button>",
				});   

		   }	
			
		$("#nav-tab .nav-item").on("click", function(){
			$('#start').val('0');
			var start = $('#start').val(); 

			var cat=$(this).data("cat");
			$('.allEventButton').css("display", "block");
			$.ajax({
				   url:"{{ route('prestatairesbytopcats')}}",
				   data: {page:start, cat:cat},
				   method: 'GET',   
				   beforeSend: function( xhr ) {
						$('.alleventcontainer').html('<div align="center" style="display:block; width: 100%;"><img src="{{ asset('/img/spinner.gif')}}" ></div>');
					},
				   success: function(response){ 
						// Add
						//$('.loaderBox').css("display", "none");
						if ($.trim(response) != 0){
							$("#topcatbox").show().fadeIn("slow");  
							$(".alleventcontainer").html(response).show().fadeIn("slow");   
						}else{
							$(".alleventcontainer").html("<div align='center' style='display:block; margin:80px 0; width:100%'>Aucun prestataire à afficher dans cette catégorie</div>").show().fadeIn("slow"); 
							$('.allEventButton').css("display", "none");
							$("#topcatbox").show().fadeOut("slow");  
							$('#topcatbox').css("display", "none");
						}

				   }
			  });
			
			//allprestataires
			
 
			$.ajax({
				   url:"{{ route('prestatairesbycats')}}",
				   data: {page:start, cat:cat},
				   method: 'GET',   
				   beforeSend: function( xhr ) {
						$('.allprestataires').html('<div align="center" style="display:block; width: 100%;"><img src="{{ asset('/img/spinner.gif')}}" ></div>');
					},
				   success: function(response){ 
						// Add
						//$('.loaderBox').css("display", "none");
						if ($.trim(response) != 0){
							$(".allprestataires").html(response).show().fadeIn("slow");   
						}else{
							$(".allprestataires").html("<div align='center' style='display:block; margin:80px 0; width:100%'>Aucun prestataire à afficher dans cette catégorie</div>").show().fadeIn("slow"); 
							$('.allEventButton').css("display", "none");
						}

				   }
			  });			
			
			


		})
 
	 	$('.nav-link.slick-slide').on('click', function () {
			 	var cat=$(this).data("cat");
				$("#nav-tab .nav-item").each(function( index ) {
					$(this).removeClass("slick-active active show");
				    console.log( index + ": " + $( this ).text()+" --"+cat );
				});			 
		});
});

</script>
@endsection
		
{{--@section('pageScript')
    <script type="text/javascript" src="{{ asset('/js/events/event-save-share.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
			
			$("#nav-tab .nav-item").on("click", function(){
                $('#start').val('0');
                var start = $('#start').val(); 
 
                var cat=$(this).data("cat");
                $('.allEventButton').css("display", "block");
                $.ajax({
                       url:"{{ route('eventsbycats')}}",
                       data: {page:start, cat:cat},
                       method: 'GET',   
                       beforeSend: function( xhr ) {
                            $('.alleventcontainer').html('<div align="center" style="display:block; width: 100%;"><img src="{{ asset('/img/spinner.gif')}}" ></div>');
                        },
                       success: function(response){ 
                            // Add
                            //$('.loaderBox').css("display", "none");
                            if ($.trim(response) != 0){
                                $(".alleventcontainer").html(response).show().fadeIn("slow");   
                            }else{
                                $(".alleventcontainer").html("<div align='center' style='display:block; margin:80px 0; width:100%'>Aucun évènement à afficher dans cette catégorie</div>").show().fadeIn("slow"); 
                                $('.allEventButton').css("display", "none");
                            }

                       }
                  });
                 
                
            })
			
            /* $('#home-search-form input[type="submit"]').on('click', function() {
              var i = 0;
              var selectEnfants = $('#home-search-form select[name="event_country"]').children();
              var selectNombreEnfant = selectEnfants.length;
            }); */

           /* $("ul").on("click", ".init", function() {
                $(this).closest("ul").children('li:not(.init)').toggle();
            });

            var allOptions = $("ul").children('li:not(.init)');
            $("ul").on("click", "li:not(.init)", function() {
                allOptions.removeClass('selected');
                $(this).addClass('selected');
                $("ul").children('.init').html($(this).html());
                allOptions.toggle();
            });
*/
            $('#forPaysContent').hide();
            $('#forCatContent').hide();


            $('#forPays').on('mousedown', function(event){
                $('#forPaysContent').toggle();
            });
            $('#forCat').on('mousedown', function(event){
                $('#forCatContent').toggle();
            });

            /*  if(!$(event.target).closest('#forDateContent')){
               $('#forDateContent').hide()
             }*/

            $("#forPaysContent a").on('click', function() {
                var inputValue = $(this).text();
                $('#forPays').val(inputValue);
                $('#forPays').val().replace(' ','');

            });
            $("#forCatContent a").on('click', function() {
                var inputValue = $(this).text();
                $('#forCat').val(inputValue);
                $('#forCat').val().replace(' ','');
            });


            var div_cliquable1 = $('#forCat');
            $(document.body).click(function(e) {
                // Si ce n'est pas #ma_div ni un de ses enfants
                if( !$(e.target).is(div_cliquable1) && !$.contains(div_cliquable1[0],e.target) && !$(e.target).is($('#forCatContent')) && !$.contains($('#forCatContent')[0],e.target)) {
                    $('#forCatContent').hide(); // masque #ma_div en fondu
                }
            });

            var div_cliquable2 = $('#forPays');
            $(document.body).click(function(e) {
                // Si ce n'est pas #ma_div ni un de ses enfants
                if( !$(e.target).is(div_cliquable2) && !$.contains(div_cliquable2[0],e.target) && !$(e.target).is($('#forPaysContent')) && !$.contains($('#forPaysContent')[0],e.target)) {
                    $('#forPaysContent').hide(); // masque #ma_div en fondu
                }
            });

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
        });
    </script>

    <script>
        $('.cat-icons').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            autoplay: false,
            lazyLoad: 'ondemand',
            autoplaySpeed: 3500,
            prevArrow: "<button type='button' class='slick-prev'></button>",
            nextArrow: "<button type='button' class='slick-next slick-arrow'></button>",
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        arrows: true,
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
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

   
    <script>
        $('.slider-home').slick({
            dots: false,
            autoplay: true,
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            prevArrow: "<button type='button' class='slick-prev'></button>",
            nextArrow: "<button type='button' class='slick-next slick-arrow'></button>"
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
        </div>
    <!-- SHARE EVENT MODEL -->
@endsection--}}
