@extends($AdminTheme)
@inject('souscPrestataire','App\SouscPrestataire')
@section('title','Details of'.' '.$data->pseudo)
@section('content-header')
    <h1>Details de {{$data->pseudo}}</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
        <li class="active">Detail du prestataire</li>
    </ol>
@endsection
@section('content')
   {{-- <div class="{{ events_alert($data->status)->class }}">
        <p class="text-center">{{ events_alert($data->status)->message }}</p>
    </div>--}}
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Details</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
                    <table class="table table-bordered table-striped">
                        <tbody>
                        <tr class="text-center">
                            <td colspan="2"><img src="{{ setThumbnail($data->profile_pic) }}"></td>
                        </tr>
                        <tr>
                            <th>Nom commercial</th>
                            <td>{{ $data->pseudo}}</td>
                        </tr>
                        <tr>
                            <th>Activités</th>
                            <td>{{ $data->activites}}</td>
                        </tr>
                        <tr>
                            <th>Location</th>
                            <td>{{ $data->adresse_geo}}</td>
                        </tr>
                        <tr>
                            <th>{{--Posted By--}}Posté Par</th>
                            <td>{{ $data->fnm }} {{ $data->lnm }}</td>
                        </tr>
                        <tr>
                            <th>Nom complet du prestataire </th>
                            <td>{{ $data->firstname.' '.$data->lastname}}</td>
                        </tr>
                        <tr>
                            <th>{{--Created Date --}}Crée le</th>
                            <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$data->created_at)->format('Y-m-d H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>{{--Updated Date--}}Modifié le</th>
                            <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$data->updated_at)->format('Y-m-d H:i:s') }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>Description</th>
                            <td>{!! $data->descriptions !!}</td>
                        </tr>
                        <tr>
                            <th>Souscriptions</th>
                            <td>
                                <table class="table table-bordered">
                                    @php
                                        $formules = $souscPrestataire->getLatestData($data->id);
                                        $count = $souscPrestataire->count_sousc_number($data->id)
                                        //dd($formules);
                                    @endphp
                                    @if($formules != null)
                                        {{--@foreach($formules as $key=>$formule)--}}
                                            <tr>
                                                <th colspan="2" style="text-align: center">Dernière souscription</th>
                                            </tr>
                                            <tr>
                                                <th>Formule</th>
                                                <td>{{ $formules->formule }} Mois</td>
                                            </tr>
                                            <tr>
                                                <th>Montant</th>
                                                <td>{{ $formules->montant }}</td>
                                            </tr>
                                            <tr>
                                                <th>Moyen de paiement</th>
                                                <td>{{ $formules->payment_gateway }}</td>
                                            </tr>
                                            <tr>
                                                <th>Date de paiement</th>
                                                <td>{{ $paymentDate = ucwords(Jenssegers\Date\Date::parse($formules->payment_date)->format('l j F Y')) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Date d'expiration</th>
                                                <td>{{ $paymentDate = ucwords(Jenssegers\Date\Date::parse($formules->payment_expire)->format('l j F Y')) }}</td>
                                            </tr>
                                            <hr  />
                                        {{--@endforeach--}}
                                    @endif
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection