@php $nom = (!empty($data->pseudo))?$data->pseudo:($data->firstname.' '.$data->lastname) @endphp
<div class="col-lg-4 col-md-6 col-sm-12 hover ">
           
    <div class="box-icon pull-right share-listing">
        <a href="javascript:void(0)" data-toggle="tooltip"
           data-original-title="Partager ce prestataire"
           data-placement="right" class="event-share"
           data-url="{{route('pre.detail',$data->url_slug)}}"
           data-name="{{ $nom }}">
            <i class="fas fa-share"></i>
        </a>
    </div>   
    
    <div class="box-icon pull-right like-listing">
        @if(auth()->guard('frontuser')->check())
            @php $userid = auth()->guard('frontuser')->user()->id  @endphp
        @else
            @php $userid = ''  @endphp
        @endif
        <a href="javascript:void(0)" data-toggle="tooltip"
           data-original-title="Enregistrer ce prestataire"
           data-placement="right" id="save-event" class="save-event" data-user="{{$userid}}"
           data-event="{{ $data->id }}" data-mark="0">
            @if(is_null(getbookmark($data->id, $userid)))
                <i class="far fa-heart"></i>
            @else
                <i class="fas fa-heart"></i>
            @endif
        </a>
        <!-- <i class="fa fa-bookmark-o"><a href="#"></a></i>  profile_pic -->
    </div>
    
    <div class="box" style="position: relative;">

       <a href="{{ route('pre.detail',$data->url_slug) }}"> 
		   <div class="bunique" style="background-image: url('{{ url($data->cover) }}'); "></div></a>

        <div class="box-content card__padding prestBox" onclick="location.href='{{ route('pre.detail',$data->url_slug) }}'">
            <div class="innercardbox">
                 
                <div class="left_pbox">
                        <a href="{{ route('pre.detail',$data->url_slug) }}" class="">
							<img class="pimgprof" src="{{ setThumbnail($data->profile_pic) }}" alt="{{ $nom }}">
						</a>                    
                </div>
                
                <div class="right_pbox"> 
						<h4 class="card-title"><a  href="{{ route('pre.detail',$data->url_slug) }}">{{ $nom }}</a></h4>
                                   
                    <div class="badge category" style="cursor: default">
                          <a href="{{route('prestataire',)}}?cat={{$data->activites}}"><span class="">
                           {{ $data->this_prestataire_category}}
                          </span></a>
                    </div> 
					
					<div class="descBox"><?php echo substr(strip_tags($data->descriptions),0,50).'...'; ?> </div>
                     
					<div class="geoCard card__location-content">
						<i class="fas fa-map-marker-alt third-color"></i>
						<a href="" rel="tag" class="adgeo third-color"> {{ $data->adresse_geo}}</a>
					</div>
                    
                </div>  
                
           </div>
            <div style="clear:both;"></div>
        </div>
    </div>

</div>
 
