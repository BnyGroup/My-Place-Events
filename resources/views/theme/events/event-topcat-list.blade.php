<div class="col-lg-4 col-md-6 col-sm-12 hover ">
           
    <div class="box-icon pull-right share-listing">
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
                                    @lang('words.menu_tab_5')
                                @else
                                     {!! number_format($data->event_min_price, 0, "."," ") !!} {!! use_currency()->symbol !!}
                                @endif
                                @if($data->event_min_price != $data->event_max_price)
                                    - {!! number_format($data->event_max_price, 0, "."," ") !!} {!! use_currency()->symbol !!}
                                @endif
                             <!--    /
                                @if($data->event_min_price == 0)
                                    @lang('words.menu_tab_5')
                                @else
                                      {{number_format(($data->event_min_price / 655), 2, "."," ")}} Euros
                                @endif
                                @if($data->event_min_price != $data->event_max_price)
                                    - {{number_format(($data->event_max_price / 655), 2, "."," ")}} Euros
                                @endif -->
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
 
