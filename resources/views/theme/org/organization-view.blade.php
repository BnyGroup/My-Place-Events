@extends($theme)
@section('meta_title',setMetaData()->org_single_title.' - '.$data->organizer_name )
@section('meta_description',setMetaData()->org_single_desc)
@section('meta_keywords',setMetaData()->org_single_keyword)
@section('content')

<?php
 if(!empty($data->cover)){
	 $bcover="background: url('".getImage($data->cover)."')";
 }else{
	 $bcover="";
 }
?>
    <section class="cover-wide" style="{{$bcover}}">
        <div class="container">

            <div class="row v-align-children">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                    <!--Organizer profile picture-->
					<?php
						if(($data->oauth_provider)== null){
							$prof=setThumbnail($data->profile_pic);
						}else{
							$prof=url($data->profile_pic);
						}
					
					?>
                    <div class="profile-picture text-center" style="background: url('{{$prof}}'); background-size: cover;">
                       &nbsp;
                    </div>
                    <!--Organizer profile picture-->
                </div>
                <div class="col-md-5 right-side">
                    <!--Liste des infos de l'organisateur-->
                    <ul class="lead mb0" style="list-style-type: none;">
                        <li><h2 class="mb0 primary-color"><strong><i class="far fa-user"></i> {{ $data->organizer_name }} </strong></h2>
                        </li>
                        <li><h5 class="mb0"><strong class="primary-color"><i class="fas fa-phone primary-color"></i>
                                    Téléphone: </strong>
                                <strong class="third-color">{{ $cellphone=($data->cellphone)?$data->cellphone:'-'}}</strong></h5></li>
                        <li><h5 class="mb0"><strong class="primary-color"><i class="far fa-envelope primary-color"></i>
                                    Email:</strong>{{--{{ dd($data) }}--}}
                                <strong class="third-color">{{--iboericlandry@gmail.com--}}{{ $data->email }}</strong></h5></li>
                        {{--<li><a class="btn btn-filled secondary-bg" href="#ex1" rel="modal:open"
                               style="border-color: #FCBD0D; margin-top: 15px;"> <i class="far fa-envelope"></i>
                                Contacter </a>
                        </li>--}}
                        <li>
                            <!--Boutons social Net work-->

                            <div style="margin-top: 15px">
                                @php $facebook_url = str_replace('facebook.com/','',$data->facebook_page); @endphp
                                @if($facebook_url != '')
                                <a href="{{ $data->facebook_page }}" class="btn btn-sm btn-rds fb" style="border-radius: 50% !important;" target="_blank"><i class="fab fa-facebook-square"></i></a>
                                @endif

                                @php $twitter_url = str_replace('@','',$data->twitter); @endphp
                                @if($twitter_url != '')
                                        <a href="{{ $data->twitter }}" class="btn btn-sm btn-rds twt" style="border-radius: 50% !important;" target="_blank"><i class="fab fa-twitter"></i></a>
                                @endif

{{--                                @php $instagram_url = str_replace('@','',$data->instagram); @endphp--}}
                                @if($data->instagram != '')
                                    <a href="{{ $data->instagram }}" class="btn btn-sm btn-rds twt" style="border-radius: 50% !important;" target="_blank"><i class="fab fa-instagram"></i></a>
                                @endif
                            </div>
                            <!--Boutons social Net work-->
                        </li>
                    </ul>
                    <!--Liste des infos de l'organisateur-->
                </div>

                <div class="col-md-2"></div>
            </div>
            <!--end of row-->
        </div>
        <!--end of container-->
    </section>

    <div class="container" style="padding-bottom: 50px;">         
        <div class="row">

            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 orz-view">
                <h2 class="profile-title">@lang('words.organiser_detial_page.org_eve') {{$data->organizer_name}}</h2>
                <br>
            </div>

            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                @if(!empty($events))
                    <div class="row ">
                        @foreach($events as $data)
                            @if($data->event_start_datetime > \Carbon\Carbon::now())

                                 <div class="col-lg-4 col-md-6 col-sm-12 hover ">
           
    <?php /*<div class="box-icon pull-right share-listing">
        <a href="javascript:void(0)" data-toggle="tooltip"
           data-original-title="@lang('words.events_box_tooltip.share_tooltip')"
           data-placement="right" class="event-share"
           data-url="{{route('events.details',$data->event_slug)}}"
           data-name="{{ $data->event_name }}" data-loca="{{ $data->event_location }}">
            <i class="fas fa-share"></i>
        </a>
    </div> 
 
        @if(auth()->guard('frontuser')->check())
            @php $userid = auth()->guard('frontuser')->user()->id  @endphp
        @else
            @php $userid = ''  @endphp
        @endif
		
		@if(is_null(getbookmark($data->event_unique_id, $userid)))
		   <div class="box-icon pull-right like-listing" id="userlike-{{$data->event_unique_id}}">
				<a href="javascript:void(0)" data-toggle="tooltip"
				   data-original-title="@lang('words.events_box_tooltip.save_tooltip')"
				   data-placement="right" id="save-event" class="nouserconn" data-user="{{$userid}}"
				   data-event="{{ $data->event_unique_id }}" data-mark="0">
					@if(is_null(getbookmark($data->event_unique_id, $userid)))
						<i class="far fa-heart"></i>
					@else
						<i class="fas fa-heart"></i>
					@endif
				</a>		
			 </div>
		@else
		<div class="box-icon pull-right like-listing addedbm" id="userlike-{{$data->event_unique_id}}">   
			<a href="javascript:void(0)" data-toggle="tooltip"
			   data-original-title="@lang('words.events_box_tooltip.save_tooltip')"
			   data-placement="right" id="save-event" class="save-event " data-user="{{$userid}}"
			   data-event="{{ $data->event_unique_id }}" data-mark="0">
				@if(is_null(getbookmark($data->event_unique_id, $userid)))
					<i class="far fa-heart"></i>
				@else
					<i class="fas fa-heart"></i>
				@endif
			</a>	
		 </div>
		@endif
		 
        <!-- <i class="fa fa-bookmark-o"><a href="#"></a></i> -->
    */ ?>
    
    <div class="box" style="position: relative;">

        
       <a href="{{ route('events.details',$data->event_slug) }}"><div class="bunique" style="background-image: url('{{ getImage($data->event_image, 'thumb') }}'); "><?php /*?><a href="{{ route('events.details',$data->event_slug) }}"><img
                    src="{{ getImage($data->event_image, 'thumb') }}"
                    alt="{{ $data->event_name }}"/></a><?php */?></div></a>

        <div class="box-content card__padding">
            <div class="innercardbox">
                
                <div class="left_innerbox">
                    <h4 class="card-title"><a  href="{{ route('events.details',$data->event_slug) }}">{{ $data->event_name }}</a></h4>
                    <div class="prix">
                        <a href="{{ route('events.details',$data->event_slug) }}" class=""><span class="">
                                @if($data->event_min_price == 0)
                                    GRATUIT
                                @else
                                     {!! number_format($data->event_min_price, 0, "."," ") !!} {!! use_currency()->symbol !!}
                                @endif
                                @if($data->event_min_price != $data->event_max_price)
                                    - {!! number_format($data->event_max_price, 0, "."," ") !!} {!! use_currency()->symbol !!}
                                @endif
                                     </span></a>
                    </div> 
                    <div class="card__location">
                        <div class="card__location-content">
                            <i class="fas fa-map-marker-alt primary-color"></i>
                            <a href="{{ route('events.details',$data->event_slug) }}" rel="tag"
                               class="third-color bold"> {{ $data->event_location }}</a>
                        </div>
                    </div>
                </div>
                
                <div class="right_innerbox"> 
                    @php
                        $startdate 	= ucwords(Jenssegers\Date\Date::parse($data->event_start_datetime)->format('l j F Y'));
                        $enddate 	= ucwords(Jenssegers\Date\Date::parse($data->event_end_datetime)->format('l j F Y'));
                        $starttime	= Carbon\Carbon::parse($data->event_start_datetime)->format('H:i');
                        $endtime	= Carbon\Carbon::parse($data->event_end_datetime)->format('H:i');
                    @endphp              
                    <div class="badge category col-sm-4 col-sm-offset-1" style="cursor: default">
                          <span class="">
                            @if(Route::currentRouteName() === 'index')
                                {{ $data->this_event_category }}
                            @else
                                {{App\Event::getCategoryById($data->event_category)}}
                            @endif
                          </span>
                    </div>   
                    <div class="datexp">
                          @if($startdate == $enddate)
                            <div class="date-times bold third-color">
                                     <table cellpadding="0" cellspacing="0" border="0">                                   
                                        <?php
                                            $stdate=explode(" ",$startdate);
                                            $nbstdate=count($stdate);
                                            for($x=0;$x<$nbstdate;$x++){
                                         ?>
                                            <tr <?php if($x==1){ echo'class="secdatexp"'; } ?> ><td style="text-align: center"><?=$stdate[$x] ?></td></tr>
                                         <?php } ?>                                        

                                    </table>   
                            </div>
                          @else
                          
                           
                            <div class="both" style="float: left; width: 43%">
                                <table cellpadding="0" cellspacing="0" border="0">                                   
                                    <?php
                                        $stdate=explode(" ",$startdate);
                                        $nbstdate=count($stdate);
                                        for($x=0;$x<$nbstdate;$x++){
                                     ?>
                                        <tr <?php if($x==1){ echo'class="secdatexp"'; } ?> ><td><?=$stdate[$x] ?></td></tr>
                                     <?php } ?>                                        
                                    
                                </table>                                
                            </div>    
                            <div class="sepa"><span class="separator">-</span></div>
                            <div class="both" style="float: right; width: 43%">
                                
                                 <table cellpadding="0" cellspacing="0" border="0">                                   
                                    <?php
                                        $edate=explode(" ",$enddate);
                                        $nbedate=count($edate);
                                        for($y=0;$y<$nbedate;$y++){
                                     ?>
                                        <tr <?php if($y==1){ echo'class="secdatexp"'; } ?> > <td style="text-align: left"><?=$edate[$y] ?></td></tr>
                                     <?php } ?>                                        
                                    
                                </table>   
                                
                            </div>

                         @endif                        
                    </div>
                    
                </div>  
                
           </div>
            <div style="clear:both;"></div>
        </div>
    </div>

</div>


                            @endif
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection