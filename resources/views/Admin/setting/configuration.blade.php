@extends($AdminTheme)
@section('title','Site Settings')
@section('content-header')
	<h1>{{--Settings Configuration--}}Configuration des Paramètres</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> {{--Home--}}Acueil</a></li>
		<li><a href="#">{{--Settings configuration--}}Configuration des Paramètres</a></li>
	</ol>
@endsection
@section('content')
@if($data = \Session::get('success'))
	<div class="alert alert-success">{{ $data }}</div>
@endif
{!! Form::open(array('route' => 'configuration.update','autocomplete'=>'off','files'=>'true','method'=>'post','files'=>true)) !!}
<div class="row">
	<div class="col-lg-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-cc-stripe"></i> &nbsp;Configuration Stripe {{--Configuration--}}</h3>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
						<div class="form-group">
							<label class="form-label">{!! $settings['stripe-client-id']['name'] !!} :</label>
							{!! Form::text($settings['stripe-client-id']['slug'], $settings['stripe-client-id']['value'], array('class' => 'form-control')) !!}
							<span class="help-block"><strong><font color="red">{!! $errors->first($settings['stripe-client-id']['slug']) !!}</font></strong></span>
						</div>
						<div class="form-group">
							<label class="form-label">{!! $settings['stripe-secret-id']['name'] !!} :</label>
							{!! Form::text($settings['stripe-secret-id']['slug'], $settings['stripe-secret-id']['value'], array('class' => 'form-control')) !!}
							<span class="help-block"><strong><font color="red">{!! $errors->first($settings['stripe-secret-id']['slug']) !!}</font></strong></span>
						</div>
						<div class="form-group">
							<label class="form-label">{!! $settings['stripe-currency']['name'] !!} :</label>
							{!! Form::text($settings['stripe-currency']['slug'], $settings['stripe-currency']['value'], array('class' => 'form-control')) !!}
							<span class="help-block"><strong><font color="red">{!! $errors->first($settings['stripe-currency']['slug']) !!}</font></strong></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-linkedin"></i>&nbsp;Configuration&nbsp; Linkedin {{--Configuration--}}</h3>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
						<div class="form-group">
							<label class="form-label">{!! $settings['linkedin-client-id']['name'] !!} :</label>
							{!! Form::text($settings['linkedin-client-id']['slug'], $settings['linkedin-client-id']['value'], array('class' => 'form-control')) !!}
							<span class="help-block"><strong><font color="red">{!! $errors->first($settings['linkedin-client-id']['slug']) !!}</font></strong></span>
						</div>
						<div class="form-group">
							<label class="form-label">{!! $settings['linkedin-secret-id']['name'] !!} :</label>
							{!! Form::text($settings['linkedin-secret-id']['slug'], $settings['linkedin-secret-id']['value'], array('class' => 'form-control')) !!}
							<span class="help-block"><strong><font color="red">{!! $errors->first($settings['linkedin-secret-id']['slug']) !!}</font></strong></span>
						</div>
						<div class="form-group">
							<label class="form-label">{!! $settings['linkedin-redirect-url']['name'] !!} :</label>
							{!! Form::text($settings['linkedin-redirect-url']['slug'], $settings['linkedin-redirect-url']['value'], array('class' => 'form-control')) !!}
							<span class="help-block"><strong><font color="red">{!! $errors->first($settings['linkedin-redirect-url']['slug']) !!}</font></strong></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-twitter"></i>&nbsp;&nbsp; Configuration Twitter {{--Configuration--}}</h3>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
						<div class="form-group">
							<label class="form-label">{!! $settings['twitter-client-id']['name'] !!} :</label>
							{!! Form::text($settings['twitter-client-id']['slug'], $settings['twitter-client-id']['value'], array('class' => 'form-control')) !!}
							<span class="help-block"><strong><font color="red">{!! $errors->first($settings['twitter-client-id']['slug']) !!}</font></strong></span>
						</div>
						<div class="form-group">
							<label class="form-label">{!! $settings['twitter-secret-id']['name'] !!} :</label>
							{!! Form::text($settings['twitter-secret-id']['slug'], $settings['twitter-secret-id']['value'], array('class' => 'form-control')) !!}
							<span class="help-block"><strong><font color="red">{!! $errors->first($settings['twitter-secret-id']['slug']) !!}</font></strong></span>
						</div>
						<div class="form-group">
							<label class="form-label">{!! $settings['twitter-redirect-url']['name'] !!} :</label>
							{!! Form::text($settings['twitter-redirect-url']['slug'], $settings['twitter-redirect-url']['value'], array('class' => 'form-control')) !!}
							<span class="help-block"><strong><font color="red">{!! $errors->first($settings['twitter-redirect-url']['slug']) !!}</font></strong></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-paypal"></i>&nbsp;&nbsp; Configuration PayPal {{--Configuration--}}</h3>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
						<div class="form-group">
							<label class="form-label">{!! $settings['paypal-client-id']['name'] !!} :</label>
							{!! Form::text($settings['paypal-client-id']['slug'], $settings['paypal-client-id']['value'], array('class' => 'form-control')) !!}
							<span class="help-block"><strong><font color="red">{!! $errors->first($settings['paypal-client-id']['slug']) !!}</font></strong></span>
						</div>
						<div class="form-group">
							<label class="form-label">{!! $settings['paypal-secret-id']['name'] !!} :</label>
							{!! Form::text($settings['paypal-secret-id']['slug'], $settings['paypal-secret-id']['value'], array('class' => 'form-control')) !!}
							<span class="help-block"><strong><font color="red">{!! $errors->first($settings['paypal-secret-id']['slug']) !!}</font></strong></span>
						</div>
						<div class="form-group">
							<label class="form-label">{!! $settings['paypal-mode']['name'] !!} :</label>
							{!! Form::text($settings['paypal-mode']['slug'], $settings['paypal-mode']['value'], array('class' => 'form-control')) !!}
							<span class="help-block"><strong><font color="red">{!! $errors->first($settings['paypal-mode']['slug']) !!}</font></strong></span>
						</div>
						<div class="form-group">
							<label class="form-label">{!! $settings['paypal-currency']['name'] !!} :</label>
							{!! Form::text($settings['paypal-currency']['slug'], $settings['paypal-currency']['value'], array('class' => 'form-control')) !!}
							<span class="help-block"><strong><font color="red">{!! $errors->first($settings['paypal-currency']['slug']) !!}</font></strong></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-google"></i>&nbsp;&nbsp; Configuration Google {{--Configuration--}}</h3>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
						<div class="form-group">
							<label class="form-label">{!! $settings['google-client-id']['name'] !!} :</label>
							{!! Form::text($settings['google-client-id']['slug'], $settings['google-client-id']['value'], array('class' => 'form-control')) !!}
							<span class="help-block"><strong><font color="red">{!! $errors->first($settings['google-client-id']['slug']) !!}</font></strong></span>
						</div>
						<div class="form-group">
							<label class="form-label">{!! $settings['google-secret-id']['name'] !!} :</label>
							{!! Form::text($settings['google-secret-id']['slug'], $settings['google-secret-id']['value'], array('class' => 'form-control')) !!}
							<span class="help-block"><strong><font color="red">{!! $errors->first($settings['google-secret-id']['slug']) !!}</font></strong></span>
						</div>
						<div class="form-group">
							<label class="form-label">{!! $settings['google-redirect-url']['name'] !!} :</label>
							{!! Form::text($settings['google-redirect-url']['slug'], $settings['google-redirect-url']['value'], array('class' => 'form-control')) !!}
							<span class="help-block"><strong><font color="red">{!! $errors->first($settings['google-redirect-url']['slug']) !!}</font></strong></span>
						</div>
						<div class="form-group">
							<label class="form-label">{!! $settings['google-api-key']['name'] !!} :</label>
							{!! Form::text($settings['google-api-key']['slug'], $settings['google-api-key']['value'], array('class' => 'form-control')) !!}
							<span class="help-block"><strong><font color="red">{!! $errors->first($settings['google-api-key']['slug']) !!}</font></strong></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-cog"></i>&nbsp;&nbsp; Configuration General {{--Configuration--}}</h3>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
						<div class="form-group">
							<label class="form-label">{!! $settings['bitly-api-key']['name'] !!} :</label>
							{!! Form::text($settings['bitly-api-key']['slug'], $settings['bitly-api-key']['value'], array('class' => 'form-control')) !!}
							<span class="help-block"><strong><font color="red">{!! $errors->first($settings['bitly-api-key']['slug']) !!}</font></strong></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-cog"></i>&nbsp;&nbsp; Social Login {{--Via--}}avec</h3>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-4 col-sm-12 col-xs-12 col-lg-4">
				<div class="form-group">
					<label class="form-label">{!! $settings['google-login']['name'] !!} :</label>
					<br>
					<input name="{!! $settings['google-login']['slug'] !!}" data-toggle="toggle" data-style="android" data-offstyle="info" data-onstyle="success" type="checkbox" data-on="Active" data-off="Deactive" value="1" {!! $settings['google-login']['value'] != 0 ? 'checked':'' !!} {{ $settings['google-client-id']['value'] == '' || $settings['google-secret-id']['value'] == '' && $settings['google-redirect-url']['value'] == '' || $settings['google-api-key']['value'] == '' ?'disabled':'' }}>
				</div>
			</div>
			<div class="col-md-4 col-sm-12 col-xs-12 col-lg-4">
				<div class="form-group">
					<label class="form-label">{!! $settings['linkedin-login']['name'] !!} :</label>
					<br>
					<input name="{!! $settings['linkedin-login']['slug'] !!}" data-toggle="toggle" data-style="android" data-offstyle="info" data-onstyle="success" type="checkbox" data-on="Active" data-off="Deactive" value="1" {!! $settings['linkedin-login']['value'] != 0 ? 'checked':'' !!} {{ $settings['linkedin-client-id']['value'] == '' || $settings['linkedin-secret-id']['value'] == '' || $settings['linkedin-redirect-url']['value'] == '' ?'disabled':'' }}>
				</div>
			</div>
			<div class="col-md-4 col-sm-12 col-xs-12 col-lg-4">
				<div class="form-group">
					<label class="form-label">{!! $settings['twitter-login']['name'] !!} :</label><br>
					<input name="{!! $settings['twitter-login']['slug'] !!}" data-toggle="toggle" data-style="android" data-offstyle="info" data-onstyle="success" type="checkbox" data-on="Active" data-off="Deactive" value="1" {!! $settings['twitter-login']['value'] != 0 ? 'checked':'' !!} {{ $settings['twitter-client-id']['value'] == '' || $settings['twitter-secret-id']['value'] == '' || $settings['twitter-redirect-url']['value'] == ''?'disabled':'' }}>
					<br>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="box box-primary">
	<div class="box-body text-center">
		<button type="submit" class="btn btn-flat btn-success"><i class="fa fa-edit"></i> Update Configuration</button>
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