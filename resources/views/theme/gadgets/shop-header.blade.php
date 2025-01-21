<div class="topbarShop">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 "><!-- menuByEvent-->
				<?php /*<i class="fa fa-bars" aria-hidden="true"></i>
				<span>Shopping par<br>Événements</span>
				<i class="fa fa-chevron-up righti" aria-hidden="true"></i>*/ ?>
			</div>
			<div class="col-lg-9">
			
				<ul class="catMenu">
					@foreach($ProductCategory as $cat)					
						<li><a href="{{ route('shop_cat.details', $cat->id) }}">{{$cat->title}}</a></li>
					@endforeach
					
					<?php /*?><li><a href="">Téléphones & Tablettes</a></li>
					<li><a href="">Gadgets</a></li>
					<li><a href="">Photos & Cameras</a></li>
					<li><a href="">Autres</a></li><?php */?>
					<li class="moreM"><a href="javascript:void(0)" class="moreMenu"><i class="fa fa-angle-down" aria-hidden="true"></i></a></li>
				</ul>
			</div>
		</div>

		    
		</div>
		
	</div>
</div>
<div class="downMenu pre-top-sellers pre-slick pro-content">
	<div class="container">
		
    		<div class="row">
    		    <div class="col-lg-12 ">
    		        
    		        
    		            <div class="product4-carousel-js arrow-style3 border-product slider-nav row">
        					<?php /*
        										
					$MyallProducts = \App\Product\Product::where('products.status', 'publish')
            ->where('products.category_id', '37')
            ->with('inventory')
            ->with('rating')		
			->with('category')
            ->orderBy('sold_count', 'DESC')
            ->take(10)
            ->get();
        					       foreach($MyallProducts as $data){ 
        									$cat_=(array)json_decode($data['category']); 
        									 
        									foreach ($cat_ as $key=>$item){
        										if($key=='title')
        										$catname= $item;
        									}
        							 
        								$pimg = get_attachment_image_by_id($data->image, 'thumbnail', true);
        								$img_url = $pimg['img_url'];
        
        								 
        							?>
                                    <div class="col-lg-2 productbox" id="prd-{{$data->id}}">
                                      @include('theme.gadgets.shoptopitem') 
                                    </div>   
        							<?php } */ ?>
        
        				</div>  
    		        
    		        
    		        </div>  
    		        
		        </div>
		        
		    </div>	    
	</div>
</div>
<style>
.downMenu {
    display:none;
}
.downMenu .container{
    background-color: #001c96;
    padding: 31px;
    display: block;
    text-align: left;
}
	.catMenu{
		width: 100%;
		height: 69px;
		overflow: hidden
	}
	.moreM{
		display: none
	}
	.moreM i{
		font-size: 25px;
	}
	.listMore{
		position: absolute;
		top: calc(27px + 10px);
		width: 154px;
		background-color: #fff;
		border-bottom: 1px solid #001c96;
		z-index: 999;
		right: 0px;
	}
	 
	.bannertop{
		margin: 30px 0 10px 0;
    	padding: 10px 15px;
	}
	.bannertop img{
		width: 100%;
		border-radius: 10px
	}
 	
	.col-lg-3{
		margin-bottom: 25px;
	}
</style>

@section('topPageScript')
    <script>
        $(".menuByEvent").on("hover", function(){
            var ri=$('.righti');
            if ($('.downMenu').css("display") != "block") {
                ri.removeClass("fa-chevron-up")
                ri.addClass("fa-chevron-down")
                $(".downMenu").slideToggle("slow")    
            }else{
                
            }
        });
        
        $(".downMenu .container").on("mouseenter", function(){ 
            //$(".downMenu").fadeIn("slow")    
        }).on("mouseleave", function(){ 
            $(".downMenu").slideUp("slow")    
        });    
        
        var wi=$(window).width();
        if (wi <= "600") 
		   {    
				$('.catMenu').slick({
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
    </script>
@endsection
