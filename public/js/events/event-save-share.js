$( document ).ready(function() {
	$('#share-click').click(function(){
		$('html,body').animate({
        	scrollTop: $("#share-with-social").offset().top},
        'slow');
	});

	$('.event-share').click(function(){ 
		var dataurl		= $(this).attr("data-url")
		var dataname	= $(this).attr("data-name")
		var dataloca	= $(this).attr("data-loca")
		var thisElement	= $(this)

		$("#shareEvent #share-body a.facebook").attr('href', 'https://www.facebook.com/sharer/sharer.php?u='+dataurl)
		$("#shareEvent #share-body a.twitter").attr('href', 'https://twitter.com/intent/tweet?text='+dataname+'&amp;url='+dataurl)
		$("#shareEvent #share-body a.linkedin").attr('href', 'http://www.linkedin.com/shareArticle?mini=true&amp;url='+dataurl+'&amp;title='+dataname+'&amp;summary=Event At - '+dataloca)
		$("#shareEvent #share-body a.google").attr('href', 'https://plus.google.com/share?url='+dataurl)
		$('#shareEvent').modal('toggle')
	});

	$('#shareEvent #share-body a').click(function(){
		$("#shareEvent").modal('hide')
	});

    $('.nouserconn').click(function(){		
        $('#signupAlertLike').modal('toggle')
    });

	$('.save-event').click(function(){		 
		var userid	= $(this).attr("data-user")
		var eventid	= $(this).attr("data-event")
		var thisElement = $(this)

		if(userid == '') {
			$('#signupAlert').modal('toggle')
		} else {
			$.ajax({
				type: "GET",
			    url:"../e/bookmark",
			    data:"eid="+eventid+'&uid='+userid,
				dataType: 'json',
				success: function(data){
					if(data.status == 1){						
						thisElement.html('<i class="fa fa-heart"></i>');
						$("#userlike-"+eventid).addClass("addedbm");
					}else{
						thisElement.html('<i class="fa fa-heart"></i>')
						$("#userlike-"+eventid).removeClass("addedbm");
					}
					swal(data.title, data.message, "success")
		        },
			    error: function(jqXhr, textStatus, errorThrown){
		            console.log( errorThrown );
		    	}
			});
		}
	});

	$('.save-event-2').click(function(){		 
		var userid	= $(this).attr("data-user")
		var eventid	= $(this).attr("data-event")
		var thisElement = $(this)

		if(userid == '') {
			$('#signupAlert').modal('toggle')
		} else {
			$.ajax({
				type: "GET",
			    url:"../e/bookmark",
			    data:"eid="+eventid+'&uid='+userid,
				dataType: 'json',
				success: function(data){
					if(data.status == 1){						
						thisElement.html('<i class="fa fa-heart"></i> <span>Supprimer de mes Favoris</span>');
						$("#userlike-"+eventid).addClass("addedbm");
					}else{
						thisElement.html('<i class="fa fa-heart"></i> <span>Ajouter à mes Favoris</span>')
						$("#userlike-"+eventid).removeClass("addedbm");
					}
					swal(data.title, data.message, "success")
		        },
			    error: function(jqXhr, textStatus, errorThrown){
		            console.log( errorThrown );
		    	}
			});
		}
	});	
});