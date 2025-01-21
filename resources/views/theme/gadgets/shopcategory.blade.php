@inject(eventsData,'App\Gadget')
@inject(eventCat,'App\EventCategory')

@extends($theme)

@section('meta_title',setMetaData()->e_list_title)
@section('meta_description',setMetaData()->e_list_desc)
@section('meta_keywords',setMetaData()->e_list_keyword)
 
@section('content')



<style>
@media  screen and (max-width: 600px){
	.opny{
		margin-top: 20px;
	}
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

	
.pre-top-sellers .product{
	background: #FFFFFF padding-box;
	border-radius: 11px;
	padding: 15px;
}
.product article .pro-thumb .badges {
    position: absolute;
    left: 30px;
    top: 10px;
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
 
 
 		@include('theme.gadgets.shop-header') 	


<div class="pre-top-sellers pre-slick pro-content" style="margin-bottom: 30px">
	
	<div class="container">
		<div class="row bannertop">
			<img src="{{asset('/assets/uploads/bantop.png')}}">
		
		</div>
		 <div class="row">
			  <div class="col-lg-6 content-title">
				<h1 style="margin-bottom: 0; margin-top: 0px " class="top-presta section-title"><a href="#">{{ $PCategory->title }}</a></h1>
			  </div>
			 <div class="col-lg-6 " style="text-align: right">
			 	<form action="" method="get">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div style="padding: 10px 35px; color:#00024F; background-color: #FFFFFF; font-weight: 500; border-radius: 57px;display: inline-block;">Trier par : 
						<select name="filter" style="border-radius: 50px; padding: 2px 15px; border:1px solid #d2d2d2">
							<option value="rated">Les plus demandés</option>
							<option value="asc">Prix croissant</option>
							<option value="desc">Prix décroissant</option>
							<option value="new">Nouvel arrivage</option>
							<option value="rated">Les mieux notés</option>
						 </select>
					</div>
				 </form> 
			 </div>
		</div>
		<div class="row opny">
			<div class="col-12">
				<div class="product4-carousel-js arrow-style3 border-product slider-nav row">
					<?php
					       foreach($allProducts as $data){ 
									$cat_=(array)json_decode($data['category']); 
									 
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
@endsection

@section('pageScript')

  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<style>
.moreM{
    display:none !important;
}    
</style>
<script>
$(document).ready(function(){
        var pp=0;
		$('ul.catMenu li:not(.moreM)').each(function(i) {
            var l = $(this), p = l.position();
			var e=l.text()
			var m=0; 
			if(p.top>=5){
				pp=pp+(70);
				l.addClass('listMore');
				l.css('top',pp+'px')
				l.css('display','none')
				$('.moreM').removeClass('listMore');
				$('.moreM').attr("style","display: inline-block;position: absolute;top: 0px;right: -10px;");
				m++;
			}
			if(m===0){
			    $('.moreM').removeClass('listMore');
				$('.moreM').attr("style","display: inline-block;position: absolute;top: 0px;right: -10px;");
				console.log(m+"-- oo --\n");
			}
            /*ul.css({'height':(h*3)+'px','overflow':'hidden'});
            $(this).siblings('.control').addClass('closed');
            $(this).siblings('.control').html('<a href="#">open</a>');*/
        });
	
	
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
 

    <script type="text/javascript">
		 
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

