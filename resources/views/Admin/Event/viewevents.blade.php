@extends($AdminTheme)
@section('title','Details of'.' '.$data->event_name)
@section('content-header')
@php
  /*$startdate = Carbon\Carbon::parse($event->event_start_datetime)->format('D j F Y');
  $enddate = Carbon\Carbon::parse($event->event_end_datetime)->format('D, F j, Y');
  $starttime = Carbon\Carbon::parse($event->event_start_datetime)->format('h:i A');
  $endtime = Carbon\Carbon::parse($event->event_end_datetime)->format('h:i A');*/

  $startdate 	= ucwords(Jenssegers\Date\Date::parse($data->event_start_datetime)->format('l j F Y'));
  $enddate 	= ucwords(Jenssegers\Date\Date::parse($data->event_end_datetime)->format('l j F Y'));
  $starttime	= Carbon\Carbon::parse($data->event_start_datetime)->format('H:i');
  $endtime	= Carbon\Carbon::parse($data->event_end_datetime)->format('H:i');
@endphp
<h1>Details de {{$data->event_name}}</h1>
<ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
  <li class="active">Details Events</li>
</ol>
@endsection
@section('content')
  <div class="{{ events_alert($data->ban)->class }}">   
    <p class="text-center">{{ events_alert($data->ban)->message }}</p>
  </div>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Détails - [ <a href="{{ route('events.export',$data->event_unique_id) }}">Exporter données</a> ]</h3>
  </div>
  <div class="box-body">
    <div class="row">
      <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
        <table class="table table-bordered table-striped">
          <tbody>
            <tr class="text-center">
              <td colspan="2"><img src="{{ setThumbnail($data->event_image) }}"></td>
            </tr>
            <tr>
              <th>{{--Event Name--}}Nom Event</th>
              <td>{{ $data->event_name }}</td>
            </tr>
            <tr>
              <th>{{--Category--}}Catégorie</th>
              <td>{{ $data->cnm }}</td>
            </tr>
            <tr>
              <th>Location</th>
              <td>{{ $data->event_location }}</td>
            </tr>
            <tr>
              <th>Adresse{{--Address--}} </th>
              <td>{{ $data->event_address }}</td>
            </tr>
            <tr>
              <th>{{--Start Date--}}Début</th>
              <td>{{ /*Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$data->event_start_datetime)->format('l d, F Y - h:i:s A')*/ $startdate }} à {{ $starttime }}</td>
            </tr>
            <tr>
              <th>{{--End Date--}}Fin</th>
              <td>{{ /*Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$data->event_end_datetime)->format('l d, F Y - h:i:s A')*/  $enddate }} à {{ $endtime }}</td>
            </tr>
            <tr>
              <th>Url Event</th>
              <td>{{ $data->event_url }}</td>
            </tr>
            <tr>
              <th>{{--Posted By--}}Posté par</th>
              <td>{{ $data->fnm }} {{ $data->lnm }}</td>
            </tr>
            <tr>
              <th>{{--Organization Name--}}Nom de l'organisation</th>
              <td>{{ $data->org_name}} </td>
            </tr>
            <tr>
              <th>{{--Created Date --}}Créé le</th>
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
              <td>{!! $data->event_description !!}</td>
            </tr>
			<tr>
				<th colspan="8" style="text-align: left">
					@if($data->event_immanquable == 0)
						<h5 class="text-danger"><i class="fa fa-ban "></i> Désactivé</h5>
						<a href="{{ route('events.immanquable',$data->id) }}" class="btn-flat btn btn-success">Activer</a>
					@elseif($data->event_immanquable == 1)
					<h4>Bannière les Immanquables</h4><br>
					 <div class="col-md-9">
						 <form action="{{ route('events.save-immanquable') }}" method="post" enctype="multipart/form-data">
							 <input type='hidden' name='_token' value='{{ csrf_token() }}'>
							<input type="hidden" name="event_unique_id" value="{{$data->event_unique_id}}">
							<input type="file" name="event_img_immanquable">
							<input type="submit" value="Uploader" lass="swal_form_submit_btn d-none" style="margin-top: 15px; border-radius: 50px; padding: 5px 25px">
						</form>
					</div>
					<div class="col-md-3"><?php if(!empty($data->event_img_immanquable)){ ?><a href="{{ getImage($data->event_img_immanquable) }}" target="new"><img src="{{ getImage($data->event_img_immanquable,'thumb') }}" style="width: 100%; margin-top: -30px;"></a><?php } ?></div>
					<br style="clear: both"><br><br>
					<a style="float: right" href="{{ route('events.noimmanquable',$data->id) }}" class="btn-flat btn btn-danger">Retirer des immanquables</a>
					@endif
			   </th>
	    	</tr>
          </tbody>
        </table>
      </div>
      <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
        <table class="table table-bordered table-striped ">
      <thead>
        <tr>
          <th class="text-center" colspan="8">{{--Tickect--}}Ticket</th>
        </tr>
        <tr>
          <th>{{--Ticket Id--}}Id Ticket</th>
          <th>{{--Ticket Name--}}Nom Ticket</th>
          <th>{{--Ticket Description--}}Descritpion du Ticket</th>
          <th>{{--Ticket Qty--}}Qté Ticket</th>
          <th>Type de Ticket</th>
          <th>{{--Ticket Services Fee--}}Frais de services de billetterie</th>
          <th>{{--Ticket Price Buyer--}}Prix du billet Acheteur</th>
          <th>{{--Ticket Price Actual--}}Prix Actuel du billet</th>
        </tr>
	    
      </thead>
      <tbody>
        @foreach($tik as $key => $val)
        <tr>
          <td>{{$val->ticket_id}}</td>
          <td>{{$val->ticket_title}}</td>
          <td>{{ $val->ticket_description }}</td>
          <td>{{ $val->ticket_qty }}</td>
          <td>{{ $val->ticket_type }}</td>
          <td>{{ $val->ticket_services_fee }}</td>
          <td>{{ $val->ticket_price_buyer }}</td>
          <td>{{ $val->ticket_price_actual }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
      </div>
    </div>
  </div>
</div>
@endsection