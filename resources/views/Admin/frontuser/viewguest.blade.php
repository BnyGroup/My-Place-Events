@extends($AdminTheme)

@section('title','Details of'.' '.$data->firstname.' '. $data->lastname)

@section('content-header')
<h1>Details of {{ $data->firstname }} {{ $data->lastname }}</h1>
	<ol class="breadcrumb">
	  <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	  <li class="active">{{--Details of --}}Details de {{ $data->firstname }} {{ $data->lastname }}</li>
	</ol>
@endsection

@section('content')
	<div class="{{ frontuser_alert($data->status)->class }}">
		<p class="text-center">{{ frontuser($data->status)->message }}</p>
	</div>
	<div class="row">

		<div class="col-lg-5 col-md-5 col-sm-10 col-xs-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">{{--Profile Details--}}Details Profile</h3>
				</div>
				<div class="box-body">
				<div class="table-responsive">

					<table class="table table-bordered table-striped">
										<tbody>
											<tr>
												<td colspan="2">
													<p class="text-center">
														@if(($data->oauth_provider)== null)
															<img src="{{ setThumbnail($data->profile_pic) }} }}"
																class="user-profile" alt="user">
														@else
															<img src="{{ url($data->profile_pic) }}"
																class="user-profile" alt="user">
														@endif
														{{--<img src="{{ setThumbnail($data->profile_pic) }}" style="border-radius: 50%; border:5px solid #c8c8c8; padding:4px;">--}}
													</p>
												</td>
											</tr>
											<tr>
												<th>{{--Full Name--}}Nom Complet</th>
												<td><p>{{ $data->firstname }} {{ $data->user_name }}</p></td>
											</tr>
											<tr>
												<th>Email</th>
												<td>{{ $data->guest_email }}</td>
											</tr>
											<tr>
												<th>{{--Cellphone--}}Téléphone portable</th>
												<td>{{ $data->cellphone }}</td>
											</tr>
											<tr>
												<th>{{--Website--}}Abonné à la newsletter ?</th>
												<td><?php if($data->newsletter==1) echo"oui"; else echo"non"; ?></td>
											</tr>
											  
											<tr>
												<th>{{--Created Date--}}Créé le</th>
												<td>{{ date_format($data->created_at,'d, M  Y') }}</td>
											</tr>
											<tr>
												<th>{{--Updated Date--}}Modifier le</th>
												<td>{{ date_format($data->updated_at,'d, M  Y') }}</td>
											</tr>
										</tbody>
								</table>
							</div>
				</div>
			</div>
		</div>

		<div class="col-lg-7 col-md-7 col-sm-10 col-xs-12">
			<div class="row">
				 
				<?php /*?><div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Details Achat tickets</h3>
						</div>
						<div class="box-body">
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
									<thead>
										<th class="text-center">No</th>
										<th>Nom</th>
										<th class="text-center">Status</th>
										<th class="text-center">Action</th>
									</thead>
									<tbody>
										@if(!empty($org) && count($org) > 0)
											@foreach($org as $key => $orgdata)
											<tr>
												<td class="text-center">{{ ++$key }}</td>
												<td>{{ $orgdata->organizer_name }}</td>
												<td class="text-center">{{ org_status($orgdata->status) }}</td>
												<td class="text-center"><a href="{{ route('org.view',$orgdata->id) }}" class="btn btn-info btn-flat"><i class="fa fa-eye"></i> {{--View--}}Vue</a></td>
											</tr>
											@endforeach
									@else
										<tr>
											<td class="text-center" colspan="4">Enregistrement Introuvable.</td>
										</tr>
									@endif
									</tbody>
								</table>
							 </div>
						</div>
					</div>
				</div><?php */?>

				 
 
				<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title"> Liste des Transactions récentes </h3>
						</div>
						<div class="box-body">
						@if(count($transactions) > 0)
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
									<thead>
									<tr>
									<th>Transaction ID</th>
											<th>
												Evenement
											</th>
											<th>
												Catégorie
											</th>											
											<th>
												Montant
											</th>

											<th>
												Date
											</th>
										</tr>
									</thead>
									<tbody>
									@foreach($transactions as $transaction)
										<tr>
										<td style="font-size:1.1rem">
											{{ $transaction->TICKE_TITLE }}
											</td>
											<td style="font-size:1.2rem">
												{{ $transaction->category_name }}
											</td>											
											<td style="font-size:1.2rem">
												{{ number_format($transaction->TICKE_PRICE, 0,'.', ' ') }}
											</td >
											<td class="text-right" style="font-size:1.2rem">
												 {{ number_format($transaction->TICKE_PRICE, 0,'.', ' ') }}
											</td>

											<td class="small" style="font-size:1.2rem">
												{{ ucwords(Jenssegers\Date\Date::parse($transaction->ORDER_ON)->format('l j F Y H:i'))}}
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>

							@else
							<p class="text-center" colspan="4" >Pas de transactions ! </p>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>

 

		 
</div>
@endsection
