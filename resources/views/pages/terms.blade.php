@extends($theme)

@section('meta_title',setMetaData()->page_title.$data['terms-page-title']['value'])
@section('meta_description',setMetaData()->page_desc)
@section('meta_keywords',setMetaData()->page_keyword)


@section('content')
	<div class="container-fluid about-wrapper">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-lg-12 col-sm-12 about-parents-wrapper-min">
					<h2 class="text-uppercase about-title col-lg-6">{!! $data['terms-page-title']['value'] !!}</h2>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-md-12 col-lg-12 parent-about-content">
				{!! $data['terms-page-content']['value'] !!}
			</div>
		</div>
	</div>

@endsection

