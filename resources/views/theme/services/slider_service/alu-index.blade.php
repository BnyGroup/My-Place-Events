@extends($theme)
{{-- @extends('layouts.master', ['body_class' => 'home-page']) --}}
@section('meta_title',setMetaData()->home_title)
@section('meta_description',setMetaData()->home_desc)
@section('meta_keywords',setMetaData()->home_keyword)
@section('content')

    <!--CONTENT START-->
<section class="section-bg home-section-bg" style="border-top: 1px solid #dfdfdf;">
    <div class="col-md-12">
<div class="row">
    @include('layouts.sidebar')
    <div class="col-md-8 px-0">

            <div class="col-lg-12 text-center content-title">
                <h1 style="margin-bottom: 20px;" class="section-title"> Vos <span class="primary-color "> Souscriptions </span></h1>
                <div class="col-md-12">
                    <div class="title-style fiche-events">
                        <div class="icon-bg"><i class="far fa-calendar-alt" aria-hidden="true"></i></div>
                        <hr align="center">
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                @if($error = Session::get('error'))
                    <div class="alert alert-danger">
                        {{ $error }}
                    </div>
                @elseif($success = Session::get('success'))
                    <div class="alert alert-success">
                        {{ $success }}
                    </div>
                @endif
            </div>



        <!--popular events box-->
        <div class="col-md-12">
            {{--{{ dd($souscriptions) }}--}}
            @if(empty($souscriptions))
                    <div class="col-lg-12 text-center content-title">
                        <h1 style="margin-bottom: 20px;" class="section-title"> Aucun Service disponible </h1>
                        <div class="col-md-12">
                            <div class="title-style fiche-events">
                                <div class="icon-bg"><i class="far fa-calendar-alt" aria-hidden="true"></i></div>
                                <hr align="center">
                            </div>
                        </div>
                    </div>

            @else
                @php $i=0 @endphp
            @foreach($souscriptions as $key => $data)
                    @php $image = (isset($data->image_slide_entete))?($data->image_slide_entete):''; @endphp
                    @php $i++ @endphp
                    <div class="col-lg-4 col-md-6 col-sm-12 hover" style="display: inline-block">
                        <div class="box box-a-la-une" style="position: relative;">
                            <a href="#"><img src="{{ url($image) }}" alt="{{ $data->titre_slide }}" /></a>
                            <div class="box-content card__padding">
                                <h4 class="card-title"><a href="#">{{ $data->titre_slide }}</a>
                                </h4>
                                <div class="badge category" style="cursor: default">
                                  <span class="">
                                      {{ $data->type_service }}
                                  </span>
                                </div>
                                <div class="badge prix f-right">
                                    <span class="">{{ $data->duree_service }} Semaine(s)</span><br>
                                </div>
                                <div class="card__action">
                                    <span class="date-times bold third-color">
                                        <i class="far fa-clock secondary-color"></i>Ajouté le
                                        {{ Carbon\Carbon::parse($data->created_at)->format('D, M j, Y') }}
                                    </span>
                                    @if(isset($data->date_demarre))
                                        <span class="date-times bold third-color">
                                        <i class="far fa-clock secondary-color"></i>En service depuis le
                                            {{ Carbon\Carbon::parse($data->date_demarre)->format('D, M j, Y') }}
                                            </span>
                                            <span class="bold"></span><br>
                                            <span class="date-times bold third-color">
                                        <i class="far fa-clock secondary-color"></i>Expire le
                                                {{ Carbon\Carbon::parse($data->date_fin)->format('D, M j, Y') }}
                                                <span class="bold"></span>
                                    </span>
                                            @endif
                                            <div class="card__location">
                                                <div class="card__location-content">
                                                    <i class="fa fa-money third-color bold"></i>
                                                    <strong>
                                                        Montant :
                                                        <span> {{ $data->montant}} </span> FCFA
                                                    </strong>
                                                </div>
                                            </div>
                                    <div class="card__location">
                                        <div class="card__location-content">
                                            <div rel="tag" class="third-color bold">
                                                @if($data->status_service == 0)
                                                    {!! Form::open(['method'=>'post','route'=>'alu.pay']) !!}
                                                        <input type="hidden" name="slug" value="{{ $data->slug }}" id="{{ $i }}"/>
                                                        {{--<input type="hidden" name="duree" value="{{ $data->duree_service }} " id="duree{{ $i }}">
                                                        <input type="hidden" name="montant" value="{{ $data->montant }}" id="montant{{ $i }}"/>--}}
                                                        <input type="hidden" name="designation" value="{{ $data->type_service }}" id="service{{ $i }}"/>
                                                        <input type="submit" value="En attente de paiement" class="btn-paiement">
                                                    {!! Form::close() !!}
                                                @elseif($data->status_service == 1)
                                                    Payé
                                                @endif
                                            </div>
                                        </div>
                                        <div class="card__location-content">
                                            <p rel="tag" class="third-color bold">
                                                <i class="fa fa-user primary-color"></i>
                                                @if($data->status_service == 1)
                                                    {{ $status = ($data->status_admin == 1)?'Disponible':'En cour de verification...' }}
                                                @else
                                                    -
                                                @endif
                                            </p>
                                        </div>
                                        <div class="card__location-content">
                                            <p rel="tag" class="third-color bold">
                                            <center>
                                                <a href="{{route('alu.edit',$data->slug) }}" class="btn btn-site-dft btn-sm"><i class="fa fa-edit"></i> @lang('words.mng_eve.mng_eve_edt')</a>
                                                <a href="{{ route('alu.delete',$data->id) }}" class="btn btn-site-dft btn-sm" onclick=" return confirm('are you sure Delete this item ?')"><i class="fa fa-trash"></i> @lang('words.mng_eve.mng_eve_del')</a>
                                            </center>
                                            </p>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                        </div>
                @endforeach
            @endif
        </div>


        <div class="row">
            <div class="col-lg text-center">
                <br>
                <a class="text-uppercase btn-seemore btn" href="{{ route('alu.create') }}">Souscrire à un service</a>
            </div>
        </div>
    </div>
