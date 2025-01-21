@extends($theme)
@inject(eventsData,'App\Gadget')
@inject(eventCat,'App\EventCategory')
@section('meta_title',setMetaData()->e_list_title)
@section('meta_description',setMetaData()->e_list_desc)
@section('meta_keywords',setMetaData()->e_list_keyword)


@section('content')


@include('theme.gadgets.shop-header') 


<!-- Slider Revolution CSS Files -->
<link rel="stylesheet" type="text/css" href="{{ url('public/revolution/css/settings.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('public/revolution/css/layers.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('public/revolution/css/navigation.css') }}">

<style>
.rev-section{
	margin: 40px 0 0px 0;
}
.rev-section .banners figure {
    margin-bottom: 30px;
}
.banners .banner-image img {
    width: 100%;
}
.banner-text {
    position: absolute;
    top: 10px;
    margin-left: 15px;
    padding: 21px 10px;
    margin-right: 15px;
    width: 87%;
    display: block;
    height: 75%;
}
.banner-text h2 {
    color: #fff;
}
.banner-text p{
    font-size: 12px;
    color: #fff;
	letter-spacing: normal
}
.banner-text h2, .banner-text h3 {
	font-family: "Poppins-Bold", sans-serif;
    font-size: 35px;
    text-align: left;
    font-weight: bold;
}
.banner-text .btn{
	margin-top: 20px;
    border-radius: 60px;
    padding: 9px 21px;
    width: auto;
    min-width: auto;
    letter-spacing: normal;
    background: #FCBD0D;
    height: auto;
    min-height: auto;
    line-height: normal;
	color: #000D8B
}	
.btn:not(:disabled):not(.disabled) {
    cursor: pointer;
}
.btn-light {
    -webkit-transition-duration: 0.3s;
    transition-duration: 0.3s;
    -webkit-transition-property: color, background-color;
    transition-property: color, background-color;
    background-color: var(--light);
    border-color: var(--light);
    color: var(--text-color-light);
}	
	#rev_slider_1077_2_wrapper{
		overflow: hidden !important; 
		height: 427px !important;
		border-radius: 8px;
	}	
#rev_slider_1077_2_wrapper .hesperiden.tparrows {
	width: 80px;
	height: 80px;
	top: 66% !important;
    background: rgba(0,0,0,0) !important;
	border: 1px solid #FFFFFF;
}
#rev_slider_1077_2_wrapper .hesperiden.tparrows:before{
    line-height: 84px !important;
    font-size: 45px;
    margin-left: 0px !important;
	color: #FEB00A !important
}	
@media screen and (max-width: 601px){
    #rev_slider_1077_2_wrapper .tp-leftarrow.tparrows.hesperiden{
		left: 60% !important;
	}
    #rev_slider_1077_2_wrapper .tp-rightarrow.tparrows.hesperiden{
		left: 76% !important;
	}	
}
	#rev_slider_1077_2_wrapper .BigBold-Button.rev-btn {
		border-radius: 50px !important;
		background: #FCBD0D !important;
		color:#000D8B !important;
		letter-spacing: normal !important;
		border: unset  !important;
	}
.pre-top-sellers .product{
	background: #FFFFFF padding-box;
	border-radius: 11px;
	padding: 15px;
}
.product article .pro-thumb .badges {
    position: absolute;
    left: 20px;
    top: 17px;
}	
.product article .pro-thumb .badges .badge {
    display: inline-block;
    margin-bottom: 14px;
    margin-right: 5px;
}
.product article .badge {
    font-size: 10px;
    font-weight: normal;
    border-radius: 3px;
    margin-bottom: 5px;
}
.product article .badge-info {
    color: #fff !important;
    background-color: #001C96 !important;
}
.product article .badge {
    display: inline-block;
    padding: 5px 10px;
    font-weight: 600;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 5px;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
	min-width: auto;
    height: auto;
}
.product article .pro-thumb .badges .badge:last-child {
    margin-bottom: 0;
    margin-right: 0;
}	
.product article .pro-info span{
    margin-top: 15px;
    margin-bottom: 0px;
	font-size: 12px;
	letter-spacing: normal
}	
.product article .pro-info h3 a:focus, .product article .pro-info h3 a:hover {
    outline: none;
    color: #001C96;
}	
.product article .pro-info h3 a {
    color: #D600A9;
    text-decoration: none;
    text-decoration: none;
    white-space: normal;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
	font-size: 20px;
    font-weight: bold;
}	
.product article .pro-info .pro-price {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.product article .pro-info .pro-price ins {
    font-size: 21px;
    color: #000;
    text-decoration: none;
    margin-right: 10px;
	letter-spacing: normal !important;
	font-weight: bold
}	
	
.pro-content .product article .pro-heading-with-icon {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}
	
.pro-rating i{
	margin-right: 0px !important
}
	
.pro-rating{
	margin: 10px 0px;
}
	
.align-items-center {
    align-items: center !important;
}
	.pro-content .product article .pro-heading-with-icon .pro-rating .fa-star, .pro-content .product article .pro-heading-with-icon .pro-rating .fa-star-half-alt {
    color: #FEB00A;
}
.product article .pro-info .pro-price del {
    font-size: 0.875rem;
    color: #FEB00A;
    text-decoration: line-through;
}	
	.pro-thumb .img-fluid{
		max-height: 290px
	}	
</style>
<div class="rev-section">
            <div class="container">
              <div class="row">
                <div class="col-lg-8 col-12">
                  <div class="carousel-content arrow-rev">
                    <div class="container-fuild">
                      <div id="rev_slider_1077_2_wrapper" class="rev_slider_wrapper fullscreen-container" data-alias="scroll-effect136" data-source="gallery" style="padding: 0px; overflow: hidden; height: 427px; display: block;">
                         <!-- START REVOLUTION SLIDER 5.4.1 fullscreen mode -->
                          <div id="rev_slider_1077_4" class="rev_slider fullscreenbanner" style="display:none;" data-version="5.4.1">
                            <ul>
                             <?php 
                             $x=0;
                              foreach($banMain as $bm){
                                   $imbm=getImage($bm->image);
                             ?>
                              <!-- SLIDE x -->
                              <li data-index="rs-2042{{ $x }}" data-transition="slideoverhorizontal" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off" 
                              data-easein="Power4.easeInOut" data-easeout="Power4.easeInOut" data-masterspeed="1000" data-thumb=""  data-rotate="0" 
                              data-fstransition="fade" data-fsmasterspeed="1500" data-fsslotamount="7" data-saveperformance="off" 
                              data-title="Big &amp; Bold">
                              <!-- MAIN IMAGE -->
                              <img src="{{ $imbm }}"  alt=""  data-bgposition="top center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina>
                              <!-- LAYERS -->
                          
                              <div class="container" style="position: relative;">
                 
                              <!-- LAYER NR. 2 -->
                
                              <div class="tp-caption BigBold-Title tp-resizeme" 
                                id="slide-3043-layer-{{ $x }}" 
                                data-x="['left','left','left','left']" data-hoffset="['45','40','30','15']"
                                data-y="['top','top','top','top']" data-voffset="['200','180','100','65']" 
                                data-fontsize="['80','40','30','24']"
                                data-lineheight="['70','50','40','30']"
                                data-width="['90%','90%','90%','90%']"
                                data-height="none"
                                data-whitespace="['normal']"
                          
                                data-type="text" 
                                data-basealign="slide" 
                                data-responsive_offset="off" 
                          
                                data-frames='[{"from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;",
                                "mask":"x:0px;y:[-100%];s:inherit;e:inherit;","speed":1500,"to":"o:1;",
                                "delay":600,"ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"to":"y:[-100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'
                                data-textAlign="['left','left','left','left']"
                                data-paddingtop="[0,0,0,0]"
                                data-paddingright="[0,0,0,0]"
                                data-paddingbottom="[0,0,0,0]"
                                data-paddingleft="[0,0,0,0]"
                          
                                style="z-index: 11; color:#fff; max-width:75%; text-shadow: 1px 1px 2px black; ">{{ $bm->title }}
								  <div style="color: #FFFFFF; max-width: 70%;font-size: 22px; font-weight: 500">
								  <div styl=" line-height:normal !important; "><?php $dc=$bm->description; 
    								echo substr($dc, 0,100).'...';
                                    ?></div>
								  </div>
								</div>
                          
                                 <?php 
                                    $urlx=$bm->url; if(!empty($url1)){
                                   ?> 
                                <!-- LAYER NR. 3 -->
                                <div class="tp-caption BigBold-Button rev-btn " 
                                  id="slide-3043-layer-9{{ $x }}" 
                                  data-x="['left','left','left','left']" data-hoffset="['140','110','80','15']"
                                  data-y="['top','top','top','top']" data-voffset="['280','210','200','135']" 
                                  
                                  data-height="none"
                                  data-type="button" 
                                  data-actions='[{"event":"click","action":"simplelink","target": "_self","url":"shop-4cols.html"}]'
                                  data-basealign="slide" 
                                  data-responsive_offset="off" 
                                  data-responsive="off"
                                  data-frames='[{"from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;",
                                  "speed":1500,"to":"o:1;","delay":650,"ease":"Power3.easeInOut"},
                                  {"delay":"wait","speed":1000,"to":"y:50px;opacity:0;","ease":"Power2.easeInOut"},
                                  {"frame":"hover","speed":"300","ease":"Power1.easeInOut",
                                  "to":"o:1;rX:0;rY:0;rZ:0;z:0;",
                                  "style":"c:rgba(255, 255, 255, 1.00);bc:rgba(255, 255, 255, 1.00);bw:1px 1px 1px 1px;"}]'
                                  data-textAlign="['center','center','center','center']"
                                  data-paddingtop="[13,13,13,13]"
                                  data-paddingright="[25,25,25,25]"
                                  data-paddingbottom="[13,13,13,13]"
                                  data-paddingleft="[25,25,25,25]"
                            
                                  style="z-index: 13; text-transform: uppercase; box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;cursor:pointer; border-radius: 3px;">Voir détails <i class="fa fa-shopping-basket" aria-hidden="true"></i></div>
                                    <?php } ?>    
                              </div>
                            </li>
                             <?php $x++; } ?>            
                            </ul>
                          <div class="tp-bannertimer tp-bottom" style="visibility: hidden !important;"></div>	</div>
                        </div><!-- END REVOLUTION SLIDER -->
                    </div>
                </div>
                </div>
                <div class="col-lg-4 col-12">
                  <div class="row">
                    <div class="col-12 banners">
                      <div class="row">
                          <?php
                           $imThumb1=getImage($banR1->image, 'thumb'); $im1=getImage($banR1->image);
                          ?>
                        <div class="col-12 col-md-6 col-lg-12">
                          <figure class="banner-image ">
                            <div>
                              <img class="img-fluid" src="{{ $im1 }}" alt="Banner Image">
                            <div class="banner-text">
                                <div class="dhover">
                                  <div class="insideHover">
                                      <h2>{{ $banR1->title }}</h2>
    								<p><?php $d=$banR1->description; 
    								if(!empty($d)) echo substr($d, 0,100).'...';
                                    ?></p>
                                    </div>
                                  <div class="overlay"></div>
                                 </div>  
                            <?php 
                                    $url1=$banR1->url; if(!empty($url1) && $url1!="#"){
                                   ?>     
                              <a href="{{ $url1 }}" class="btn btn-light">Voir détails <i class="fa fa-chevron-right" aria-hidden="true"></i></a><?php } ?>
                            </div>
                          </div>
                          </figure>
                        </div>
                         <?php
                           $imThumb2=getImage($banR2->image, 'thumb'); $im2=getImage($banR2->image);
                          ?>
                        <div class="col-12 col-md-6 col-lg-12">
                          <figure class="banner-image ">
                            <div> 
                              <img class="img-fluid" src="{{ $im2 }}" alt="Banner Image">
                              <div class="banner-text">
                                  <div class="dhover">
                                      <div class="insideHover">
                                          <h2>{{ $banR2->title }}</h2>
        								  <p><?php  $d2=$banR2->description; 
        							    if(!empty($d2))	echo substr($d2, 0,100).'...';
                                           ?></p>
                                       </div>
                                       <div class="overlay"></div>
                                   </div>
                                   <?php 
                                    $url2=$banR2->url; if(!empty($url2) && $url2!="#"){
                                   ?>
                                <a href="{{ $url2 }}" class="btn btn-light">Voir détails <i class="fa fa-chevron-right" aria-hidden="true"></i></a><?php } ?>
                              </div>
                            </div>
                          </figure>
                        </div>
                      </div>
                    
                        <style>
                        .banner-image img{
                            border-radius: 5px;
                        }
                           .dhover{
                              display:none;   
                            }
                            .banner-image:hover .dhover{
                                display:block;
                            }
                           .banner-image:hover .dhover .overlay::before{
                                content: " ";
                                width: 108%;
                                background: rgb(0,0,0, .6);
                                display: block;
                                height: 115%;
                                position: absolute;
                                top: -10px;
                                left: -15px;
                                border-radius: 5px;
                            }
                            .insideHover{
                                position:absolute; z-index: 9;
                            } 
                            .banner-text .btn{
                                position:absolute;
                                bottom:5px;
                            }
                        </style>                    
                    
                    </div>
                  </div>
                </div> 
              </div>
              <!-- Revolution Layer Slider -->
          
            </div>
          </div>
 
<div class="pre-top-sellers pre-slick pro-content">
            <div class="container">
              <div class="row">
			  <div class="col-lg-12 content-title">
				<h1 style="margin-bottom: 0; margin-top: 0px " class="top-presta section-title"><a href="#">Top Des Ventes</a></h1>
			  </div>
			</div>
                <div class="row">
                    <div class="col-12">
                        <div class="product4-carousel-js arrow-style3 border-product .slider-nav row topcat-slide">
							
							<?php
							
								foreach($TopProducts as $data){ 
									$cat_=(array)json_decode($data['category']); 
									$catname="";
									foreach ($cat_ as $key=>$item){
										if($key=='title')
										$catname= $item;
									}
							 
								$pimg = get_attachment_image_by_id($data->image, 'thumbnail', true);
								$img_url = $pimg['img_url'];

								 
							?>
                            <div class="col-lg-3 productbox" id="prd-{{$data->id}}">
                              @include('theme.gadgets.shop_item') 
                            </div>   
							<?php } ?>
                           
                         
                        </div>
                    </div>
                </div>
            </div>
          
          
          </div>			


<div class="pre-top-sellers pre-slick pro-content" style="margin-bottom: 30px">
	
	<div class="container">
		 <div class="row">
			  <div class="col-lg-12 content-title">
				<h1 style="margin-bottom: 0; margin-top: 0px " class="top-presta section-title"><a href="#">Produits pour Concerts</a></h1>
			  </div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="product4-carousel-js arrow-style3 border-product slider-nav row topcat-slide">
					<?php
						$x=0;
					       foreach($ConcertProducts as $data){ 
									$cat_=(array)json_decode($data['category']); 
									 
									foreach ($cat_ as $key=>$item){
										if($key=='title')
										$catname= $item;
									}
							 
								$pimg = get_attachment_image_by_id($data->image, 'thumbnail', true);
								$img_url = $pimg['img_url'];

								 
					?>
                            <div class="col-lg-3 productbox" id="{{$x}}-prd-{{$data->id}}">
                              @include('theme.gadgets.shop_item') 
                            </div>   
					<?php $x++; } ?>

				</div>
			</div>
		</div>
	</div>

</div>
 @endsection

@section('pageScript')
<style>
.moreM{
    display:none !important;
}    
	.productbox {
		max-width: 100%
	}	
@media  screen and (max-width: 600px){
	.opny .slick-list.draggable .slick-track{
		transform: unset !important;
		width: 325px !important
	}
	.opny .slick-list.draggable .slick-track .productbox {
		width: 325px !important
	}
	
	.opny .slick-list.draggable{
		padding: 0px 16px !important;
	}
}	
</style>
 <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
 
<script type="text/javascript">
 $(document).ready(function(){
     // $(".slick-current.slick-active").next().css({"color": "red", "border": "2px solid red","left":"-27px"});
		var element_=$('.topcat-slide');
		element_.each(function(i, obj) {
			var top=$(this).find('.col-lg-3');
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
	$(document).on('click', '.addtocart', function (e) {
			e.preventDefault();
			let product_id = $(this).data('id');
			$.ajax({
				url: '<?php echo e(route("add.to.cart.ajax")); ?>',
				type: 'POST',
				data: {
					product_id: product_id,
					quantity: 1,
					product_attributes: [],
					_token: '<?php echo e(csrf_token()); ?>'
				},
				success: function (data) {
					toastr.success(data.msg);
					if (data.quantity_msg) {
						toastr.warning(data.quantity_msg)
					}
					refreshShippingDropdown();
				},
				erorr: function (err) {
					toastr.error('<?php echo e(__("something went wrong!! try again")); ?>');
				}
			});
		});
	
	
 
$(document).ready(function(){
    
   if ($(window).width() >= 601) 
   {  
        var pp=0;
		$('ul.catMenu li:not(.moreM)').each(function(i) {
            var l = $(this), p = l.position();
			var e=l.text()
			if(p.top>5){
 				pp=pp+(70);
				l.addClass('listMore');
				l.css('top',pp+'px')
				l.css('display','none')
				$('.moreM').removeClass('listMore');
				$('.moreM').attr("style","display: inline-block;position: absolute;top: 0px;right: -10px;");
			}
            /*ul.css({'height':(h*3)+'px','overflow':'hidden'});
            $(this).siblings('.control').addClass('closed');
            $(this).siblings('.control').html('<a href="#">open</a>');*/
        });
   }
	
		$('.productbox').on('mouseover',function(){
			var xx=$(this).attr('id');  
			$('#'+xx+' .pro-price').css("display","none");
			$('#'+xx+' .howHover').css("display","block");
		});
		$('.productbox').on('mouseout',function(){
			var xx=$(this).attr('id');  			
			$('#'+xx+' .pro-price').css("display","block");
			$('#'+xx+' .howHover').css("display","none");
		});	
});
	
$('.moreMenu').on('click',function(){  
	$( ".listMore" ).toggle();										
});

</script>
<style>
.product4-carousel-js .slick-slide img {
    max-width: 100%;
    height: auto;
}
.product4-carousel-js .slick-list.draggable {
    margin: unset;
}
</style>

<script>
    $('.topcat-slide').slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      autoplay: true,
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
          centerMode: true,
          arrows: true,
          slidesToShow: 1,
          slidesToScroll: 1,
          focusOnSelect: true,
        }
      },
      {
        breakpoint: 380,
        settings: {
          centerMode: false,
          arrows: true,
          slidesToShow: 1,
          slidesToScroll: 1,
          focusOnSelect: true,
        }
      }
      // You can unslick at a given breakpoint now by adding:
      // settings: "unslick"
      // instead of a settings object
      ]
    });  
</script>

    <script type="text/javascript">
        $(document).ready(function () {
             $('#home-search-form input[type="submit"]').on('click', function() {
             var i = 0;
             var selectEnfants = $('#home-search-form select[name="item_country"]').children();
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
 

<!-- Slider Revolution core JavaScript files -->
<script src="{{ url('public/revolution/js/jquery.themepunch.tools.min.js') }}"></script>
<script src="{{ url('public/revolution/js/jquery.themepunch.revolution.min.js') }}"></script>

<!-- Slider Revolution extension scripts. ONLY NEEDED FOR LOCAL TESTING --> 
<script src="{{ url('public/revolution/js/extensions/revolution.extension.actions.min.js') }}"></script>
<script src="{{ url('public/revolution/js/extensions/revolution.extension.carousel.min.js') }}"></script>
<script src="{{ url('public/revolution/js/extensions/revolution.extension.kenburn.min.js') }}"></script>
<script src="{{ url('public/revolution/js/extensions/revolution.extension.layeranimation.min.js') }}"></script>
<script src="{{ url('public/revolution/js/extensions/revolution.extension.migration.min.js') }}"></script>
<script src="{{ url('public/revolution/js/extensions/revolution.extension.navigation.min.js') }}"></script>
<script src="{{ url('public/revolution/js/extensions/revolution.extension.parallax.min.js') }}"></script>
<script src="{{ url('public/revolution/js/extensions/revolution.extension.slideanims.min.js') }}"></script>

<script src="{{ url('public/revolution/js/extensions/revolution.extension.video.min.js') }}"></script>

 
<script>

// index-4
$(document).ready(function() {
    if($("#rev_slider_1077_4").revolution == undefined){
        revslider_showDoubleJqueryError("#rev_slider_1077_4");
    }else{
        revapi1077 = $("#rev_slider_1077_4").show().revolution({
            sliderType:"standard",
            jsFileLocation:"{{ url('public/revolution/js/')}}",
            //sliderLayout:"fullscreen",
            dottedOverlay:"none",
            delay:5000,
            navigation: {
                keyboardNavigation:"off",
                keyboard_direction: "horizontal",
                mouseScrollNavigation:"off",
                mouseScrollReverse:"default",
                onHoverStop:"off",
                touch:{
                    touchenabled:"on",
                    swipe_threshold: 75,
                    swipe_min_touches: 1,
                    swipe_direction: "horizontal",
                    drag_block_vertical: false
                }
                ,
                bullets: {
                    enable:false,
                    hide_onmobile:true,
                    hide_under:960,
                    style:"hesperiden",
                    hide_onleave:false,
                    direction:"horizontal",
                    h_align:"center",
                    v_align:"bottom",
                    h_offset:0,
                    v_offset:30,
                    space:5,
                    tmp:''
                }
                ,
                arrows: {
                    enable:true,
                    hide_onmobile:true,
                    style:"hesperiden",
                    hide_onleave:false,
                    direction:"horizontal",
                    h_align:"center",
                    v_align:"bottom",
                    h_offset:0,
                    v_offset:30,
                    space:5,
                    tmp:''
                }

            },
            responsiveLevels:[1400,1200,992,576],
            visibilityLevels:[1400,1200,992,576],
            gridwidth:[1280,992,576,320],
            gridheight:[734,380,300,220],
            lazyType:"none",
           
         
            shadow:0,
            spinner:"off",
            stopLoop:"on",
            stopAfterLoops:0,
            stopAtSlide:0,
            shuffle:"off",
            autoHeight:"off",
            fullScreenAutoWidth:"off",
            fullScreenAlignForce:"off",
            fullScreenOffsetContainer: "",
            fullScreenOffset: "60px",
            disableProgressBar:"on",
            hideThumbsOnMobile:"off",
            hideSliderAtLimit:0,
            hideCaptionAtLimit:0,
            hideAllCaptionAtLilmit:0,
            debugMode:false,
            fallbacks: {
                simplifyAll:"off",
                nextSlideOnWindowFocus:"off",
                disableFocusListener:false,
            }
        });
        var newCall = new Object(),
        cslide;

        newCall.callback = function() { 
        var proc = revapi1077.revgetparallaxproc(),
        fade = 1+proc,
        scale = 1+(Math.abs(proc)/10);

        punchgs.TweenLite.set(revapi1077.find('.slotholder, .rs-background-video-layer'),{opacity:fade,scale:scale});		
        }
        newCall.inmodule = "parallax";
        newCall.atposition = "start";

        revapi1077.bind("revolution.slide.onloaded",function (e) {
        revapi1077.revaddcallback(newCall);
        });				
    }
});
</script>

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

