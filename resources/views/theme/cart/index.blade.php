@extends($theme)
@inject(eventsData,'App\Gadget')
@inject(eventCat,'App\EventCategory')
@section('meta_title',setMetaData()->e_list_title)
@section('meta_description',setMetaData()->e_list_desc)
@section('meta_keywords',setMetaData()->e_list_keyword)

@section('content')
    <style>

        .card-body {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: 1.40rem
        }

        .img-sm {
            width: 80px;
            height: 80px
        }

        .itemside .info {
            padding-left: 15px;
            padding-right: 7px
        }

        .table-shopping-cart .price-wrap {
            line-height: 1.2
        }

        .table-shopping-cart .price {
            font-weight: bold;
            margin-right: 5px;
            display: block
        }

        .text-muted {
            color: #969696 !important
        }

        a {
            text-decoration: none !important
        }

        .card {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: 0px
        }

        .itemside {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            width: 100%
        }

        .dlist-align {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex
        }

        [class*="dlist-"] {
            margin-bottom: 5px
        }

        .coupon {
            border-radius: 1px
        }

        .price {
            font-weight: 600;
            color: #212529
        }

        .btn.btn-out {
            outline: 1px solid #fff;
            outline-offset: -5px
        }

        .btn-main {
            border-radius: 2px;
            text-transform: capitalize;
            font-size: 15px;
            padding: 10px 19px;
            cursor: pointer;
            color: #fff;
            width: 100%
        }

        .btn-light {
            color: #ffffff;
            background-color: #F44336;
            border-color: #f8f9fa;
            font-size: 12px
        }

        .btn-light:hover {
            color: #ffffff;
            background-color: #F44336;
            border-color: #F44336
        }

        .btn-apply {
            font-size: 11px
        }
    </style>
    <div class="list-bg page-title-special event-list-two"><h2  style="color: #D600A9
 !important;" align="center">Mon Panier</h2></div>
    @include("theme.gadgets.gadget-search-form")
    <div class="container list-widget bg-effect"><br><br>
        @if( session()->has('danger'))
            <div class="alert alert-danger">
                {{session('danger')}}
            </div>
        @endif
    @if(Cart::count() > 0)
        <div class="container-fluid" style="margin-top: 70px">
            <div class="row">
                <aside class="col-lg-9">
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-borderless table-shopping-cart">
                                    <thead class="text-muted">
                                        <tr class="small text-uppercase">
                                            <th scope="col">Gadget</th>
                                            <th scope="col" width="120">Quantité</th>
                                            <th scope="col" width="200">Prix Unitaire</th>
                                            <th scope="col" class="text-right d-none d-md-block" width="40"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (Cart::content() as $gadget)
                                            <tr>
                                                <td>
                                                    <figure class="itemside align-items-center">
                                                        <div class="aside"><img class="rounded" src="{{ getImage($gadget->model->item1_image, 'thumb') }}" width="70" class="img-sm"></div>
                                                        <figcaption class="info"> <a href="#" class="title text-dark" data-abc="true" disabled>{{$gadget->model->item_name}}</a>
                                                            <p class="text-muted small">SIZE: &nbsp;{{$gadget->options->size}} <br> 
                                                                Color: &nbsp;{{$gadget->options->color}}</p>
                                                        </figcaption>
                                                    </figure>
                                                </td>
                                                <td> 
                                                    <select class="form-control" name="qty" id="qty" data-id="{{$gadget->rowId}}">
                                                        @for ($i = 1; $i <= 100; $i++)
                                                            <option value="{{$i}}" {{$i == $gadget->qty ? 'selected' : ''}}>{{$i}}</option>
                                                        @endfor
                                                    </select> </td>
                                                <td>
                                                    <div class="price-wrap"> <var class="price">{{number_format(floatval(preg_replace("/[^-0-9\.]/","",$gadget->subtotal())), 0,'', ' ') }} {!! use_currency()->symbol !!}</var></div>
                                                </td>
                                                <td class="text-right d-none d-md-block"> 
                                                    <form action="{{route('shop_cart.destroy', $gadget->rowId)}}" method="post">
                                                        {{ csrf_field() }}
                                                        {{ method_field('delete') }}
                                                        
                                                        <button type="submit" class="btn btn-light" data-abc="true"> Supprimer</button>
                                                    </form> 
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </aside>
                <aside class="col-lg-3">

                        <div class="card">
                            <div class="card-body">
                                <dl class="dlist-align">
                                    <dt>Sous Total:</dt>
                                    <dd class="text-right ml-3">{{number_format(floatval(preg_replace("/[^-0-9\.]/","",Cart::subtotal())), 0,'', ' ') }} {!! use_currency()->symbol !!}</dd>
                                </dl>
                                <dl class="dlist-align">
                                    
                                </dl>
                                <dl class="dlist-align">
                                    <dt>Total:</dt>
                                    <dd class="text-right text-dark b ml-3"><strong>{{number_format(floatval(preg_replace("/[^-0-9\.]/","",Cart::subtotal())), 0,'', ' ') }} {!! use_currency()->symbol !!}</strong></dd>
                                </dl>
                                <hr> 
                                {!! Form::open(['method'=>'post','route'=>'cart_wallet.paiement']) !!}

                                    <div><input style="width:100%" type="submit" name="paynow" class="btn mt-2" value="@lang('words.events_booking_page.eve_book_bookingWallet')" /></div>
                                {!! Form::close() !!}
                                
								    <div><input type="submit" name="paynow" style="width:100%;background-color: #FCBD0D" href="" class="btn mt-2" value="@lang('words.events_booking_page.eve_book_bookingCinets')" /></div>

                                    <!-- Modal -->
										<div class="modal fade" id="paiementlivraison" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleModalLabel">VALIDER</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<div class="modal-body">
														<table>
															<tr>
																<td>Téléphone, Préciser votre indicatif téléphonique (ex:+225 XX XX XX XX XX)</td>
																<td>
																	<input type="text" name="cellphone" class="form-control form-textbox" />
																	@if($errors->has('cellphone')) <span class="error">{{ $errors->first('cellphone') }}</span> @endif
																</td>
															</tr>
														</table>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
														<div class="payment-btn">
															<input type="submit" name="delivery-pay" class="btn-p btn-payment text-uppercase" value="payer à la livraison" />
														</div>
                                                        <span>
								<img src="{{ asset('/images/imgpayment/visa-logo-0.png')}}" width="80" style="max-width: 30px">
								<img src="{{ asset('/images/imgpayment/Mastercard-logo.svg.png')}}" width="80" style="max-width: 30px">
								<img src="{{ asset('/images/imgpayment/wave-simple.png')}}" width="80" style="max-width: 30px">
								<img src="{{ asset('/images/imgpayment/mtnmoneylogo.jpg')}}" width="80" style="max-width: 30px">
								<img src="{{ asset('/images/imgpayment/orangemoneysansecriture.png')}}" width="80" style="max-width: 30px">
								<img src="{{ asset('/images/imgpayment/moov_moneylogo.png')}}" width="80" style="max-width: 30px">
							</span>
													</div>
												</div>
											</div>
										</div>
                                
                                <div><a style="width:100%;background-color: #23272b;" href="{{route('shop')}}" class="btn mt-5" >Continuer mes achats</a></div>
                            </div>
                        </div>
                </aside>
            </div>
        </div>
	@else
        <div class="container-fluid mt-100">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body cart">
                            <div class="col-sm-12 empty-cart-cls text-center"> <img src="https://i.imgur.com/dCdflKN.png" width="130" height="130" class="img-fluid mb-4 mr-3">
                                <h3><strong>Le panier est vide !</strong></h3><br><br>
                                <a style="background-color: #23272b;" href="{{route('shop')}}" class="btn" data-abc="true">Continuer mes achats</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	@endif
@endsection

@section('pageScript')
    <script>
        var selects = document.querySelectorAll('#qty');
        Array.from(selects).forEach((element) => {
            element.addEventListener('change', function () {
                var rowId = this.getAttribute('data-id');
                var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                fetch(
                    `/shop/cart/${rowId}`,
                    {
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json, text-plain, */*",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": token
                        },
                        method: 'patch',
                        body: JSON.stringify({
                            qty: this.value
                        })
                    }
                ).then(
                    (data) => {
                        console.log(data);
                        location.reload();
               }).catch((error) => {
                        console.log('erreur');
                })
            });
        });
    </script>
@endsection