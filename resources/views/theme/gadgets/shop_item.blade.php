<div class="mbg"></div>
<div class="product">
  <article>
	<div class="pro-thumb">

	  <a href="{{route('shop_item.details',$data->id)}}"><img class="img-fluid" src="{{ $img_url }}" alt="Product-Image"></a>

	  <div class="badges">
		<?php if(!empty($data->badge)){ ?>
		<div class="badge badge-info">
		  {{$data->badge}}
		</div>
		<?php } ?>

	  </div>

	</div>
	<div class="pro-info">

		<div class="pro-heading-with-icon">
			<h3 ><a href="{{route('shop_item.details',$data->id)}}">{{ $data->title }}</a></h3>
		</div>

		<div class="pro-info">
			<a href="{{route('shop_cat.details',$data->category)}}">{{$catname}}</a>                
		</div>       

		<div class="pro-heading-with-icon align-items-center">
			  <div class="pro-rating">
				<i class="fas fa-star"></i>
				<i class="fas fa-star"></i>
				<i class="fas fa-star"></i>
				<i class="fas fa-star"></i>
				<i class="fas fa-star-half-alt"></i>
			  </div>                                          
		</div>
		<div class="pro-price">    
		  <ins>
			{{ amount_with_currency_symbol($data->price) }}
		  </ins>  
		</div>
		<div class="howHover">
			<a class="addtocart btn" data-id="{{$data->id}}" href="">Ajouter au panier <i class="fa fa-shopping-basket" aria-hidden="true"></i></a>
			<a href="javascript:void(0)" data-toggle="tooltip" id="save-event" class="save-event likeprod">
				<i class="fas fa-heart"></i>
			</a>	
		</div>
		
	</div>    
  </article>
</div>