</div>
    </div>
</section>
@endsection

@section('pageScript')
    <script type="text/javascript" src="{{ asset('/js/events/event-save-share.js')}}"></script>
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

    <script type="text/javascript">
        $(document).ready(function(){
            <?php
                for($j=1; $j<=$i; $j++){
            ?>
            $("#duree{{ $j }}").on('change', function (){
                var pu = $("#pu{{ $j }}").val();
                var formule = $(this).val();
                var montant = pu*formule;
                $("#montant{{ $j }}").val(montant);
            });

            var montant = $('#montant{{ $i }}').val();
            var reference = $('#reference{{ $i }}').val();

            paypal.Buttons({
                createOrder: function (data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: {{--{{ number_format(($bookingdata->order_amount/650)*1.06, 2) }}--}}montant/650,
                                currency: '{{ Config::get('services.paypal.currency') }}',
                                reference_id: '{{--{{ $bookingdata->order_id }}--}}',
                                description: '{{--{{ $bookingdata->event_name }}--}}',
                                invoice_id: '{{--{{ $bookingdata->order_id }}--}}',
                            }
                        }],
                    });
                },
                onApprove: function (data, actions) {
                    return actions.order.capture().then(function (details) {
                        alert('Paiement effectué par ' + details.payer.name.given_name + ' Veuillez patienter quelques secondes');
                        // Call your server to save the transaction
                        fetch('{{ url('paypal-transaction-complete/') }}/{{--{{ $bookingdata->order_id }}--}}/' + data.orderID, {
                            method: 'post',
                            headers: {
                                'content-type': 'application/json'
                            },
                            body: JSON.stringify({
                                orderID: data.orderID
                            })
                        }).then(response => {
                            if (response.ok) {
                                /*response.json()
                                    .then(console.log);*/
                                window.location.href = "{{--{{ route('ticket.oderdone',$bookingdata->order_id) }}--}}";
                            } else {
                                window.location.href = "{{--{{ route('order.cancel',$bookingdata->order_id) }}--}}";
                                //console.error('server response : ' + response.status);
                            }
                        });
                    })
                }
            }).render('#paypal-button-container{{ $i }}');
            <?php
            }
            ?>
        });
    </script>
@endsection
