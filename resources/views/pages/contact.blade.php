@extends($theme)

@section('meta_title',setMetaData()->page_title.$data['contact-page-title']['value'])
@section('meta_description',setMetaData()->page_desc)
@section('meta_keywords',setMetaData()->page_keyword)

@section('content')


 <div class="col-md-12 cover-img" style="background: url('{{asset('/img/contacthd.png')}}'); height: auto; padding-top: 21%; background-size: contain; margin-top: 0px ">
	<div class="container">
		<div class="editCover"></div>
	</div>
</div>
<!--Cover-->		
<div class="container" id="single-artistes">
	<div class="row">
		<!--Photo de profil-->
		<div class="col-lg-12 col-sm-12 col-xs-12 text-center">
			<div class="row">
					<div class="contact profile" style="margin-bottom: 25px">
						<img src="{{ url('/') }}/public/img/plecy.png" id="ingOup" class="img-fluid">
					</div>
				</div>
				@if($errors->has('profile_pics')) <span style="font-size: 17px;font-style: normal;text-align: center;width: 100%;font-weight: bold;color: red;" class="error">{{ $errors->first('profile_pics') }}</span> @endif
				<div style="font-size: 11px; text-align: center; width: 100%;"><b style="font-size: 22px; display: block; font-weight: bold; letter-spacing: normal">Hello! Moi c'est plecy.</b><br>Je suis disponible pour toutes tes demandes, questions, suggestions sur My Place Events ♥<br> N’hésite pas à me contacter via le formulaire ci-dessous. Je ne mords pas 🙂 et je te répondrai le plus tôt possible.</div>
			</div>
		</div>
	</div>

 
	<div class="container" style="padding-bottom: 100px; display: block">
 
		<div class="row contact-header">
			@if($success = Session::get('success'))
				<div class="col-lg-12">
					<div class="alert alert-success">{{ $success }}</div>
				</div>
			@endif
			
			<div class="col-lg-3 contactinfo" style="bottom: 0px; position: relative">
			 
				<div class="row">
					<div class="col-lg-12 text-center content-title">
					   <h1 style="margin-bottom: 0; font-size: 20px;" class="top-presta contact section-title">MY PLACE EVENTS</h1>
					</div>				 
					
					<div class="col-lg-12" style="margin-bottom: 5px;">
						 <div class="row">
							<div class="col-lg-3 ctText">
								Tel:
							</div>
							<div class="col-lg-9 contact-text">
								<p>{!! $data['contact-page-phone']['value'] !!}</p>
							</div>
						</div>
					</div>	
					<div class="col-lg-12" style="margin-bottom: 5px;">
						 <div class="row">
							<div class="col-lg-3 ctText">
								Email:
							</div>
							<div class="col-lg-9 contact-text">
								<p>{!! $data['contact-page-email']['value'] !!}</p>
							</div>
						</div>
					</div>	
					<div class="col-lg-12">
						 <div class="row">
							<div class="col-lg-3 ctText">
								Lieu:
							</div>
							<div class="col-lg-9 contact-text">
								<p>{!! $data['contact-page-address']['value'] !!}</p>
							</div>
						</div>
					</div>
				 				
				</div>
			
			</div>
			<div class="col-lg-6 contact-form">
				<form method="POST" action="{{ route('contact.post') }}">
					<input type="hidden" name="_token" value="{!! csrf_token() !!}" />				
					<div class="row">
						<div class="col-md">
							<div class="form-group">
								<input type="text" name="name" class="form-control form-textbox" placeholder="@lang('words.cont_pg.cont_nm')" />
							</div>
								@if($errors->has('name')) <span class="error">{{ $errors->first('name') }}</span>@endif
						</div>
						<div class="col-md">
							<div class="form-group">
								<input type="email" name="email" class="form-control form-textbox" placeholder="@lang('words.cont_pg.cont_mi')" />
							</div>
								@if($errors->has('email')) <span class="error">{{ $errors->first('email') }}</span>@endif
						</div>
						
					</div>
					<div class="row">
						<div class="col-md">
							<div class="form-group">
								<input type="text" name="subject" class="form-control form-textbox" placeholder="@lang('words.cont_pg.cont_su')" />
							</div>
								@if($errors->has('subject')) <span class="error">{{ $errors->first('subject') }}</span>@endif
						</div>
					</div>	
					<div class="row">
						<div class="col-md">
							<div class="form-group">
								<textarea class="form-control form-textbox" rows="2" cols="5" placeholder="@lang('words.cont_pg.cont_me')" name="message"></textarea>
							</div>
								@if($errors->has('message')) <span class="error">{{ $errors->first('message') }}</span>@endif
						</div>
					</div>
					<!-- champ formulaire  recaptcha -->
					<div class="g-recaptcha" data-sitekey="6LcwcfMpAAAAAMQXMNhYHYIslB4ZdZMGnWowqaJb" data-action="LOGIN"></div>
					<!-- champ formulaire  recaptcha -->
					<div class="row">
						<div class="col-md-12 col-ms-12 col-lg-12" style="text-align: right">
							<input type="submit" value="@lang('words.cont_pg.cont_se')" class="createEventBut2" />
						</div>	
					</div>
					
				</form>
			</div>
			<div class="col-lg-3"></div>
		</div>
		
		
		
