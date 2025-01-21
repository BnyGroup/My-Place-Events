@extends($AdminTheme)
@section('title','Site Settings')
@section('content-header')
	<h1>{{--Settings--}}Paramètres</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Accueil</a></li>
		<li><a href="#">{{--Settings--}}Paramètres</a></li>
	</ol>
@endsection
<style type="text/css">
  .toggle.android { border-radius: 0px;}
  .toggle.android .toggle-handle { border-radius: 0px; }
</style>
@section('content')
@if($data = \Session::get('success'))
	<div class="alert alert-success">{{ $data }}</div>
@endif
{!! Form::open(array('route' => 'settings.update','autocomplete'=>'off','files'=>'true','method'=>'post','files'=>true)) !!}
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"><i class="fa fa-cog"></i>&nbsp;&nbsp; {{--Site Settings--}}Paramètre du site</h3>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
				<div class="row">
					<div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">
						<div class="form-group">
							<label class="form-label">{!! $settings['site-front-logo']['name'] !!} : </label>
							{!! Form::file($settings['site-front-logo']['slug'],['class'=>'form-control col-lg-6 col-md-6']) !!}	
							{!! Form::hidden('image_old',$settings['site-front-logo']['value']) !!}	
							<span class="help-block"><strong><font color="red">{!! $errors->first($settings['site-front-logo']['slug']) !!}</font></strong></span>
						</div>
					</div>
					<div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 text-center">
						<img src="{{asset('/img/'.$settings['site-front-logo']['value'])}}" style="max-height:100px; max-width: 100%;">
					</div>
				</div>

				<div class="row">
					<div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">
						<div class="form-group">
							<label class="form-label">{!! $settings['site-favicon-logo']['name'] !!} : </label>
							{!! Form::file($settings['site-favicon-logo']['slug'],['class'=>'form-control col-lg-6 col-md-6']) !!}	
							{!! Form::hidden('faviimage_old',$settings['site-favicon-logo']['value']) !!}	
							<span class="help-block"><strong><font color="red">{!! $errors->first($settings['site-favicon-logo']['slug']) !!}</font></strong></span>
						</div>
					</div>
					<div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 text-center">
						<br/>
						<img src="{{asset('/img/'.$settings['site-favicon-logo']['value'])}}" height="50">
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">
						<div class="form-group">
							<label class="form-label">{!! $settings['site-title-name']['name'] !!} :</label>
							{!! Form::text($settings['site-title-name']['slug'], $settings['site-title-name']['value'], array('class' => 'form-control')) !!}
							<span class="help-block"><strong><font color="red">{!! $errors->first($settings['site-title-name']['slug']) !!}</font></strong></span>
						</div>
						<div class="form-group">
							<label class="form-label">{!! $settings['site-tag-line']['name'] !!} :</label>
							{!! Form::text($settings['site-tag-line']['slug'], $settings['site-tag-line']['value'], array('class' => 'form-control')) !!}
							<span class="help-block"><strong><font color="red">{!! $errors->first($settings['site-tag-line']['slug']) !!}</font></strong></span>
						</div>
						<div class="form-group">
							
							<label class="form-label">{!! $settings['commison-set']['name'] !!} : {!! $settings['commison-set']['note']!=''?' ( '.$settings['commison-set']['note'].' )':'' !!}</label>
							{!! Form::text($settings['commison-set']['slug'], $settings['commison-set']['value'], array('class' => 'form-control','onkeypress' => 'return isNumber(event)')) !!}
							<span class="help-block"><strong><font color="red">{!! $errors->first($settings['commison-set']['slug']) !!}</font></strong></span>
						</div>
					</div>
					<div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">
						<br><br><br>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
									<label class="form-label">{!! $settings['commision-currency-set']['name'] !!} :</label>
									<select class="input-medium bfh-currencies form-control" id="currency" data-currency="{{$settings['commision-currency-set']['value']}}" name="{{$settings['commision-currency-set']['slug']}}"></select>
									<span class="help-block"><strong><font color="red">{!! $errors->first($settings['commision-currency-set']['slug']) !!}</font></strong></span>
								</div>
								<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
									<label class="form-label">{!! $settings['currency-symbol']['name'] !!} :</label>
									<select class="form-control"  name="{!! $settings['currency-symbol']['slug'] !!}" id="currencySymobl">
										<option value=""> {{--Select Currency Symbol--}}Sélectionnez le symbole monétaire</option>
										@php
											$currencySym = currencies_symbol(); 
											$currencySym = json_decode($currencySym);
										@endphp
										@foreach($currencySym as $key => $value)
											@if(isset($settings['currency-symbol']['value']) && !empty($settings['currency-symbol']['value']))
												<option value="{{ $key.'|'.htmlspecialchars($value) }}" {!! $settings['currency-symbol']['value'] == $key.'|'.htmlspecialchars($value)?'selected':'' !!}>{{ $key }} - {{ $value }}</option>
											@else
												<option value="{{ $key.'|'.htmlspecialchars($value) }}">{{ $key }} - {{ $value }}</option>
											@endif
										@endforeach
									</select>
									<span class="help-block"><strong><font color="red">{!! $errors->first($settings['currency-symbol']['slug']) !!}</font></strong></span>
									
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
								<label class="form-label">{!! $settings['time-zone-set']['name'] !!} :</label>
									<select id="countries_timezones1" class="form-control bfh-countries" data-country="{{$settings['time-zone-set']['value']}}" name="{{$settings['time-zone-set']['slug']}}"></select>
									<span class="help-block"><strong><font color="red">{!! $errors->first($settings['time-zone-set']['slug']) !!}</font></strong></span>
								</div>
								<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
									<label class="form-label">{!! $settings['time-zone-city']['name'] !!} :</label>
									<select class="form-control bfh-timezones" data-country="countries_timezones1" name="{{$settings['time-zone-city']['slug']}}" data-timezone="{{ $settings['time-zone-city']['value'] }}"></select>
									<span class="help-block"><strong><font color="red">{!! $errors->first($settings['time-zone-city']['slug']) !!}</font></strong></span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
						<div class="form-group">
							<label class="form-label">{!! $settings['site-about']['name'] !!} :</label>
							{!! Form::textarea($settings['site-about']['slug'], $settings['site-about']['value'], array('class' => 'form-control', 'size'=>'3x6', 'maxlength' => 300 )) !!}
							<span class="help-block"><strong><font color="red">{!! $errors->first($settings['site-about']['slug']) !!}</font></strong></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"><i class="fa fa-cog"></i>&nbsp;&nbsp; {{--Home Page Header Image--}}Image d'en-tête de page d'accueil</h3>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">
				<div class="form-group">
					<label class="form-label">{!! $settings['site-header-image']['name'] !!} : </label> <span>(Size = 1280X400 )</span>
					{!! Form::file($settings['site-header-image']['slug'],['class'=>'form-control col-lg-6 col-md-6']) !!}	
					{!! Form::hidden('header_image_old',$settings['site-header-image']['value']) !!}	
					<span class="help-block"><strong><font color="red">{!! $errors->first($settings['site-header-image']['slug']) !!}</font></strong></span>
				</div>
				<div class="clearfix"><br/><br/></div>
				<div class="form-group">
					<label class="form-label">{!! $settings['site-header-img-text']['name'] !!} : </label>
					{!! Form::text($settings['site-header-img-text']['slug'], $settings['site-header-img-text']['value'], array('class' => 'form-control', 'maxlength' => 125)) !!}
					<span class="help-block"><strong><font color="red">{!! $errors->first($settings['site-header-img-text']['slug']) !!}</font></strong></span>
				</div>
			</div>
			<div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 text-center">
				@if($settings['site-header-image']['value'] != '')
					<img src="{{asset('/img/'.$settings['site-header-image']['value'])}}" class="img-responsive" />
				@endif
			</div>
		</div>
	</div>
</div>

<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"><i class="fa fa-cog"></i>&nbsp;&nbsp; {{--Email Configuration--}}Configuration Email</h3>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-4 col-sm-12 col-xs-12 col-lg-4">
				<div class="form-group">
					<label class="form-label">{!! $settings['mail-server-side']['name'] !!} :</label>
					{!! Form::text($settings['mail-server-side']['slug'], $settings['mail-server-side']['value'], array('class' => 'form-control')) !!}
					<span class="help-block"><strong><font color="red">{!! $errors->first($settings['mail-server-side']['slug']) !!}</font></strong></span>
				</div>
				<div class="form-group">
					<label class="form-label">{!! $settings['mail-port']['name'] !!} :</label>
					{!! Form::text($settings['mail-port']['slug'], $settings['mail-port']['value'], array('class' => 'form-control')) !!}
					<span class="help-block"><strong><font color="red">{!! $errors->first($settings['mail-port']['slug']) !!}</font></strong></span>
				</div>
			</div>
			<div class="col-md-4 col-sm-12 col-xs-12 col-lg-4">
				<div class="form-group">
					<label class="form-label">{!! $settings['mail-driver']['name'] !!} :</label>
					{!! Form::text($settings['mail-driver']['slug'], $settings['mail-driver']['value'], array('class' => 'form-control')) !!}
					<span class="help-block"><strong><font color="red">{!! $errors->first($settings['mail-driver']['slug']) !!}</font></strong></span>
				</div>
				<div class="form-group">
					<label class="form-label">{!! $settings['mail-username']['name'] !!} :</label>
					{!! Form::text($settings['mail-username']['slug'], $settings['mail-username']['value'], array('class' => 'form-control')) !!}
					<span class="help-block"><strong><font color="red">{!! $errors->first($settings['mail-username']['slug']) !!}</font></strong></span>
				</div>
			</div>
			<div class="col-md-4 col-sm-12 col-xs-12 col-lg-4">
				<div class="form-group">
					<label class="form-label">{!! $settings['mail-host']['name'] !!} :</label>
					{!! Form::text($settings['mail-host']['slug'], $settings['mail-host']['value'], array('class' => 'form-control')) !!}
					<span class="help-block"><strong><font color="red">{!! $errors->first($settings['mail-host']['slug']) !!}</font></strong></span>
				</div>
				<div class="form-group">
					<label class="form-label">{!! $settings['mail-password']['name'] !!} :</label>
					{{--{!! Form::password($settings['mail-password']['slug'], $settings['mail-password']['value'], array('class' => 'form-control')) !!} --}}

					<input type="password" name="{!!$settings['mail-password']['slug']!!}" value="{{$settings['mail-password']['value']}}" class="form-control">
					

					<span class="help-block"><strong><font color="red">{!! $errors->first($settings['mail-password']['slug']) !!}</font></strong></span>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="box box-primary">
	<div class="box-body text-center">
		<input type="submit"  value="Save Site Settings" class="btn btn-flat btn-success btn-lg">
	</div>
</div>
{!! Form::close() !!}
<script type="text/javascript">
	function isNumber(evt)
	{
	   var charCode = (evt.which) ? evt.which : event.keyCode
	   if (charCode == 46)
	   {
	       var inputValue = $("#inputfield").val()
	       if (inputValue.indexOf('.') < 1)
	       {
	           return true;
	       }
	       return false;
	   }
	   if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
	   {
	       return false;
	   }
	   return true;
	}
</script>
@endsection