@inject('userlist','App\Frontuser')
@inject('souscPrestataire','App\SouscPrestataire')

@extends($AdminTheme)
@section('title','Events List')
@section('content-header')
    <h1>{{--Events--}}Prestataire </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
        <li class="active">{{--Events--}}Prestataire </li>
    </ol>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
            <br>
            <div id="forms-derach" class="box box-primary box-body">
                {!! Form::open(['method'=>'GET','route'=>'pres.list']) !!}
                <div class="form-group col-md-3 col-xs-12 col-sm-12 col-lg-3">
                    <label>{{--User List--}}Liste de Utilisateurs :</label>
                    <select class="form-control" name="fuser">
                        <option disabled selected="">{{--Select User--}}Choisir un utilisateur</option>
                        @foreach($userlist->fetchData() as $datsa)
                            <option value="{{ $datsa->firstname.' '.$datsa->lastname }}" {{ ( $datsa->firstname.' '.$datsa->lastname == Input::get('fuser')) ? 'selected' : '' }} >{{ $datsa->firstname }} {{ $datsa->lastname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3 col-xs-12 col-sm-12 col-lg-3">
                    <label> {{--Current/Upcoming --}}Actuel/A venir:</label>
                    {!! Form::select('duration',['Current' => 'Current','Upcoming'=>'Upcoming'],Null,['class'=>'form-control','placeholder' => 'Select Items']) !!}
                </div>
                <div class="form-group col-md-3 col-xs-12 col-sm-12 col-lg-3">
                    <label>Status :</label>
                    {!! Form::select('status',['Publish' => 'Publish','Draft' => 'Draft','Ban' => 'Ban'],null,['class'=>'form-control','placeholder' => 'Select Status']) !!}
                </div>
                <div class="form-group col-md-3 col-xs-12 col-sm-12 col-lg-3 text-center"><br>
                    <button class="btn btn-primary btn-flat"> {{--Submit--}}Envoyer</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">{{--Event List--}}Liste des Blogs</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @if($success = Session::get('success'))
                <div class="alert alert-success">{{ $success }}</div>
            @endif
            @if($error = Session::get('error'))
                <div class="alert alert-danger">{{ $error }}</div>
            @endif
            <table id="datatable" class="datatable table table-bordered table-striped ">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Prestataire</th>
                    {{--<th>Nom et Prenoms</th>--}}
                    <th>Date dernière Formule</th>
                    <th>Activités</th>
                    <th>Status</th>
                    <th width="230">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $key => $val)
                    <tr>
                        <td>{{ ++ $key }}</td>
                        <td>{{ $val->pseudo }}</td>
{{--                        <td>{{ $val->lastname }} {{ $val->firstname }}</td>--}}
                        @php $paymentDate = $souscPrestataire->getLatestData($val->id) @endphp
                        <td>
                            @if($paymentDate != null)
                                @if($paymentDate->payment_date != null)
                                    {{ $Date = ucwords(Jenssegers\Date\Date::parse($paymentDate->payment_date)->format('l j F Y')) }}
                                @else
                                    ----
                                @endif
                            @else
                                ----
                            @endif
                        </td>
                        <td>{{ $val->activites }}</td>
                        <td>
                            @if($val->status == 0)
                                <span class="btn-flat btn btn-danger"> Desactivé </span>
                            @endif
                            @if($val->status == 1)
                                <span class="btn-flat btn btn-success"> Activé </span>
                            @endif
                            @if($val->status == 2)
                                <span class="btn-flat btn btn-info"> Paiement effectué </span>
                            @endif
                            @if($val->status == 3)
                                <span class="btn-flat btn btn-warning"> En attente de paiement </span>
                            @endif
                        </td>
                        <td>
                            @permission('prestataire-view')
                            <a class="btn-flat btn btn-info" href="{{ route('pres.view',$val->id) }}"><i class="fa fa-eye"></i> View</a>
                            @endpermission
                            @permission('prestataire-ban-revoke')
                            @if($val->status == 2)
                                @if($paymentDate != null)
                                <a href="{{ route('pres.active',[$val->url_slug, $paymentDate->id_transaction]) }}" class="btn-flat btn btn-success"><i class="fa fa-check"></i> Activer la formule </a>
                                @endif
                            @elseif($val->status == 1)
                                <a href="{{ route('pres.ban',$val->id) }}" class="btn-flat btn btn-danger" ><i class="fa  fa-ban"></i> Désactiver </a>
                            @endif
                            @if($val->status == 0)
                                <a href="{{ route('pres.ban',$val->url_slug) }}" class="btn-flat btn btn-danger" ><i class="fa  fa-ban"></i> Réactiver </a>
                            @endif
                                {{--<a href="{{ route('pres.revoke',$val->id) }}" class="btn-flat btn btn-success" ><i class="fa  fa-check"></i> Activer </a>
                            @endif--}}
                            @endpermission
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection