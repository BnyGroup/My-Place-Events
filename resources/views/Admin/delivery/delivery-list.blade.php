@inject('userlist','App\Frontuser')

@extends($AdminTheme)
@section('title','Paiement à la Livraison')
@section('content-header')
    <h1>{{--Events--}}Evénements </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Accueil</a></li>
        <li class="active">{{--Events --}}Commande </li>
    </ol>
@endsection

@section('content')

    <div class="responsive-tabs">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">Livraison en attente</a>
            </li>
            <li role="presentation" class="">
                <a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab">Livraison effectuée</a>
            </li>
        </ul>
        <div id="tabs-content" class="tab-content panel-group">
            <div id="tab1" role="tabpanel" class="tab-pane active panel-collapse collapse in" aria-labelledby="heading1">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{--Event List--}}Livraison en attente</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        @if($success = Session::get('success'))
                            <div class="alert alert-success">{{ $success }}</div>
                        @endif
                        @if($error = Session::get('error'))
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endif
                            @php $noRepeatController2 = array(); @endphp
                        <table id="datatable" class="datatable table table-bordered table-striped ">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>EVENEMENT</th>
                                <th>{{--Name--}}ID COMMANDE</th>
                                <th>{{--User Name--}}NOM ET PRENOMS</th>
                                <th>{{--Event Date--}}TELEPHONE</th>
                                <th>{{--Event Date--}}EMAIL</th>
                                <th>{{--Price--}}QTE</th>
                                <th>{{--Price--}}PRIX</th>
                                <th width="230" class="text-center">DATE ET HEURE</th>
                                <th class="text-center">ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($deliveryList as $key => $val)
                                @php
                                    if(array_search($val->order_id, $noRepeatController2))
                                        continue;
                                    else
                                        $noRepeatController2[] = $val->order_id;
                                @endphp
                                <tr>
                                    <td>{{ ++ $key }}</td>
                                    <td>{{ $val->event_name }}</td>
                                    <td>{{ $val->order_id }}</td>
                                    <td>{{ $val->fnm }} {{ $val->lnm }}</td>
                                    <td>{{ $cellphone = (!empty($val->user_cellphone))?$val->cellphone:$val->guest_cellphone }}</td>
                                    <td>{{ $email = (!empty($val->user_email))?$val->user_email:$val->guest_email }}</td>
                                    <td> {{ $val->order_tickets }}</td>
                                    <td>{{ $val->order_amount }}</td>
                                    <td>{{ $val->BOOKING_ON }}</td>
                                    <td class="text-center">
                                        {{--@if($val->order_status == 4)--}}
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn-flat btn btn-warning" data-toggle="modal" data-target="#validerlepaiement{{$key}}">
                                                Valider le paiement
                                            </button>
                                            <!-- Modal 1 -->
                                            <div class="modal fade" id="validerlepaiement{{$key}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Êtes-vous sûr de vouloir valider le paiement pour cette commande ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <a href="{{ route('delivery.paid',$val->order_id) }}" class="btn-flat btn btn-warning">Valider le paiement </a>
                                                            {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn-flat btn btn-danger" data-toggle="modal" data-target="#annulerlacommande{{$key}}"> Annuler la commande </button>
                                            <!-- Modal 1 -->
                                            <div class="modal fade" id="annulerlacommande{{$key}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Êtes-vous sûr de vouloir annuler cette commande ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <a href="{{ route('order.cancel',$val->order_id) }}" class="btn-flat btn btn-danger">{{--<i class="fa fa-ban"></i>--}} {{--Disabled--}}Annuler la commande</a>
                                                            {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{--<a href="{{ route('events.ban',$val->id) }}" class="btn-flat btn btn-warning">--}}{{--<i class="fa fa-ban"></i>--}}{{-- --}}{{--Disabled--}}{{--Valider le paiement</a>--}}
                                            {{--<a href="{{ route('events.ban',$val->id) }}" class="btn-flat btn btn-danger">--}}{{--<i class="fa fa-ban"></i>--}}{{-- --}}{{--Disabled--}}{{--Annuler la commande</a>--}}
                                            {{--<a class="btn-flat btn btn-info" href="{{ route('events.view',$val->id) }}"><i class="fa fa-eye"></i> Détails</a>--}}
                                        {{--@endif--}}
                                    </td>
                                </tr>
                            @endforeach
                            @php $noRepeatController2 = NULL @endphp
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="tab2" role="tabpanel" class="tab-pane panel-collapse collapse" aria-labelledby="heading2">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{--Event List--}}Livrraison effectuée</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        @if($success = Session::get('success'))
                            <div class="alert alert-success">{{ $success }}</div>
                        @endif
                        @if($error = Session::get('error'))
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endif
                        @php $noRepeatController = array(); @endphp
                        <table id="datatable" class="datatable table table-bordered table-striped ">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>EVENEMENT</th>
                                <th>{{--Name--}}ID COMMANDE</th>
                                <th>{{--User Name--}}NOM ET PRENOMS</th>
                                <th>{{--Event Date--}}TELEPHONE</th>
                                <th>{{--Event Date--}}EMAIL</th>
                                <th>QTE</th>
                                <th>{{--Price--}}PRIX</th>
                                <th width="230" class="text-center">DATE ET HEURE</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($deliveryListPaid as $key => $val)
                                @php
                                    if(array_search($val->order_id, $noRepeatController))
                                        continue;
                                    else
                                        $noRepeatController[] = $val->order_id;
                                @endphp
                                <tr>
                                    <td>{{ ++ $key }}</td>
                                    <td>{{ $val->event_name }}</td>
                                    <td>{{ $val->order_id }}</td>
                                    <td>{{ $val->fnm }} {{ $val->lnm }}</td>
                                    <td>{{ $cellphone = (!empty($val->user_cellphone))?$val->cellphone:$val->guest_cellphone }}</td>
                                    <td>{{ $email = (!empty($val->user_email))?$val->user_email:$val->guest_email }}</td>
                                    <td> {{ $val->order_tickets }}</td>
                                    <td>{{ $val->order_amount }}</td>
                                    <td>{{ $val->updated_date }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            @php $noRepeatController = NULL @endphp
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection