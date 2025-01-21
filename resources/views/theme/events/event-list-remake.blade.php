@extends($theme)
@inject(eventsData,'App\Event')
@inject(eventCat,'App\EventCategory')
@section('meta_title',setMetaData()->e_list_title)
@section('meta_description',setMetaData()->e_list_desc)
@section('meta_keywords',setMetaData()->e_list_keyword)


@section('content')
@inject(countries,'App\PaysList') 

    @php
        $currentPageURL = URL()->current();
        $pageArray 		= explode('/', $currentPageURL);
    @endphp
    
 <!-- Tabs -->
<?php
$def__=""; $comp__=""; $expo__=""; $toursime__=""; $comedies__=""; $conf__=""; $formation__="";
$concert__=""; $soiree__="";

if(isset($_GET['cat'])){
	 if(intval($_GET['cat'])==3){ $comp__="active"; }
	 if(intval($_GET['cat'])==4){ $concert__="active"; }
	 if(intval($_GET['cat'])==7){ $expo__="active"; }
	 if(intval($_GET['cat'])==13){ $toursime__="active"; }
	 if(intval($_GET['cat'])==11){ $soiree__="active"; }
	 if(intval($_GET['cat'])==15){ $conf__="active"; }
	 if(intval($_GET['cat'])==2){ $formation__="active"; }
	 if(intval($_GET['cat'])==14){ $comedies__="active"; }
	 $_cat=intval($_GET['cat']);
	
}else{
	$def__="active";
    $_cat=0;
}

?> 
<section id="tabs">
 		<div class="row topmenuRow">
  				<nav class="container">
					<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
						<div class="nav-item nav-link  {{$def__}} hometaab" data-cat="all" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><a class="" >Tous les events</a></div>
						<div class="nav-item nav-link {{$concert__}}" data-cat="concert" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><a class="concert">Concerts</a></div>
                        <div class="nav-item nav-link {{$expo__}}" data-cat="exposition" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><a class="expo">Expositions</a></div>
                        <div class="nav-item nav-link {{$soiree__}}" data-cat="soiree" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><a class="soiree">Soirées</a></div>
						<div class="nav-item nav-link {{$toursime__}}" data-cat="tourisme"id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false"><a class="tourisme">Tourisme</a></div>
						<div class="nav-item nav-link {{$formation__}}" data-cat="formation" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-about" aria-selected="false"><a class="formation">Formations</a></div>
                        <div class="nav-item nav-link {{$conf__}}" data-cat="conference" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-about" aria-selected="false"><a class="conference">Conférences</a></div>
                        <div class="nav-item nav-link {{$comp__}}" data-cat="competition" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-about" aria-selected="false"><a class="competition">Compétitions</a></div>
                        <div class="nav-item nav-link {{$comedies__}}" data-cat="comedies" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-about" aria-selected="false"><a class="comedie">Comédies</a></div>
					</div>
				</nav>
        </div>   
	
        <div class="row">    
            <div class="container">
				
				<div style="" class="print-sorting">

					
					<div style="margin-left: 10px">
						<input type="text" name="daterange" id="filterbydate" class="filterby">
					</div>						
					<div style="margin-left: 10px">
						<div class="relative" id="paysBox" data-state="">
							
							<button class="flex items-center justify-center px-4 py-2 text-sm border rounded-full focus:outline-none select-none border-neutral-300 dark:border-neutral-700 text-neutral-700 dark:text-neutral-300 hover:border-neutral-400 dark:hover:border-neutral-500 filterby" type="button" aria-expanded="false" data-headlessui-state="" id="filterbypays">
								<svg class="w-4 h-4" viewBox="0 0 20 20" fill="none"><path d="M11.5166 5.70834L14.0499 8.24168" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path><path d="M11.5166 14.2917V5.70834" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8.48327 14.2917L5.94995 11.7583" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8.48315 5.70834V14.2917" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path><path d="M10.0001 18.3333C14.6025 18.3333 18.3334 14.6024 18.3334 10C18.3334 5.39763 14.6025 1.66667 10.0001 1.66667C5.39771 1.66667 1.66675 5.39763 1.66675 10C1.66675 14.6024 5.39771 18.3333 10.0001 18.3333Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg><span class="ml-2">Filtrer par pays</span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="w-4 h-4 ml-3"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
							</button>
							