<!-- <section class="" id="nos-services" style="padding: 0;  clear: both">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center content-title">
        <h1 style="margin-bottom: 0;" class="section-title"><a href="javascript:void(0)">Organisateurs Partenaires</a></h1>
      </div>
    </div>
  </div>
<style>
    .partenaires-slide{padding: 15px 20px; background-color:#fff;}
</style>
    <div class="linedivide"></div>
    <div class="partenaires-slide" style="background-color:unset">
      <div class="col-lg-4 col-md-6 col-sm-12 text-center">
        <div class="hover-cover">
            <img src="{{ asset('/upload/partenaires/Montreux-Comedie.png')}}" alt="Montreux Comedie" style="margin: auto;max-width: 100%" class="service" />
        </div>
      </div>

      <div class="col-lg-4 col-md-6 col-sm-12  text-center">
        <div class="hover-cover">
            <img src="{{ asset('/upload/partenaires/TEDxTreichville1.png')}}" alt="TEDx Treichville" style="margin: auto;max-width: 100%" class="service" />
        </div>
      </div>

      <div class="col-lg-4 col-md-6 col-sm-12 text-center">
        <div class="hover-cover">
            <img src="{{ asset('/upload/partenaires/Festival-Afropolitain-Nomade.png')}}" alt="Festival Afropolitain Nomade" style="margin: auto;max-width: 100%" class="service" />           
        </div>
      </div>

      <div class="col-lg-4 col-md-6 col-sm-12 text-center">
        <div class="hover-cover">
            <img src="{{ asset('/upload/partenaires/ADICOM-DAYS.png')}}" alt="ADICOM DAYS" style="margin: auto;max-width: 100%" class="service" />
          
        </div>
      </div>

      <div class="col-lg-4 col-md-6 col-sm-12  text-center">
        <div class="hover-cover">
            <img src="{{ asset('/upload/partenaires/FID.png')}}" alt="Forum Ivoirien du Digital" style="margin: auto;max-width: 100%" class="service" />
          
        </div>
      </div>

      <div class="col-lg-4 col-md-6 col-sm-12  text-center">
        <div class="hover-cover">
            <img src="{{ asset('/upload/partenaires/GoogleDEV.png')}}" alt="Google Developer" style="margin: auto;max-width: 100%" class="service" />
          
        </div>
      </div>

      <div class="col-lg-4 col-md-6 col-sm-12 text-center">
        <div class="hover-cover">
            <img src="{{ asset('/upload/partenaires/universal-music-africa.png')}}" alt="Universal Music Africa" style="margin: auto;max-width: 100%" class="service" />
          
        </div>
      </div>

    </div>
     <div class="linedivide"></div>

</section>
		 -->
		
		
		
	</div>
<style>
	.footer-wrapper{
		display: none;
	}
</style>
@endsection


@section('pageScript')

<script>
    
if ($(window).width() > 600) 
   {         
      $('.partenaires-slide').slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      autoplay: true,
      lazyLoad: 'ondemand',
      autoplaySpeed: 3500,
      prevArrow: "<button type='button' class='slick-prev'></button>",
      nextArrow: "<button type='button' class='slick-next slick-arrow'></button>",
      responsive: [
      {
        breakpoint: 1024,
        settings: {
          arrows: true,
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true,
          dots: true
        }
      },
      {
        breakpoint: 990,
        settings: {
          arrows: true,
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 600,
        settings: {
          centerMode: true,
          arrows: true,
          slidesToShow: 1,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 380,
        settings: {
          centerMode: false,
          arrows: true,
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
      // You can unslick at a given breakpoint now by adding:
      // settings: "unslick"
      // instead of a settings object
      ]
    });
    
   }
	else{  
	   
    $('.partenaires-slide').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      lazyLoad: 'ondemand',
      autoplaySpeed: 3500,
      prevArrow: "<button type='button' class='slick-prev'></button>",
      nextArrow: "<button type='button' class='slick-next slick-arrow'></button>"
    });     
	   
   }
</script>

@endsection
