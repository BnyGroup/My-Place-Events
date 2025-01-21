@extends($theme)

@section('meta_title','Réservation réussie - '.$bookingdata->order_id )
@section('meta_description','Reservation effectuée avec succès')
@section('meta_keywords','reservation - succès - ticket - afrique')

@section('content')
    <div class="container-fluid about-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 about-parents-wrapper-min">
                    <h2 class="text-uppercase about-title">{{--Success--}}Succès</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row pb-5">
            <div class="col-md-10 col-sm-12 col-xs-12 col-lg-10 book-box offset-lg-1 col-lg-offset-1 offset-md-1 col-md-offset-1">
                <div class="row">
                    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 book-box-inner">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <h2>Votre commande <span style="color:#f16334">n° {{ $bookingdata->order_id }}</span> a été prise en compte, </h2>
                            </div>
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <p class="cale-o">
                                    <i class="fa fa-calendar-check-o"></i>
                                    <span>{{Carbon\Carbon::parse($bookingdata->BOOKING_ON)->format('l - F j, Y')}}</span>
                                </p>
                            </div>
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <p class="toikcek-o">{{--Your order has been saved to My Tickets--}} Votre commande a été enregistrée dans Mes billets. </p>
                            </div>
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <p class="book-list"><i class="fa fa-check"></i>{{--Your tickets have been sent to--}}Vos Billets seront envoyés lors du paiement
                                    <b>
                                        @if(auth()->guard('frontuser')->check())
                                            {{ $bookingdata->user_email }}
                                        @else
                                            {{ $bookingdata->ot_email }}
                                        @endif
                                    </b>
                                </p>
                            </div>
                            <div class="col-md-5 col-lg-4 col-sm-12 col-xs-12 book-btn">
                                <a href="{{ route('events.details',$bookingdata->event_slug) }}" class="pro-choose-file text-uppercase"> {{--Go To Event--}} Revenir à l'évènement</a>
                            </div>
                            {{--<div class="col-md-5 col-lg-4 col-sm-12 col-xs-12 book-btn">
                                @if(auth()->guard('frontuser')->check())
                                    <a href="{{ route('order.single',$bookingdata->order_id) }}" target="_blank" class="pro-choose-file text-uppercase">--}}{{-- Go to my tickets--}}{{--Aller à mes billets</a>
                                @else
                                    <a class="pro-choose-file text-uppercase" href="{{ asset('/upload/ticket-pdf/'.$bookingdata->order_id.'-'.$bookingdata->event_id.'.pdf') }}" target="_blank">--}}{{--Download your tickets--}}{{--Téléchargez vos billets</a>
                                @endif
                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection