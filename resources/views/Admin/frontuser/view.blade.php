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
												<td><p>{{ $data->firstname }} {{ $data->lastname }}</p></td>
											</tr>
											<tr>
												<th>Email</th>
												<td>{{ $data->email }}</td>
											</tr>
											<tr>
												<th>{{--Cellphone--}}Téléphone portable</th>
												<td>{{ $data->cellphone }}</td>
											</tr>
											<tr>
												<th>{{--Website--}}Site Web</th>
												<td>{{ $data->website }}</td>
											</tr>
											<tr>
												<th>{{--Address--}}Adresse</th>
												<td>{{ $data->address }}</td>
											</tr>
											<tr>
												<th>{{--Postal Code--}}Code Postale</th>
												<td>{{ $data->postalcode }}</td>
											</tr>
											<tr>
												<th>{{--Country--}}Pays</th>
												<td><span class="bfh-countries" data-country="{{ $data->country }}" ></span></td>
											</tr>
											<tr>
												<th>{{--State--}}Etat</th>.
												<td><span class="bfh-states" data-country="{{ $data->country }}" data-state="{{ $data->state }}"></span></td>
											</tr>
											<tr>
												<th>{{--City--}}Cité</th>
												<td>{{ $data->city }}</td>
											</tr>
											<tr>
												<th>{{--Reason--}}Raison</th>
												<td></td>
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
				<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">{{--Action Details--}}Détails Création</h3>
						</div>
						<div class="box-body">
							@if($data->status == 0)
								<a href="{{ route('front.status',array($data->id,'1')) }}" class="btn btn-success btn-flat"><i class="fa fa-check"></i> Active</a>
							@elseif($data->status == 1)
								<a href="{{ route('front.status',array($data->id,'3')) }}" class="btn btn-danger btn-flat"><i class="fa fa-ban"></i> {{--Disabled--}}Desactive</a>
							@elseif($data->status == 3)
								<a href="{{ route('front.status',array($data->id,'1')) }}" class="btn btn-info btn-flat"><i class="fa fa-check"></i> {{--Enabled--}}Activé</a>
							@else
								<a href="{{ route('front.status',array($data->id,'1')) }}" class="btn btn-success btn-flat"><i class="fa fa-check"></i> Active</a>
							@endif

						</div>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Details Organisation</h3>
						</div>
						<div class="box-body">
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
									<thead>
										<th class="text-center">No</th>
										<th>{{--Name--}}Nom</th>
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
															<td class="text-center" colspan="4">{{--Record Not found--}}Enregistrement Introuvable.</td>
														</tr>
													@endif
													</tbody>
												</table>
										</div>
						</div>
					</div>
				</div>

				<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">{{--Bank Details--}}Détails Banquaire</h3>
						</div>
						<div class="box-body">
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
													<tbody>
														@if(!empty($bank) && count($bank) > 0)
															@foreach($bank as $key => $bankDetails)
															<tr>
																<th>{{ ucfirst(str_replace('-', ' ', $bankDetails->field)) }}</th>
																<td>{{ $bankDetails->value }}</td>
															</tr>
															@endforeach
													@else
														<tr>
															<td class="text-center" colspan="4">{{--Record Not found.--}}Enregistrement Introuvable</td>
														</tr>
													@endif
													</tbody>
												</table>
										</div>
						</div>
					</div>
				</div>

				<!--Wallet-->
				<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title"> Liste des 5 dernières Transactions </h3>
						</div>
						<div class="box-body">
						@if(count($data->transactions) > 0)
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
									<thead>
									<tr>
									<th>
												Transaction ID
											</th>
											<th>
												Type
											</th>
											<th>
												Montant
											</th>
											<th>
												Description
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
											{{ $transaction->uuid }}
											</td>
											<td style="font-size:1.2rem">
												@if($transaction->type === "deposit")
														<span class="badge badge-flat border-grey-800 text-default text-capitalize">{{$transaction->type}}</span>
												@else
													<span class="badge badge-flat border-grey-800 text-danger text-capitalize">{{$transaction->type}}</span>
												@endif
											</td >
											<td class="text-right" style="font-size:1.2rem">
												 {{ number_format($transaction->amount, 0,'.', ' ') }}
											</td>
											<td style="font-size:1.2rem">
												{{ $transaction->meta["description"] }}
											</td>
											<td class="small" style="font-size:1.2rem">
												{{ ucwords(Jenssegers\Date\Date::parse($transaction->created_at)->format('l j F Y H:i'))}}
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

		<div class="col-lg-12 col-md-12 col-sm-10 col-xs-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Solde Portefeuille :<b>   {{ number_format($data->balance , 0,'.', ' ') }} F CFA</b></h3>
				</div>
				<div class="box-body">
          <!--
					<button class="btn btn-success btn-labeled btn-labeled-left mr-2" disabled id="addAmountButton"><b><i class="icon-plus2"></i></b>Ajouter Montant</button>
          -->
					<form action="{{ route('addOrSubstractMoneyToWallet', ['id' => $data->id]) }}" method="POST" id="addAmountForm" style="margin-top: 2rem;"  >
											{{csrf_field()}}
											<div class="form-group row">
													<label class="col-lg-2 col-form-label"><span class="text-danger">*</span> Montant </label>
													<div class="col-lg-7">
															<input type="number" class="form-control form-control-lg balance" name="add_amount"
																	placeholder="Ajouter ou retirer un montant" required>
													</div>
											</div>
											<div class="form-group row">
                        <label class="col-lg-2 col-form-label"><span class="text-danger">*</span> Motif:</label>
                        <div class="col-lg-7">
                            <input type="text" class="form-control form-control-lg" name="add_amount_description"
                                placeholder="Motif de la transaction" required>
                        </div>
                    </div>

										<div class="row">
												<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
												</div>
											  <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
														<button type="submit" class="btn btn-danger" name="withdraw" value="withdraw">
														Débiter le Compte
														<i class="icon-database-insert ml-1"></i>
														</button>
												</div>

												<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
														<button type="submit" class="btn btn-success" name="deposit" value="deposit">
														Créditer le Compte
														<i class="icon-database-insert ml-1"></i>
														</button>
												</div>
										</div>

					</form>
				</div>
			</div>
	 </div>

		<div class="col-lg-12 col-md-12 col-sm-10 col-xs-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Détails Events</h3>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
								<th class="text-center">No</th>
								<th>{{--Name--}}Nom</th>
								<th class="text-center">Status</th>
								<th class="text-center">{{--Ban--}}Interdire</th>
								<th class="text-center">Action</th>
							</thead>
											<tbody>
												@if(!empty($event) && count($event) > 0)
												@foreach($event as $key => $eventdata)
													<tr>
														<td class="text-center">{{ ++$key }}</td>
														<td>{{ $eventdata->event_name }}</td>
														<td class="text-center">{{ status($eventdata->event_status) }}</td>
														<td class="text-center">{{ org_status($eventdata->ban) }}</td>
														<td class="text-center"><a href="{{ route('events.view',$eventdata->id) }}" class="btn btn-info btn-flat"><i class="fa fa-eye"></i> {{--View--}}Vue</a>
															@if($eventdata->ban == 0)
											<a href="{{ route('events.ban',$eventdata->id) }}" class="btn-flat btn btn-success" ><i class="fa  fa-check"></i> {{--Enabled--}}Activé</a>
										@else
											<a href="{{ route('events.revoke',$eventdata->id) }}" class="btn-flat btn btn-danger"><i class="fa fa-close"></i> {{--Disabled--}}Désactivé</a>
										@endif
														</td>
													</tr>
												@endforeach
											@else
												<tr>
														<td colspan="5" class="text-center"> {{--Record Not Found.--}}Enregistrement Introuvable</td>
												</tr>
											@endif
											</tbody>
									</table>
								</div>
				</div>
			</div>
		</div>
</div>
@endsection