<div class="absolute z-40 w-screen max-w-sm px-4 mt-3 right-0 sm:px-0 lg:max-w-sm translate-y-0" id="filter-pays-panel" tabindex="-1" data-state="close">
	<div class="overflow-hidden rounded-2xl shadow-xl bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700">
			<div class="relative flex flex-col px5 py-6 space-y-5">
			@foreach ($countries->getCountryList() as $paysLists)
				<div class="flex items-center text-sm sm:text-base "><a href="javascript:filterData('pays','<?php echo addslashes($paysLists->nom_pays); ?>')" class="pl-2.5 sm:pl-3 block text-slate-900 dark:text-slate-100 select-none">{{ $paysLists->nom_pays }}</a></div>	
			@endforeach				
		</div>		 
	</div>
</div>							
							
							 
							
							</div>
					</div>					
					<div>
						<div class="relative" id="theBox" data-state="">
							<button class="flex items-center justify-center px-4 py-2 text-sm border rounded-full focus:outline-none select-none border-neutral-300 dark:border-neutral-700 text-neutral-700 dark:text-neutral-300 hover:border-neutral-400 dark:hover:border-neutral-500" type="button" aria-expanded="false" data-headlessui-state="" id="openFilterBox">
								<svg class="w-4 h-4" viewBox="0 0 20 20" fill="none"><path d="M11.5166 5.70834L14.0499 8.24168" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path><path d="M11.5166 14.2917V5.70834" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8.48327 14.2917L5.94995 11.7583" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8.48315 5.70834V14.2917" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path><path d="M10.0001 18.3333C14.6025 18.3333 18.3334 14.6024 18.3334 10C18.3334 5.39763 14.6025 1.66667 10.0001 1.66667C5.39771 1.66667 1.66675 5.39763 1.66675 10C1.66675 14.6024 5.39771 18.3333 10.0001 18.3333Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg><span class="ml-2">@lang('words.events_tab.filter_by')</span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="w-4 h-4 ml-3"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
							</button>
						
<div class="absolute z-40 w-screen max-w-sm px-4 mt-3 right-0 sm:px-0 lg:max-w-sm translate-y-0" id="filter-panel" tabindex="-1" data-state="close">
	<div class="overflow-hidden rounded-2xl shadow-xl bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700">
			<div class="relative flex flex-col px5 py-6 space-y-5">
			<div class="flex items-center text-sm sm:text-base "><a href="javascript:filterEventBy('pays')" class="pl-2.5 sm:pl-3 block text-slate-900 dark:text-slate-100 select-none">Pays</a></div>
			<div class="flex items-center text-sm sm:text-base "><a href="javascript:filterData('orderby','desc')" class="pl-2.5 sm:pl-3 block text-slate-900 dark:text-slate-100 select-none">Plus récents</a></div>
			<div class="flex items-center text-sm sm:text-base "><a href="javascript:filterData('orderby','asc')" class="pl-2.5 sm:pl-3 block text-slate-900 dark:text-slate-100 select-none">Plus anciens</a></div>
			<?php /*?><div class="flex items-center text-sm sm:text-base "><a href="javascript:filterEventBy('populaire')" class="pl-2.5 sm:pl-3 block text-slate-900 dark:text-slate-100 select-none">Plus populaires</a></div><?php */?>
			<div class="flex items-center text-sm sm:text-base "><a href="javascript:filterEventBy('date')" class="pl-2.5 sm:pl-3 block text-slate-900 dark:text-slate-100 select-none">Date</a></div>

		</div>		 
	</div>
</div>
						
						</div>
						
<style>
#filter-panel, #filter-pays-panel{
	display: none;
}
.px5{
	padding-left: 2rem!important;
}
.opacity-100 {
    opacity: 1;
}
.translate-y-0 {
    --tw-translate-y: 0px;
}
.w-screen {
    width: 300px;
}
.mt-3 {
    margin-top: 0.75rem !important;
}
.z-40 {
    z-index: 9999;
}
.right-0 {
    right: -30px;
}
.absolute {
    position: absolute;
}	
.text-sm {
    font-size: .875rem;
    line-height: 1.25rem;
}
 .bg-white {
    background-color: #FFFFFF;
}
.px-4 {
    padding-left: 1rem;
    padding-right: 1rem;
}
.border-neutral-300 {
    border-color: rgba(209,213,219,1);
}
.border {
    border-width: 1px;
}
.rounded-full {
    border-radius: 9999px;
}
.rounded-2xl {
    border-radius: 1rem;
}	
.justify-center {
    justify-content: center;
}
.items-center {
    align-items: center;
}
.select-none {
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
	background-color: #FFFFFF;
	width: 100%;
	margin-bottom: 3px;
	padding-bottom: 5px;
}
.flex {
    display: flex;
}		
.w-4 {
    width: 1rem;
}
.h-4 {
    height: 1rem;
}
svg {
    display: block;
    vertical-align: middle;
}
.ml-2 {
    margin-left: 0.5rem;
}
.ml-3 {
    margin-left: 0.75rem;
}	
.shadow-xl {
    --tw-shadow: 0 20px 25px -5px rgba(0 0 0,.1),0 8px 10px -6px rgba(0 0 0,.1);
    --tw-shadow-colored: 0 20px 25px -5px var(--tw-shadow-color),0 8px 10px -6px var(--tw-shadow-color);
}
.shadow-sm, .shadow-xl {
    box-shadow: 0 0 #0000;
}	
 .py-6 {
    padding-top: 1.5rem;
    padding-bottom: 1.5rem;
}

.px-5 {
    padding-left: 1.25rem;
    padding-right: 1.25rem;
}
.flex-col {
    flex-direction: column;
}
.flex {
    display: flex;
}
.relative {
    position: relative;
}
.items-center {
    align-items: center;
}	
	#filter-pays-panel .overflow-hidden{
		max-height: 300px;
   		overflow-y: auto;
	} 
</style>						
						
						<?php /*?><select id="filterby" class="filterby">
							<option value="0">-- Filtrer par --</option>
							<option value="pays">Pays</option>
							<option value="desc">Plus récents</option>
							<option value="asc">Plus anciens</option>
							<option value="date">Date</option>
						</select><?php */?>
					</div>


				</div>

                <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" style="margin-top: 10px; background: none">
                       <div class="row alleventcontainer">
                      <?php if(!isset($_GET['cat'])){      
                            if(!empty($events)){
                                foreach($events as $data){ ?>
                                    @include('theme.events.event-topcat-list')
                               <?php }
                            }
                            /*@if(!isset($pageArray[4]))
                            @foreach($eventsData->hits_all_events() as $key => $data)
                                @if($data->event_status == 1)
                                    @include('theme.events.event-topcat-list')
                                @endif
                            @endforeach
                            @endif<?php */
                            } ?>
                        </div>
                        
                        <div class="loaderBox">
                            <img src="{{ asset('/img/spinner.gif')}}" >
                        </div>
                        
                    </div> 
                </div>
                

            </div>		 
	    </div>
</section>
     
        
		
        
         <div class="container" style="margin-bottom: 70px;">
             <center><button type="button" onClick="fetchData()" class="btn btn-primary allEventButton third-bg" style="float: none">Plus d'événements</button></center>
             <input type="hidden" id="start" value="0">
             <input type="hidden" id="rowperpage" value="1">
             <input type="hidden" id="totalrecords" value="<?php echo $events->total() ?>">
             <input type="hidden" id="filterData" value="">
         </div>
        
        
 <style>
	.loaderBox{
		display: none;  
		text-align: center;
	}
	 .loaderBox img{
		 width: 120px;
	 }
	 #filterbypays, #filterbydate{
		 display: none;
	 }
	.daterangepicker_input .form-control {
	border-radius: 5px !important;
	height: 33px !important;
	}
 </style>


 
@endsection

@section('pageScript')
 
 <!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

<script type="text/javascript">		


			$(function() {
				$('#filterbydate').daterangepicker({ 
					timePicker: true,
					startDate: moment().startOf('hour'),
					endDate: moment().startOf('hour').add(32, 'hour'),
					locale: {
						format: 'YYYY-MM-DD',
						separator: " - ",
						applyLabel: "Appliquer",
						cancelLabel: "Annuler",
						fromLabel: "De",
						toLabel: "A",
						customRangeLabel: "Custom",
						
						closeText: "Fermer",
						prevText: "Précédent",
						nextText: "Suivant",
						currentText: "Aujourd'hui",
						monthNames: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
						"Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
						monthNamesShort: ["janv.", "févr.", "mars", "avr.", "mai", "juin",
						"juil.", "août", "sept.", "oct.", "nov.", "déc."],
						dayNames: ["dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi"],
						dayNamesShort: ["dim.", "lun.", "mar.", "mer.", "jeu.", "ven.", "sam."],
						dayNamesMin: ["Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa"],
						weekHeader: "Sem.",
				}
				});
				$('#filterbydate').on('apply.daterangepicker', function(ev, picker) {
					filterData('daterange',picker.startDate.format('YYYY-MM-DD')+'x'+picker.endDate.format('YYYY-MM-DD') )
					  console.log(picker.startDate.format('YYYY-MM-DD'));
					  console.log(picker.endDate.format('YYYY-MM-DD'));
				});
			});
 
		 
			var wi=$(window).width();
 
		   /* If we are above mobile breakpoint unslick the slider */
		   if (wi <= "600") 
		   {    
				$('#nav-tab').slick({
				  slidesToShow: 2,
				  slidesToScroll: 1,
				  autoplay: false,
				  lazyLoad: 'ondemand',
				  autoplaySpeed: 3500,
				  pauseOnHover: true,
				  prevArrow: "<button type='button' class='slick-prev'></button>",
				  nextArrow: "<button type='button' class='slick-next slick-arrow'></button>",
				});   

		   }
		
          $(document).ready(function () {
              
<?php if(isset($_GET['cat'])){ ?>
    fetchData_2();
<?php    
} ?>
              
             $('#home-search-form input[type="submit"]').on('click', function() {
				 var i = 0;
				 var selectEnfants = $('#home-search-form select[name="event_country"]').children();
				 var selectNombreEnfant = selectEnfants.length;
             });

            $('#forDateContent').hide();
            $('#forDate').on('mousedown', function () {
                $('#forDateContent').toggle();
            });

            $('#forDateContent a').on('click', function () {
                var inputValue = $(this).text();
                $('#forDate').val(inputValue);
                $('#forDate').val().replace(' ', '');

                if ($('#forDate').val() == $('#forDateContent li:last').text()) {
                    $('#forDate').val('cdate');
                }
            });

            $('#custom_date').on('click', function () {
                $("#forDateContent li:last").toggle();
            });

            var div_cliquable = $('#forDate');
            $(document.body).click(function (e) {
                // Si ce n'est pas #ma_div ni un de ses enfants
                if(!$(e.target).is(div_cliquable) && !$.contains(div_cliquable[0], e.target) && !$(e.target).is($('#forDateContent')) && !$.contains($('#forDateContent')[0], e.target)) {
					// masque #ma_div en fondu
                    $('#forDateContent').hide(); 
                }
            });

            /*******
			var emptyDateF = $('#list-search-form input #forDate').val();
            var emptyDateD = $('#list-search-form input #forDate').val();
            $('#list-search-form input[type="submit"]').on('click', function () {
                if ((emptyDateF).empty() && !emptyDateD.empty()) {
                    $('#list-search-form input #forDate').val(emptyDateD);
                }
            });
			*******/            
             
            $("#nav-tab .nav-item").on("click", function(){				
                $('#start').val('0');
                var start = $('#start').val();
                var cat=$(this).data("cat");

                $('.allEventButton').css("display", "block");
                $.ajax({
                       url:"{{ route('eventsbycats')}}",
                       data: {page:start, cat:cat},
                       method: 'GET',   
                       beforeSend: function( xhr ) {
                            $('.alleventcontainer').html('<div align="center" style="display:block; width: 100%;"><img src="{{ asset('/img/spinner.gif')}}" ></div>');
                        },
                       success: function(response){ 
                            // Add
                            //$('.loaderBox').css("display", "none");
                            if ($.trim(response) != 0){
                                $(".alleventcontainer").html(response).show().fadeIn("slow");   
                            }else{
                                $(".alleventcontainer").html("<div align='center' style='display:block; margin:80px 0; width:100%'>Aucun évènement à afficher dans cette catégorie</div>").show().fadeIn("slow"); 
                                $('.allEventButton').css("display", "none");
                            }

                       }
                  });           
            });
 
        });
		
		 $('.nav-link.slick-slide').on('click', function () {
			 	var cat=$(this).data("cat");
				$("#nav-tab .nav-item").each(function( index ) {
					$(this).removeClass("slick-active active show");
				});			 
		});

       // Fetch records
       function fetchData(){
             var start = Number($('#start').val());
             var allcount = Number($('#totalrecords').val());
             var rowperpage = Number($('#rowperpage').val());
             start = start + rowperpage;
           
            var cat=$("#nav-tab .nav-item.active").data("cat");
            $('#nomore').html("");
		   
		   <?php if(isset($_GET['cat'])){ ?> cat="<?php echo $_GET['cat']; ?>"; <?php } ?>
		   
	    	var filterData=$("#filterData").val();
            
             if(start <= allcount && cat!=''){ 
                  $('#start').val(start);

                  $.ajax({
                       url:"{{ route('eventsbycats')}}",
                       data: {page:start, cat:cat, filterData:filterData},
                       method: 'GET',   
                       beforeSend: function( xhr ) {
                            $('.loaderBox').css("display", "block");
                        },
                       success: function(response){  
                            // Add
                            $('.loaderBox').css("display", "none");
                            
                            
                            if($.trim(response) == 0){ 
                                 $(".allEventButton").before("<div align=center id='nomore'>Plus aucun article à afficher</div>").show().fadeIn("slow"); 
                                 $('.allEventButton').css("display", "none");
                            }else{
                                $(".alleventcontainer").append(response).show().fadeIn("slow");                                
                            }
                           
                       }
                  });
             }
       }
       
        // Fetch records
       function fetchData_2(){
             var start = 0;
             var allcount = Number($('#totalrecords').val());
             var rowperpage = Number($('#rowperpage').val());
            // start = start + rowperpage;
           
            var cat=$("#nav-tab .nav-item.active").data("cat");
            $('#nomore').html("");
			cat="<?php if(isset($_GET['cat'])){ echo $_GET['cat']; } ?>";
		   
	     	var filterData=$("#filterData").val();
           
             if(start <= allcount && cat!=''){
                  $('#start').val(start);
 
                  $.ajax({
                       url:"{{ route('eventsbycats')}}",
                       data: {page:start, cat:cat, filterData:filterData},
                       method: 'GET',   
                       beforeSend: function( xhr ) {
                            $('.loaderBox').css("display", "block");
                        },
                       success: function(response){
                            // Add
                            $('.loaderBox').css("display", "none");
                            
                            if($.trim(response) == 0){ 
                                 $(".allEventButton").before("<div align=center id='nomore'>Aucun article à afficher</div>").show().fadeIn("slow"); 
                                 $('.allEventButton').css("display", "none");
								start = start + rowperpage;
                            }else{
                                $(".alleventcontainer").html(response).show().fadeIn("slow");                                
                            }
                           
                       }
                  });
             }
       }
	
	   //filter
	   function filterData(c, v){
            var pays = ""; 
            var dater = ""; var orderby="";
		   
		    var filterData="";
           
		    if(c=='pays'){ pays=v; }
		    if(c=='daterange'){ dater=v; }
		    if(c=='orderby'){ orderby=v; 
							 
					$('#filter-panel').fadeOut("slow");
					$('#filter-panel').data('state','close');

					$('#filter-pays-panel').fadeOut("slow");
					$('#filter-pays-panel').data('state','close');								
					$("#filterbydate").fadeOut("slow");
					$("#filterbypays").fadeOut("slow");
			}
		   
		    if(pays==null) pays="";
		    if(dater==null) dater="";
		    if(orderby==null) orderby="";
		   
            var currentCat=$("#nav-tab .nav-item.active").data("cat");
            $('#nomore').html("");
		   
		    	filterData='cat:'+currentCat+', pays:'+pays+', date:'+dater+', orderby:'+orderby;
		   		$("#filterData").val(filterData);
		   
            $.ajax({
				   url:"{{ route('eventsbycatsfilter')}}",
				   data: {cat:currentCat, pays:pays, date:dater, orderby: orderby},
				   method: 'GET',   
				   beforeSend: function( xhr ) {
						$('.loaderBox').css("display", "block");
					    $('.alleventcontainer').html("");
					},
				   success: function(response){
						// Add
						$('.loaderBox').css("display", "none");
 
						if($.trim(response) == 0){ 
							 $(".alleventcontainer").append("<div class='col-lg-12' style='padding: 0 0 16px 25px;' align=center id='nomore'>Aucun événement dans cette catégorie</div>").show().fadeIn("slow");   
						   	 //$(".allEventButton").before("<div style='display:block' align=center id='nomore'>Plus aucun article à afficher</div>").show().fadeIn("slow"); 
							 $('.allEventButton').css("display", "none");
						}else{
							$(".alleventcontainer").append(response).show().fadeIn("slow");  
							$('.allEventButton').css("display", "block");
						}

				   }
			  });
		   
	$('#filter-panel').fadeOut("slow");
	$('#filter-panel').data('state','close');

	$('#filter-pays-panel').fadeOut("slow");
	$('#filter-pays-panel').data('state','close');			   
              
        }	
    </script>
    <script type="text/javascript" src="{{ asset('/js/events/event_search.js')}}"></script>
    <script type="text/javascript" src="{{ asset('/js/events/event-save-share.js')}}"></script>
<script>
$('#openFilterBox').on("click", function(){
	if($('#filter-panel').data('state')==='close'){
		$('#filter-panel').fadeIn("slow");
		$('#filter-panel').data('state','open');
	}else{
		$('#filter-panel').fadeOut("slow");
		$('#filter-panel').data('state','close');
	}
});
	

$('#filterbypays').on("click", function(){
	if($('#filter-pays-panel').data('state')==='close'){
		$('#filter-pays-panel').fadeIn("slow");
		$('#filter-pays-panel').data('state','open');
	}else{
		$('#filter-pays-panel').fadeOut("slow");
		$('#filter-pays-panel').data('state','close');
	}
});	
	
$("#theBox, #paysBox").on("blur", function(){
	$('#filter-panel').fadeOut("slow");
	$('#filter-panel').data('state','close');
	
	$('#filter-pays-panel').fadeOut("slow");
	$('#filter-pays-panel').data('state','close');
	 
	
});
function filterEventBy(typex){
				 
	if(typex=="pays"){
		$("#filterbypays").css("display","flex");
		$('#filterbydate').fadeOut("slow");
	}else if(typex=="date"){  
		$("#filterbydate").css("display","flex");
		$("#filterbypays").css("display","none");
	}
	
	$('#filter-panel').fadeOut("slow");
	$('#filter-panel').data('state','close');

	$('#filter-pays-panel').fadeOut("slow");
	$('#filter-pays-panel').data('state','close');	
}	
 	
