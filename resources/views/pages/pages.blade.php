@extends($theme)
@php
	$title = ! is_null($pdata->title)?env('SEOPREFIX').' - '.$pdata->title:setMetaData()->page_title;
	$keysa = ! is_null($pdata->keyword)?env('SEOPREFIX').' - '.$pdata->keyword:setMetaData()->page_keyword;
	$descs = ! is_null($pdata->description)?env('SEOPREFIX').' - '.$pdata->description:setMetaData()->page_desc;
@endphp
@section('meta_title',$title)
@section('meta_description',$descs)
@section('meta_keywords',$keysa)
@section('content')
	<div class="container-fluid about-wrapper">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-lg-12 col-sm-12 about-parents-wrapper-min">
					<h2 class="text-uppercase about-title col-lg-6">{!! $pdata->page_title !!}</h2>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-md-12 col-lg-12 parent-about-content">
				{!! $pdata->page_desc !!}
			</div>
		</div>
	</div>

@endsection
