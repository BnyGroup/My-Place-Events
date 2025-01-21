@inject(eventsData,'App\Gadget')
@inject(eventCat,'App\EventCategory')

@extends($theme)

@section('meta_title',setMetaData()->e_list_title)
@section('meta_description',setMetaData()->e_list_desc)
@section('meta_keywords',setMetaData()->e_list_keyword)
 
@section('content')



<style>
	 
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
 
 
@include('theme.gadgets.shop-header') 	

<?php
	if(auth()->guard('frontuser')->check()){
		$userid = auth()->guard('frontuser')->user()->id;
	}else{
		$userid='';
	}
?>
<div class="pre-top-sellers pre-slick pro-content" style="margin-bottom: 30px; margin-top: 0px;">
	
	<div class="container">
		 
		<section class="page-title page-title- fil-ariane-light">
			<div class="container">
				<div class="row">
					<?php /*?><div class="col-sm-12 text-center">
						<h2 class="default-color " style="margin-top: 24px;">{{ $event->event_name }}</h2>
					</div><?php */?>

					<div class="breadcrumb breadcrumb-2 text-left">
						<p id="breadcrumbs"><span><span><a href="{{ url('/') }}">@lang('words.nav_bar.nav_bar_menu_1')</a> / <span><a href="{{ url('shop') }}">Boutique</a> / <strong class="breadcrumb_last primary-color" aria-current="page"> {{$product->title}} </strong></span></span></span></p>
					</div>

				</div>
				<!--end of row-->
			</div>
			<!--end of container-->
		</section>
		
		<div class="row">
			<div class="col-12">
				
<?php
    $product_img_url = null;
    $product_image = get_attachment_image_by_id($product->image,"full", false);
    $product_img_url = !empty($product_image) ? $product_image['img_url'] : '';
?>				

<div class="shop-details-area-wrapper">
    <div class="container">
        <div class="row">
				<div class="col-lg-7">
					<div class="shopsinglerow">
						<div class="product-view-wrap bgprod">
							<div class="col-lg-3 shop-details-gallery-slider" id="myTabContent">
								<div class="single-main-image">

									<a href="<?php echo e(get_image_url($product->image)); ?>" class="long-img magnific mpeshop" data-key="1" data-lightbox="mpeshop" data-title="Image">
										<i class="las la-search-plus"></i>
    									<?php echo render_image_markup_by_attachment_id($product->image, 'img-fluid', 'thumbnail'); ?>
									</a>


								</div>
								<?php
									$product_image_gallery = $product->product_image_gallery && $product->product_image_gallery != 'null'
																? json_decode($product->product_image_gallery, true)
																: [];
								?>
								<?php if($product_image_gallery && count($product_image_gallery)): ?>
									<?php $__currentLoopData = $product_image_gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery_image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<div class="single-main-image">

										<a href="<?php echo e(optional(get_attachment_image_by_id($gallery_image, 'full'))['img_url']); ?>" data-title="Image"  data-lightbox="mpeshop"
										class="long-img magnific mpeshop" data-key="<?php echo e($loop->iteration + 1); ?>"><i class="las la-search-plus"></i>
										    <?php echo render_image_markup_by_attachment_id($gallery_image, 'img-fluid', 'thumbnail'); ?> </a>

									</div>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?>
							</div>

							<div class="col-lg-9 thumb-wrap">
									<?php if(!empty($product->badge)): ?>
										<span class="sale"><?php echo e($product->badge); ?></span>
									<?php endif; ?>
									<a class="thumb-link" aria-selected="true">
										<?php echo render_image_markup_by_attachment_id($product->image, '', 'thumbnail'); ?>
									</a>                                          
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-5">

					<div class="product-summery">
						<h2 class="prodtitle"><?php echo $product->title ?></h2>
						<?php if($avg_rating): ?>
						<div class="rating-wrap">
							<div class="ratings">
								<?php for($i = 0; $i < $avg_rating; $i++): ?>
									<i class="las la-star icon"></i>
								<?php endfor; ?>
								<?php for($i = $avg_rating; $i < 5; $i++): ?>
									<i class="lar la-star icon"></i>
								<?php endfor; ?>
							</div>
							<p class="total-ratings">(<?php echo e($ratings->count() .' '. __('votes')); ?>)</p>
						</div>
						<?php endif; ?>
						<?php
						$campaign_product = getCampaignProductById($product->id);
						$sale_price = $campaign_product ? $campaign_product->campaign_price : $product->sale_price;
						//$deleted_price = $campaign_product ? $product->sale_price : $product->price;
						if($product->sale_price != $product->price){ $deleted_price = $product->price; }
						$campaign_percentage = $campaign_product ? getPercentage($product->sale_price, $sale_price) : false;
						?>
						<div class="price-wrap">
							<span class="price" data-main-price="<?php echo e($sale_price); ?>" id="price"><?php echo e(float_amount_with_currency_symbol($sale_price)); ?></span>
							<?php if(!empty($deleted_price) && $deleted_price != 0): ?>
							<del class="del-price"><?php echo e(float_amount_with_currency_symbol($deleted_price)); ?></del>
							<?php endif; ?>
							<?php if($campaign_percentage): ?>
								<span class="discount-tag">-<?php echo e(round($campaign_percentage, 2)); ?>%</span>
							<?php endif; ?>
						</div>
						<div class="short-description">
							<p class="info"><?php echo e($product->summary); ?></p>
						</div>

						<div class="user-select-option">
							<?php if($product->attributes && $product->attributes != 'null'): ?>
								<?php $product_attributes = decodeProductAttributes($product->attributes); ?>
								<?php $__currentLoopData = $product_attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<div class="size section attribute_row">
									<span class="name"><?php echo e($attribute['name']); ?></span>
									<div class="checkbox-color ">
										<?php $__currentLoopData = $attribute['terms']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<div class="single-checkbox-wrap attribute">
												<label>
													<input type="radio" name="attr_<?php echo e($attribute['name']); ?>" data-attr="<?php echo e(json_encode($term)); ?>" data-attr-image="<?php echo e(isset($term['attribute_image']) ? get_image_url($term['attribute_image']) : ''); ?>" class="checkbox">
													<span data-name="<?php echo e($attribute['name']); ?>" data-extra="<?php echo e($term['additional_price']); ?>" class="size-code">
														<?php echo e($term['name']); ?> <?php if(isset($term['additional_price']) && $term['additional_price'] > 0): ?> (+<?php echo e(float_amount_with_currency_symbol($term['additional_price'])); ?>) <?php endif; ?>
													</span>
												</label>
											</div>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</div>
								</div>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

								<div class="size section attribute_row my-4">
									<button class="btn btn-sm clear-attributes">Effacer</button>
								</div>
							<?php endif; ?>

							<?php
								$item_in_stock = optional($product->inventory)->stock_count;
							?>
							<div class="product_related_info mt-5">
								<?php if($item_in_stock): ?>
									<?php $item_stock_count = $item_in_stock ?? 0; ?>
									<div class="text-success"><span>(<?php echo e($item_stock_count.') '.Str::plural('article', $item_stock_count). ' ' . __('disponible en stock')); ?></span></div>
								<?php else: ?>
									<div class="text-secondary text-danger"><span>(<?php echo e(__('L\'article n\'est pas disponible en stock')); ?>)</span></div>
								<?php endif; ?>
							</div>

							<div class="quantity-add-cart add_to_cart_info mt-4">
								<?php if($item_in_stock): ?>
									<div class="quantity">
										<div class="input-group w-200 d-flex justify-content-between">
											<button class="prd-quantity-btn btn btn-outline-info" data-button-type="minus"><i class="fa fa-minus"></i></button>
											<input class="form-control quantity" id="quantity" type="text" min="1" max="10000000" value="1">
											<button class="prd-quantity-btn btn btn-outline-info" data-button-type="plus"><i class="fa fa-plus"></i></button>
											<a class="addtocart btn add_to_cart" data-id="{{$product->id}}" href="" tabindex="0">Ajouter <i class="fa fa-shopping-basket" aria-hidden="true"></i></a>
										</div>
									</div>
									<?php /*?><div class="cart-option mt-4">
										<a href="#" data-id="<?php echo e($product->id); ?>" class="cart add_to_cart"><?php echo e(__('add to cart')); ?></a>
										<a href="#" data-id="<?php echo e($product->id); ?>" class="cart add_to_wishlist"><?php echo e(__('wishlist')); ?></a>
										<a href="#" data-id="<?php echo e($product->id); ?>" class="cart add_to_compare_ajax"><?php echo e(__('Compare')); ?></a>
										<a href="#" data-id="<?php echo e($product->id); ?>" class="cart buy_now"><?php echo e(__('Buy Now')); ?></a>
									</div><?php */?>
								<?php endif; ?>
							</div>
						</div>


						<div class="product-attr-container mt-4">
							<?php if($product->category && $product->category->id): ?>
								<div class="product-attr">
									<?php echo e(__('Catégorie: ')); ?>

									<a href="<?php echo e(route('shop_cat.details', $product->category->id)); ?>">
										<?php echo e(optional($product->category)->title); ?>
									</a>
								</div>
							<?php endif; ?>

							<?php $all_subcategory_arr = getAllProductSubcategory($product); ?>
							<?php if($all_subcategory_arr && count($all_subcategory_arr)): ?>
								<div class="product-attr">
									<?php echo e(__('Sous-catégorie: ')); ?>

									<?php $__currentLoopData = $all_subcategory_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php
											$seperator = $key != count($all_subcategory_arr) - 1 ? ',' : '';
										?>
										<a href="<?php echo e($subcategory['url'] ?? ''); ?>"><?php echo e($subcategory['name'] . $seperator); ?></a>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</div>
							<?php endif; ?>

							<?php /*if($product->inventory): ?>
								<div class="product-attr">
									<?php echo e(__('SKU: ')); ?><?php echo e(optional($product->inventory)->sku); ?>

								</div>
							<?php endif;*/ ?>
						</div>

						<div class="social-link mt-4">
							<div class="col-sm-12 defaultButton row" style="margin: 20px 0px; padding: 0px;">
							
								<div class="col-sm-12" style="display: flex; padding: 0px"> 
									<div class="col-sm-2" style=" padding: 0px;">
											@if(is_null(getbookmark($product->id, $userid)))
												<div class="box-icon likebox" id="userlike-{{$product->id }}">
													<a href="javascript:void(0)" id="save-event" class="save-event-2" data-user="{{$userid}}"
													   data-event="{{ $product->id }}" data-mark="0">
														@if(is_null(getbookmark($product->id, $userid)))
															<i class="far fa-heart"></i>
														@else
															<i class="fas fa-heart"></i>
														@endif
													</a> 
												</div>
											@else
												<div class="box-icon likebox addedbm" id="userlike-{{$product->id }}">
													<a href="javascript:void(0)" id="save-event" class="save-event-2" data-user="{{$userid}}"
													   data-event="{{ $product->id }}" data-mark="0">
														@if(is_null(getbookmark($product->id , $userid)))
															<i class="far fa-heart"></i>
														@else
															<i class="fas fa-heart"></i>
														@endif
													</a> 
												</div>

											@endif
									 </div>
									<div class="col-sm-2" style=" padding: 0px;">
										<div class="box-icon sharebox">
											<a href="javascript:void(0)" class="event-share" data-url="{{route('shop_item.details',$product->id)}}" data-name="{{ $product->title }}" data-loca="">
												 <i class="fas fa-share"></i>
											</a> 
										</div>
									</div>	

								</div>	
								<?php /*?><br style="clear: both;">
								<div class="col-sm-6" style="margin-top: 20px; padding: 0px;">
									<div style="font-size: 10px; display: table;line-height: normal">
										<div class="box-icon kdobox" style="float: left">
											<img src="{{ url('public/img/kdo.svg') }}" class="kdosvg" id="kdosvg" alt=""/>
										</div>
										<span class="kdoboxspan">* Un masque COVID offert aux participants qui Réservent leur stand avant le 10 Février</span>
									</div>

									 

									<div style="font-size: 10px; margin-top: 15px; line-height: normal">
										<div class="box-icon edari" style="float: left">
											<img src="{{ url('public/img/edari.svg') }}" class="edarisvg" id="EDari" alt=""/>
										</div>
										<span class="kdoboxspan"><b style="font-size: 12px">E.DARI</b><br> Remportez 120 Cauris avec ce ticket</span>
									</div>
								</div><?php */?>
							</div>
							<?php /*?><ul class="list">
								<?php echo single_post_share(route('shop_item.details', $product->id), $product->title, $product_img_url); ?>

							</ul><?php */?>
						</div>
					</div>
				</div>
        </div>
		
        <div class="row" style="margin-top: 30px;">
            <div class="col-lg-12">
                <div class="product-details-tab">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                                role="tab" aria-controls="pills-home" aria-selected="true"><?php echo e(__('Description')); ?></a>
                        </li>
                        <?php if($product->additionalInfo && $product->additionalInfo->count()): ?>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                                role="tab" aria-controls="pills-profile" aria-selected="false"><?php echo e(__('Informations Complémentaires')); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php /*?><li class="nav-item">
                            <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact"
                                role="tab" aria-controls="pills-contact" aria-selected="false"><?php echo e(__('Avis')); ?></a>
                        </li><?php */?>
                    </ul>
                    <div class="tab-content prod" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <div class="description">
                                <?php echo $product->description; ?>

                            </div>
                        </div>
                        <?php if($product->additionalInfo && $product->additionalInfo->count()): ?>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <div class="aditional-info">
                                <h4 class="title"><?php echo e(__('Informations Complémentaires')); ?></h4>
                                <div class="table-wrap">
                                    <table class="add-info">
                                        <tbody>
                                            <?php $__currentLoopData = $product->additionalInfo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $additionalInfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                            <tr>
                                                <th><?php echo e(optional($additionalInfo)->title); ?></th>
                                                <td>
                                                    <p><?php echo e(optional($additionalInfo)->text); ?></p>
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                            aria-labelledby="pills-contact-tab">
                            <!-- feedback area start -->
                            <div class="feedback-section">
                                <?php if($user_has_item): ?>
                                <div class="feedback">
                                    <h4 class="feedback-title"><?php echo e(__('Laisser un commentaire')); ?></h4>
                                    <form method="POST" action="<?php echo e(route('ratings.store')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <div class="form-group">
                                            <label><?php echo e(__('Ratings')); ?></label>
                                            <input type="number" name="rating" class="rating text-warning" />
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="id" value="<?php echo e($product->id); ?>">
                                            <label for="comment"><?php echo e(__('Votre Avis')); ?>&nbsp;
                                                <span class="required">*</span>
                                            </label>
                                            <textarea class="form-control" name="comment" id="comment" required></textarea>
                                        </div>
                                        <button type="submit" class="default-btn"><?php echo e(__('Soumettre')); ?></button>
                                    </form>
                                </div>
                                <?php endif; ?>
                                <div class="feedback">
                                    <h4 class="feedback-title"><?php echo e(__('Avis des Clients')); ?></h4>
                                    <?php if(!auth()->guard('frontuser')->user()): ?>
                                    <div class="row">
                                        <div class="col-sm-6 ">
                                            <form action="<?php echo e(route('user.login')); ?>" method="post" class="register-form" id="login_form_order_page">
                                                <?php echo csrf_field(); ?>
                                                <div class="error-wrap"></div>
                                                <div class="row">
                                                    <div class="form-group col-12">
                                                        <label for="login_email"><?php echo e(__('Username')); ?>

                                                        <span class="ex">*</span></label>
                                                        <input class="form-control" type="text" name="username" id="login_email" required />
                                                    </div>
                                                    <div class="form-group col-12">
                                                        <label for="login_password"><?php echo e(__('Password')); ?><span class="ex">*</span></label>
                                                        <input class="form-control" type="password" name="password" id="login_password" required />
                                                    </div>
                                                    <div class="form-group form-check col-12">
                                                        <input type="checkbox" name="remember" class="form-check-input" id="login_remember">
                                                        <label class="form-check-label" for="remember"><?php echo e(__('Remember me')); ?> </label>
                                                    </div>
                                                </div>
                                                <div class="btn-pair">
                                                    <div class="btn-wrapper">
                                                        <button type="button" class="default-btn" id="login_btn"><?php echo e(__('SIGN IN')); ?></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <div class="client-feedback">
                                        <ul class="client-feedbck-list">
                                            <?php $__empty_1 = true; $__currentLoopData = $ratings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rating): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <li class="single-feedback mb-5">
                                                <h5 class="client-name"><?php echo e(optional($rating->user)->name); ?></h5>
                                                <p class="publish-date"> <?php echo e(optional($rating->created_at)->format('D m, Y')); ?></p>
                                                <div class="rating-box">
                                                    <a href="#">
                                                        <?php for($i = 0; $i < $rating->rating; $i++): ?>
                                                        <i class="las la-star"></i>
                                                        <?php endfor; ?>
                                                    </a>
                                                </div>
                                                <p class="comment"><?php echo e($rating->review_msg); ?></p>
                                            </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <h4 class="text-secondary"><?php echo e(__('No rating to show yet, Login to leave ratings')); ?></h4>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- feedback area end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- shop details area start -->				
				
				
				
				

<!-- related item area start -->
<div class="related-item-area-wrapper new-collection-area-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="section-title-wrapper content-title">
                    <h2 class="top-presta section-title"><?php echo e(__('VOUS AIMERIEZ AUSSI')); ?></span></h2>
                </div>
            </div>
        </div>
        <div class="row">
			<div class="col-lg-12 product4-carousel-js">           
				<?php $__empty_1 = true; $__currentLoopData = $related_products; $__env->addLoop($__currentLoopData); 
					foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
						<?php
				$catname='';
							$cat_=(array)json_decode($product['category']); 

								foreach ($cat_ as $key=>$item){
									if($key=='title')
									$catname= $item;
								}

							$pimg = get_attachment_image_by_id($product->image, 'thumbnail', true);
							$img_url = $pimg['img_url'];
							$data=$product;
						?>
						<div class="col-lg-3 productbox" id="prd-{{$product->id}}">
						  @include('theme.gadgets.shop_item') 
						</div>   

					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
					<div class="col-lg-12">
						<div class="text-center"><?php echo e(__('Aucun produit associé')); ?></div>
					</div>
					<?php endif; ?>
			</div>
		</div>
    </div>
</div>				
				
				
				
				
				
			</div>
		</div>
	</div>

</div>
@endsection

@section('pageScript')

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
	
