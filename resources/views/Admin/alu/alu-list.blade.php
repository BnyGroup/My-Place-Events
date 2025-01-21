@inject('userlist','App\Frontuser')

@extends($AdminTheme)
@section('title','A la Une')
@section('content-header')
    <h1>Mise à la une </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
        <li class="active">Mise à la une</li>
    </ol>
@endsection

@section('content')

    {{--<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
            <br>
            <div id="forms-derach" class="box box-primary box-body">
                {!! Form::open(['method'=>'GET','route'=>'event.list']) !!}
                <div class="form-group col-md-3 col-xs-12 col-sm-12 col-lg-3">
                    <label>User List :</label>
                    <select class="form-control" name="fuser">
                        <option disabled selected="">Select User</option>
                        @foreach($userlist->fetchData() as $datsa)
                            <option value="{{ $datsa->firstname.' '.$datsa->lastname }}" {{ ( $datsa->firstname.' '.$datsa->lastname == Input::get('fuser')) ? 'selected' : '' }} >{{ $datsa->firstname }} {{ $datsa->lastname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3 col-xs-12 col-sm-12 col-lg-3">
                    <label> Current/Upcoming :</label>
                    {!! Form::select('duration',['Current' => 'Current','Upcoming'=>'Upcoming'],Null,['class'=>'form-control','placeholder' => 'Select Items']) !!}
                </div>
                <div class="form-group col-md-3 col-xs-12 col-sm-12 col-lg-3">
                    <label>Status :</label>
                    {!! Form::select('status',['Publish' => 'Publish','Draft' => 'Draft','Ban' => 'Ban'],null,['class'=>'form-control','placeholder' => 'Select Status']) !!}
                </div>
                <div class="form-group col-md-3 col-xs-12 col-sm-12 col-lg-3 text-center"><br>
                    <button class="btn btn-primary btn-flat"> Submit</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>--}}

    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Demandes de Mise à la une dont le paiement a été effectué</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @if($success = Session::get('success'))
                <div class="alert alert-success">{{ $success }}</div>
            @endif
            @if($error = Session::get('error'))
                <div class="alert alert-danger">{{ $error }}</div>
            @endif
            @if($info = Session::get('info'))
                <div class="alert alert-info">{{ $info }}</div>
            @endif
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">Nouvelles Demandes</a></li>
                <li><a data-toggle="tab" href="#menu2">Demandes acceptées</a></li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <table id="datatable" class="datatable table table-bordered table-striped ">
                        <thead>
                        <tr>
                            <th>No.</th>
                            {{--<th>Nom du demandeur</th>--}}
                            <th>Type de serivce</th>
                            <th>Image</th>
                            <th>Date de la demande</th>
                            <th>Durée du service</th>
                            <th>Montant</th>
                            <th>Temps restant</th>
                            <th>Status</th>
                            <th width="230">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $key => $val)
                            @if($val->status_service == 2)
                                @php

                                        @endphp
                                <tr>
                                    <td>{{ ++ $key }}</td>
                                    {{--<td>{{ $val->fnm }} {{ $val->lnm }}</td>--}}
                                    <td>{{ $val->type_service }}</td>
                                    <td><img src="{{ url($val->image_slide_entete ) }}" class="img-thumbnail" style="width:300px;"> </td>
                                    <td> * </td>
                                    <td> {{ $val->duree_service }} </td>
                                    <td> {{ $val->montant }} FCFA</td>
                                    <td>{{ $val->created_at }}</td>
                                    <td>
                                        @if($val->status_admin == 0 )
                                            <span class="btn btn-info"> En attente </span>
                                        @elseif($val->status_admin == 1)
                                            <span class="btn btn-success"> Activé </span>
                                        @elseif($val->status_admin == 2)
                                            <span class="btn btn-warning"> En pause </span>
                                        @elseif($val->status_admin == 3)
                                            <span class="btn btn-info"> Désactivé </span>
                                        @endif
                                    </td>
                                    <td>
                                        @permission('a-la-une-view')
                                        <a class="btn-flat btn btn-info" href="{{ route('alu.view',$val->id) }}"><i class="fa fa-eye"></i> voir </a>
                                        @endpermission
                                        @permission('a-la-une-ban-revoke')
                                        @if($val->status_admin == 0 || $val->status_admin == 3)
                                            <a href="{{ route('alu.revoke',$val->id) }}" class="btn-flat btn btn-success"><i class="fa fa-check"></i> Activer </a>
                                        @elseif($val->status_admin == 1)
                                            <a href="{{ route('alu.ban',$val->id) }}" class="btn-flat btn btn-danger" ><i class="fa  fa-ban"></i> {{--Enabled--}}Désactivé</a>
                                            {{--<a href="{{ route('alu.pause',$val->id) }}" class="btn-flat btn btn-warning" ><i class="fa fa-pause"></i> Pause </a>--}}
                                        @elseif($val->status_admin == 2)
                                            <a href="{{ route('alu.revoke',$val->id) }}" class="btn-flat btn btn-success"><i class="fa fa-check"></i> Activer </a>
                                        @endif
                                        @endpermission
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="menu2" class="tab-pane fade">
                    <table id="datatable" class="datatable table table-bordered table-striped ">
                        <thead>
                        <tr>
                            <th>No.</th>
                            {{--<th>Nom du demandeur</th>--}}
                            <th>Type de serivce</th>
                            <th>Image</th>
                            <th>Date de la demande</th>
                            <th>Durée du service</th>
                            <th>Montant</th>
                            <th>Temps restant</th>
                            <th>Status</th>
                            <th width="230">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $key => $val)
                            @if($val->status_service == 1)
                                @php

                                        @endphp
                                <tr>
                                    <td>{{ ++ $key }}</td>
                                    {{--<td>{{ $val->fnm }} {{ $val->lnm }}</td>--}}
                                    <td>{{ $val->type_service }}</td>
                                    <td><img src="{{ url($val->image_slide_entete ) }}" class="img-thumbnail" style="width:300px;"> </td>
                                    <td> * </td>
                                    <td> {{ $val->duree_service }} Semaine(s) </td>
                                    <td> {{ $val->montant }} FCFA</td>
                                    <td>{{ $val->date_fin }}</td>
                                    <td>
                                        @if($val->status_admin == 0 )
                                            <span class="btn btn-info"> En attente </span>
                                        @elseif($val->status_admin == 1)
                                            <span class="btn btn-success"> Activé </span>
                                        @elseif($val->status_admin == 2)
                                            <span class="btn btn-warning"> En pause </span>
                                        @elseif($val->status_admin == 3)
                                            <span class="btn btn-info"> Désactivé </span>
                                        @endif
                                    </td>
                                    <td>
                                        @permission('a-la-une-view')
                                        <a class="btn-flat btn btn-info" href="{{ route('alu.view',$val->id) }}"><i class="fa fa-eye"></i> voir </a>
                                        @endpermission
                                        @permission('a-la-une-ban-revoke')
                                        @if($val->status_admin == 0 || $val->status_admin == 3)
                                            <a href="{{ route('alu.revoke',$val->id) }}" class="btn-flat btn btn-success"><i class="fa fa-check"></i> Activer </a>
                                        @elseif($val->status_admin == 1)
                                            <a href="{{ route('alu.ban',$val->id) }}" class="btn-flat btn btn-danger" ><i class="fa  fa-ban"></i> {{--Enabled--}}Désactiver</a>
                                            {{--<a href="{{ route('alu.pause',$val->id) }}" class="btn-flat btn btn-warning" ><i class="fa fa-pause"></i> Pause </a>--}}
                                        @elseif($val->status_admin == 2)
                                            <a href="{{ route('alu.revoke',$val->id) }}" class="btn-flat btn btn-success"><i class="fa fa-check"></i> Activer </a>
                                        @endif
                                        @endpermission
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{--<table id="datatable" class="datatable table table-bordered table-striped ">
                <thead>
                <tr>
                    <th>No.</th>
                    --}}{{--<th>Nom du demandeur</th>--}}{{--
                    <th>Type de serivce</th>
                    <th>Image</th>
                    <th>Date de la demande</th>
                    <th>Durée du service</th>
                    <th>Montant</th>
                    <th>Temps restant</th>
                    <th>Status</th>
                    <th width="230">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $key => $val)
                    @if($val->status_service == 1)
                        @php

                        @endphp
                        <tr>
                            <td>{{ ++ $key }}</td>
                            --}}{{--<td>{{ $val->fnm }} {{ $val->lnm }}</td>--}}{{--
                            <td>{{ $val->type_service }}</td>
                            <td><img src="{{ url($val->image_slide_entete ) }}" class="img-thumbnail" style="width:300px;"> </td>
                            <td> * </td>
                            <td> {{ $val->duree_service }} </td>
                            <td> {{ $val->montant }} FCFA</td>
                            <td>{{ $val->created_at }}</td>
                            <td>
                                @if($val->status_admin == 0 )
                                    <span class="btn btn-info"> En attente </span>
                                @elseif($val->status_admin == 1)
                                    <span class="btn btn-success"> Activé </span>
                                @elseif($val->status_admin == 2)
                                    <span class="btn btn-warning"> En pause </span>
                                @elseif($val->status_admin == 3)
                                    <span class="btn btn-info"> Désactivé </span>
                                @endif
                            </td>
                            <td>
                                @permission('a-la-une-view')
                                <a class="btn-flat btn btn-info" href="{{ route('alu.view',$val->id) }}"><i class="fa fa-eye"></i> voir </a>
                                @endpermission
                                @permission('a-la-une-ban-revoke')
                                @if($val->status_admin == 0 || $val->status_admin == 3)
                                    <a href="{{ route('alu.revoke',$val->id) }}" class="btn-flat btn btn-success"><i class="fa fa-check"></i> Activer </a>
                                @elseif($val->status_admin == 1)
                                    <a href="{{ route('alu.ban',$val->id) }}" class="btn-flat btn btn-danger" ><i class="fa  fa-ban"></i> --}}{{--Enabled--}}{{--Désactivé</a>
                                    <a href="{{ route('alu.pause',$val->id) }}" class="btn-flat btn btn-warning" ><i class="fa fa-pause"></i> Pause </a>
                                @elseif($val->status_admin == 2)
                                    <a href="{{ route('alu.revoke',$val->id) }}" class="btn-flat btn btn-success"><i class="fa fa-check"></i> Activer </a>
                                @endif
                                @endpermission
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>--}}
        </div>
    </div>
@endsection