</script>

 



    <script type="text/javascript" src="{{ asset('/js/events/event_search.js')}}"></script>
    <script type="text/javascript" src="{{ asset('/js/events/event-save-share.js')}}"></script>
    <!-- USER NOT LOGIN MODEL -->
    <div class="modal fade bd-example-modal-md" tabindex="-1" id="signupAlert" role="dialog"
         aria-labelledby="sighupalert" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content signup-alert">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('words.save_eve_title')</h5>

                    <p class="modal-text">@lang('words.save_eve_content')</p>

                    <div class="model-btn">
                        <a href="javascript:openRegisterBox()"
                           class="btn pro-choose-file text-uppercase">@lang('words.save_eve_signin_btn')</a>

                        <p class="modal-text-small">
                            @lang('words.save_eve_login_txt') <a
                                    href="javascript:openConnexinBox()">@lang('words.save_eve_login_btn')</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- USER NOT LOGIN MODEL -->
    <!-- SHARE EVENT MODEL -->
    <div class="modal fade bd-example-modal-md" tabindex="-1" id="shareEvent" role="dialog" aria-labelledby="shareEvent"
         aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content signup-alert">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('words.share_title_popup')</h5>

                    <div class="share" id="share-body">
                        <a href="" class="social-button social-logo-detail facebook">
                            <i class="fa fa-facebook"></i>
                        </a>
                        <a href="" class="social-button social-logo-detail twitter">
                            <i class="fa fa-twitter"></i>
                        </a>
                        <a href="" class="social-button social-logo-detail linkedin">
                            <i class="fa fa-linkedin"></i>
                        </a>
                        <a href="" class="social-button social-logo-detail google">
                            <i class="fa fa-google"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- SHARE EVENT MODEL -->
    
<!-- USER NOT LOGIN MODEL -->
  <div class="modal fade bd-example-modal-md" tabindex="-1" id="signupAlertLike" role="dialog" aria-labelledby="sighupalert" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content signup-alert">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="modal-body">
          <h5 class="modal-title" id="exampleModalLabel">Enregistrer cet &eacute;v&egrave;nement</h5>
          <p class="modal-text">Connectez-vous ou inscrivez-vous pour liker cet &eacute;v&egrave;nement.</p>
          <div class="model-btn">
            <a href="javascript:openRegisterBox()" class="btn pro-choose-file text-uppercase">@lang('words.save_eve_signin_btn')</a>
            <p class="modal-text-small">
              @lang('words.save_eve_login_txt') <a href="javascript:openConnexinBox()" class="">@lang('words.save_eve_login_btn')</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- USER NOT LOGIN MODEL -->
@endsection
