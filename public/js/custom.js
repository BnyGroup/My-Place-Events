/* ========================================= */
/* COMMON USED SCRIPT */
/* ========================================= */
$('.dropdown-toggle').dropdown()
/* ========================================= */
$('.summernote').summernote({
	height: 280,

	toolbar: [
    ['style', ['bold', 'italic']],
    ['para', ['ul', 'ol']],
    ['insert', ['picture']],
   	['view', ['codeview']],
  ]
});
/* ========================================= */
$("#imgInp").change(function() {
	if (this.files && this.files[0]) {		
   		var reader = new FileReader();
	    reader.onload = function(e) {
	      $('#ingOup').attr('src', e.target.result);
	    }
		reader.readAsDataURL(this.files[0]);
  	}
});

$("#imgInp2").change(function() {
	if (this.files && this.files[0]) {		
   		var reader = new FileReader();
	    reader.onload = function(e) {
	      $('#ingOup2').attr('src', e.target.result);
	    }
		reader.readAsDataURL(this.files[0]);
  	}
});

$("#imgCover").change(function() {  
	if (this.files && this.files[0]) {		 
   		var reader = new FileReader();
	    reader.onload = function(e) {  
	      $('.cover-img.coverme').css('background-image','url('+e.target.result+')');
	    }
		reader.readAsDataURL(this.files[0]);
  	}
});

$("#imgCreate").change(function() {  
	if (this.files && this.files[0]) {		 
   		var reader = new FileReader();
	    reader.onload = function(e) {   
	      $('#ingOup').attr('style','background-image: url('+e.target.result+')');
	    }
		reader.readAsDataURL(this.files[0]);
  	}
});

$('body').on('click','.tabs',function(e){
    var data = $(this).data('url');
    window.location = data
});
// Header scrolling
/*var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
var currentScrollPos = window.pageYOffset;

 if (prevScrollpos > currentScrollPos) {
    document.getElementById("header-scroll").style.top = "0";
    document.getElementById("resposive-scroll").style.top = "0";
    // document.getElementById("custome-stickey").style.top = "6.5%";
  } else {
    // document.getElementById("custome-stickey").style.top = "0";
    document.getElementById("header-scroll").style.top = "-70px";
    document.getElementById("resposive-scroll").style.top = "-70px";
  }
  prevScrollpos = currentScrollPos;
}*/
// Header scrolling


// Header Search start
$('#tags').focus(function() {
    $('.drop-search').show()
});

$("section, .k-close").click(function() {

    $('.drop-search').hide()
})
$('.k-close').click(function(){

    var data = $('#header-location').val();
    $.ajax({
      url: '/location/search/'+data,
      type: 'GET',
      dataType: 'json',
      success:function(datas){
        window.location.href = datas;
      }
    })
})

// Header Search close
$('#clo').click(function(event) {
  $('.drop-search').hide()
}); 
 

// Sticky Header ============
 
		$(window).scroll(function() {    
			var scroll = $(window).scrollTop();  
			
			if (scroll >= 50) {
				$(".mobileheader").addClass("sticky-header");
			}else{
				$(".mobileheader").removeClass("sticky-header");
			}
		});
	 

		jQuery(window).bind("scroll", function() {
			var scroll = jQuery(window).scrollTop();
			if (scroll > 100) { 
				jQuery(".btn.scrollTop").fadeIn(500);
			} else {
				jQuery(".btn.scrollTop").fadeOut(500);
			}
		});

	// Header Height ============
	 
		var headerTop = 0;
		var headerNav = 0;
		
		$('.mobileheader .sticky-header').removeClass('is-fixed');
		$('.mobileheader').removeAttr('style');
		
		if(jQuery('.mobileheader .top-bar').length > 0 &&  screenWidth > 991){
			headerTop = parseInt($('.header .top-bar').outerHeight());
		}

		if(jQuery('.mobileheader').length > 0 ){
			headerNav = parseInt($('.mobileheader .main-bar').height());
			headerNav =	(headerNav == 0)?parseInt($('.mobileheader .main-bar').outerHeight()):headerNav;
		}	
		
		var headerHeight = headerNav + headerTop;
		
		jQuery('.mobileheader').css('height', headerHeight);
	 

        jQuery('.menu-toggler').on('click',function(){
			jQuery('.sidebar').toggleClass('show');
			jQuery('.menu-toggler').toggleClass('show');
			jQuery('.dark-overlay').toggleClass('active');
		});
		jQuery('.dark-overlay').on('click',function(){
			jQuery('.menu-toggler, .sidebar').removeClass('show');
			jQuery(this).removeClass('active');
		});
		jQuery('.nav-color').on('click',function(){
			jQuery('.dark-overlay').removeClass('active');
		});