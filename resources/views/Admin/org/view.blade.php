@extends($AdminTheme)
@section('title','Details of'.' '.$data->organizer_name)
@section('content-header')
<h1>{{--Details of--}}Details de {{ $data->organizer_name }}</h1>
<ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
  <li class="active">{{--organization details--}}Détails de l'organisation</li>
</ol>
@endsection
@section('content')
<div class="{{ events_alert($data->ban)->class }}">
  <p class="text-center">{{ events_alert($data->ban)->message }}</p>
</div>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Détails</h3>
  </div>
  <div class="box-body">
    <div class="row">
      <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">  
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <tbody>
              <tr class="text-center">
                <td colspan="2">
                  @if(($data->oauth_provider)== null)
                    <img src="{{ setThumbnail($data->profile_pic) }}"
                         class="user-profile" alt="user">
                  @else
                    <img src="{{ url($data->profile_pic) }}"
                         class="user-profile" alt="user">
                  @endif
                  {{--<img src="{{ setThumbnail($data->profile_pic) }}" style="border-radius: 50%; border:5px solid #c8c8c8; padding:4px;">--}}
                </td>
              </tr>
              <tr>
                <th>{{--Organizer Name--}}Nom de l'organisateur</th>
                <td>{{ $data->organizer_name }}</td>
              </tr>
              <tr>
                <th>{{--Website--}}Site Web</th>
                <td>{{ $data->website }}</td>
              </tr>
              <tr>
                <th>{{--Facebook Page--}}Page Facebook</th>
                <td>{{ $data->facebook_page }}</td>
              </tr>
              <tr>
                <th>Twitter</th>
                <td>{{ $data->twitter }}</td>
              </tr>
              <tr>
                <th>{{--Created By --}} Créé par:</th>
                <td>{{ $data->fnm }} {{ $data->lnm }}</td>
              </tr>
              <tr>
                <th>{{--Created Date:--}}Date de création</th>
                <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$data->created_at)->format('Y-m-d H:i:s') }}</td>
              </tr>
              <tr>
                <th>Updated Date:</th>
                <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$data->updated_at)->format('Y-m-d H:i:s') }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
        <div class="table-responsive">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th>{{--About Organizer--}}A propos de l'Organisateur</th>
                <td>{!! $data->about_organizer !!}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection