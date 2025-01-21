<div class="row pt-1">
    <div class="col text-center">
        <a href="#" class="btn btn-lg btn-primary" data-toggle="modal" data-target="#largeModal-{{ $val->id }}"
           id="verify">Payer pour activer le service</a>
    </div>
</div>
<div class="modal fade" id="largeModal-{{ $val->id }}" tabindex="-1" role="dialog" aria-labelledby="basicModal"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Paiement pour <strong
                            class="primary-color">{{ $val->firstname.' '.$val->lastname }}</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <h5>Choisir une formule</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        {{--<form method="POST" action="{{ route('pre.cinetpay') }}">--}}{!! Form::open(['method'=>'post','route'=>'wallet_cinetpay.paiement', 'id'=>'preForm'.$i,'class'=>'prestPayForm']) !!}
                            <input type="number" value="1" name="formule" style="text-align:center" id="formule{{ $i }}" class="formule">
                            <input type="number" name="montant" value="{{ $service->montant_service }}" readonly id="montant{{ $i }}" style="text-align:center; font-weight: bolder;border:none" class="montant">
                            <input type="hidden" name="pu" value="{{ $service->montant_service }}" id="pu{{ $i }}" class="pu">
                            <input type="hidden" name="url_slug" value="{{ $val->url_slug}}">
                            <input type="hidden" name="designation" value="prestataire">
                            <input type="hidden" name="identifiant_payeur" value="Paiement de formule prestataire">
                            <input type="submit">
                        {{--</form>--}}{!! Form::close() !!}
                        <div class="col-sm-12" style="display: inline-block;">
                            <div class="row">
                                {{-- <div id="paypal-button-container{{ $i }}"></div> --}}
                                {{--<a href="{{ route('pp.create',['order_id' =>$bookingdata->order_id]) }}" class="btn btn-success" > Payer avec Paypal </a>--}}
                            </div>
                        </div>
                    </div>
                    {{--<div class="col-sm-4 pt-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="mb-3 primary-color"><strong>1 Mois</strong></h5>

                                <p class="mb-4"><strong>10 000 FCFA</strong></p>
                                <a href="{{ route('pre.cinetpay',[$val->id,10000]) }}" class="btn btn-primary"
                                   style="width: 100%;">S'abonner</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 pt-3">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="mb-3 primary-color"><strong>6 mois</strong></h5>

                                <p class="mb-4"><strong>25 000 FCFA</strong></p>
                                <a href="{{ route('pre.cinetpay',[$val->id,25000]) }}" class="btn btn-primary"
                                   style="width: 100%;">S'abonner</a>
                            </div>
                        </div>

                    </div>


                    <div class="col-sm-4 pt-3">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="mb-3 primary-color"><strong>1 An</strong></h5>

                                <p class="mb-4"><strong>35 000 FCFA</strong></p>
                                <a href="{{ route('pre.cinetpay',[$val->id,35000]) }}" class="btn btn-primary"
                                   style="width: 100%;">S'abonner</a>
                            </div>
                        </div>
                    </div>--}}
                </div>
            </div>
            <div class="modal-footer" style="padding: 9px;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>