$('.product4-carousel-js').slick({
  infinite: true,
  slidesToShow: 4,
  slidesToScroll: 1,
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
(function ($) {
    'use script'
    let site_currency_symbol = '<?php echo e(site_currency_symbol()); ?>';

    showAndHideClearButton($(".checkbox:checked").length);

    $(document).on("click",".clear-attributes",function (){
        $(".checkbox").removeAttr("checked");
        $("#price").text(site_currency_symbol + parseFloat($("#price").data("main-price")).toFixed(2));

        let old_image = $("#product-image").val();
        $(".attribute_img").attr("src",old_image);

        showAndHideClearButton($(".checkbox:checked").length);
    })

    $(document).on("click",".checkbox",function (){
        showAndHideClearButton($(".checkbox:checked").length);
    });

    // this function will show and hide clear button
    function showAndHideClearButton(length,where = $(".clear-attributes")){
        if(length < 1){
            where.fadeOut();
        }else{
            where.fadeIn();
        }
    }

    $(document).on("click",".prd-quantity-btn",function (){
        if($(this).data("button-type") === "minus"){
            updateQuantity($("#quantity").val(),$(this).data("button-type"));
        }else if($(this).data("button-type") === "plus"){
            updateQuantity($("#quantity").val(),$(this).data("button-type"));
        }
    });

    function updateQuantity(val,type){
        // plus button will add one to previous value
        if(type == "plus"){
            $("#quantity").val(parseInt(val) + 1);
        }else if(type == "minus"){
            if(parseInt(val) > 1){
                $("#quantity").val(parseInt(val) - 1);
            }else{
                $("#quantity").val(1);
            }
        }

    }

    $(document).ready(function() {
        $('.add_to_cart').on('click', function (e) {
            e.preventDefault();

            let product_id = $(this).data('id');
            let quantity = Number($('#quantity').val().trim());
            let price = $('#price').text().split(site_currency_symbol)[1];
            let attributes = {};

            // get attributes
            let rendered_attributes = $('.attribute_row');
            for (let i = 0; i < rendered_attributes.length; i++) {
                let name = $(rendered_attributes[i]).find('.name').text();
                let selected_attribute = $(rendered_attributes[i]).find('input.checkbox:checked').next().text();
                attributes[name] = selected_attribute;
            }

            attributes['price'] = price;

            let selected_attributes_arr = [];
            let all_selected_attributes = $('.attribute_row input.checkbox:checked');
            all_selected_attributes.map(function (k, v) {
                selected_attributes_arr.push($(v).data('attr'));
            });

            if (attributeSelected(attributes)) {
                $.ajax({
                    url: '<?php echo e(route("add.to.cart.ajax")); ?>',
                    type: 'POST',
                    data: {
                        product_id: product_id,
                        quantity: quantity,
                        product_attributes: selected_attributes_arr,
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
                        toastr.error('<?php echo e(__("An error occurred")); ?>');
                    }
                });
            } else {
                toastr.error('<?php echo e(__("Select all attribute to proceed")); ?>');
            }
        });

    });

    function refreshShippingDropdown() {
        $.ajax({
            url: '<?php echo e(route("cart.info.ajax")); ?>',
            type: 'GET',
            success: function (data) {
                $('#cart_badge').text(data.item_total);
                $('#top_minicart_container').html(data.cart);
            },
            erorr: function (err) {
                toastr.error('<?php echo e(__("An error occurred")); ?>');
            }
        });
    }

     
})(jQuery)
</script>
<style>
.moreM{
    display:none !important;
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
<script>
 $(document).ready(function(){
		var element_=$('.product4-carousel-js');
		element_.each(function(i, obj) {
			var top=$(this).find('.col-lg-12');
			console.log("Div-"+i);			 
			console.log("xxx : "+top.length);
			if(top.length==1){
				var el = element_.eq(i);
				el.addClass('opny');
			}
		});
	 
	 	element_.each(function(i, obj) {
			var top=$(this).find('.col-lg-3');
			console.log("Div-"+i);			 
			console.log("xxx : "+top.length);
			if(top.length==1){
				var el = element_.eq(i);
				el.addClass('opny');
			}
		});

    });	
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
 

  <link rel="stylesheet" href="{{ asset('/default/lightbox.css') }}">
  <script src="{{ asset('/default/lightbox.js') }}"></script>


    <script type="text/javascript">
		 
		$('.long-img').on('hover', function (){
		    var lk=$(this).attr("href");
		    console.log(lk);
		    $('.thumb-link img').attr("src",lk);
		    
		})
		 
		$(document).on('click', '.addtocart', function (e) {
                e.preventDefault();
                let product_id = $(this).data('id');
                let quantity = Number($('#quantity').val().trim());
                $.ajax({
                    url: '<?php echo e(route("add.to.cart.ajax")); ?>',
                    type: 'POST',
                    data: {
                        product_id: product_id,
                        quantity: quantity,
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
                    <h5 class="modal-title" id="exampleModalLabel">Acheter un article</h5>

                    <p class="modal-text">Connectez-vous ou inscrivez-vous pour acheter des articles dans la boutique .</p>

                    <div class="model-btn">
                        <a href="openRegisterBox()"
                           class="btn pro-choose-file text-uppercase">@lang('words.save_eve_signin_btn')</a>

                        <p class="modal-text-small">
                            @lang('words.save_eve_login_txt') <a
                                    href="javascript:openConnexinBox()">@lang('words.save_eve_login_btn')</a>
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

