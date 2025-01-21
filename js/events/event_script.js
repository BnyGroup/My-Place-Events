  $( document ).ready(function() {
    // function eLang(){
    //   var rtndt =  'gellkj d;laskfjds;lk'
    //   return rtndt;
    // }
    //   var dadf = eLang('naitik')
    //   alert(dadf)


  });
/* ========================================= */
/* AAD ORGANIZATION SCRIPT */
/* ========================================= */
var optionsFeed = { 
    complete: function(response) 
    {
        console.log(response);
        if($.isEmptyObject(response.responseJSON.errors)){
          $('#orgModal').modal('hide')
          var option = '<option value="'+ response.responseJSON.org_id +'" selected="selected">' + response.responseJSON.org_name + '</option>';
          $('#eventorg').append(option);
          $('#org_name').val('');
          $('#org_error').html('')
        }else{
          console.log(response.responseJSON.errors)
          $('#org_error').html(response.responseJSON.errors.organizer_name)            
        }
    }
};
$("body").on("click",".orgsubmit",function(e){
    $(this).parents("form").ajaxForm(optionsFeed);
});
/* ========================================= */
/* ========================================= */
/* AAD AND REMOVE EVENT TICKETS SCRIPT */
/* ========================================= */
$(".add_tickets").click(function () {
  var nooftickets = $("#tickets > div.tickets-box").length

  if(nooftickets == 0){
    var i = 0;    
  }else{
    var i = nooftickets
  }

  var eventType = $(this).attr("data-type")
  if (eventType == 'paid') {
    var typehid = '<input type="hidden" name="ticket_type[]" value="1" readonly="" />'
  } else if(eventType == 'donation') {
    var typehid = '<input type="hidden" name="ticket_type[]" value="2" readonly="" />'
  } else {
    var typehid = '<input type="hidden" name="ticket_type[]" value="0" readonly="" />'    
  }

  if (nooftickets < 10) {
		i++
		$("#tickets").append (
		  '<div class="row tickets-box ticket-' + i + '">' 
			+ typehid + $('.addeventtickets').html() +
		  '</div>'    
		)
		if (eventType == 'free') {
		  $('.ticket-'+i+' .ticketpricttxt').html( $('.tpf').html() )
		  $('.ticket-'+i+' .servicesfee').html('<input type="hidden" name="ticket_services_fee[]" value="0" readonly="" />')
		}else if(eventType == 'paid') {
		  $('.ticket-'+i+' .ticketpricttxt').html( $('.tpp').html() )
		}else if(eventType == 'donation'){
		  $('.ticket-'+i+' .ticketpricttxt').html( $('.tpd').html() )
		  $('.ticket-'+i+' .bfees').remove()
		  $('.ticket-'+i+' .tfees').remove()
		}else{

		}

	} else {
		alert('Limte atteinte!')
	}
 	// event.preventDefault();
});	
/* --------------------------------------------- */

$('body').on("click", ".setting", function (event) {
    $(this).parent().parent().children('.setting').toggle('1000');
});

$('body').on("click", ".remove", function (event) {
    $(this).parent().parent()[0].remove();
});

//$("#imgInp").change(function() {
$('body').on("change", ".ticket-price", function (event) {
  //var fees = '00.00'
  //var buyyer_total = '00.00'
  var fees = '00'
  var buyyer_total = '00'
  var price = $(this).val()
  var commission = $('#commission').val()
  var srvfe = $(this).parent().parent().parent('.tickets-box').children('.setting').children().children('.select_fee').val()

    if(price.length !== 0 && price !== 'FREE' && srvfe == 1){
        //fees  = (parseFloat(price)*(parseFloat(commission)/parseFloat(100)))
        //buyyer_total = parseFloat(price) + parseFloat(fees)
        fees  = (parseInt(price)*(parseInt(commission)/parseInt(100)))
        /*buyyer_total = parseInt(price) + parseInt(fees)*/
        buyyer_total = parseInt(price) - parseInt(fees)
    }
    //$(this).parent().parent().children('#bfees').children('strong').html((buyyer_total).toFixed(2))
    $(this).parent().parent().children('#bfees').children('strong').html((buyyer_total).toFixed(0))
    //$(this).parent().parent('.tickets-box').children('.setting').children().children('#tfees').children('#fee').html((fees).toFixed(2)) 
    $(this).parent().parent().parent('.tickets-box').children('.setting').children().children('#tfees').children('#fee').html((fees).toFixed(2))
    $(this).parent().parent().parent('.tickets-box').children('.setting').children().children('#tfees').children('#buyertotal').html((buyyer_total).toFixed(2))
});

$('body').on("change", ".select_fee", function (event) {
    //var fees = '00.00'
    //var buyyer_total = '00.00'
    var fees = '00'
    var buyyer_total = '00'
    var commission = $('#commission').val()
    //var price = $(this).parent().parent().parent('.tickets-box').children().children('.ticket-price').val();
    var price = $(this).parent().parent().parent('.tickets-box').children().children().children('.ticket-price').val();

    if(price.length !== 0 && price !== 'FREE'){
      /* fees = (parseFloat(price)*(parseFloat(commission)/parseFloat(100)))
         if($(this).val() == 1) {
            buyyer_total = parseFloat(price) + parseFloat(fees)
         } else {
            buyyer_total = parseFloat(price)
         } */
		
        fees = (parseInt(price)*(parseInt(commission)/parseInt(100)))
        if($(this).val() == 1) {
            buyyer_total = parseInt(price) + parseInt(fees)
        } else {
            buyyer_total = parseInt(price)
        }
    }  
    //$(this).parent().parent().parent('.tickets-box').children().children('#bfees').children('strong').html((buyyer_total).toFixed(2));
    //$(this).parent().children('#tfees').children('#fee').html((fees).toFixed(2))
    //$(this).parent().children('#tfees').children('#buyertotal').html((buyyer_total).toFixed(2))
    $(this).parent().parent().parent('.tickets-box').children().children('#bfees').children('strong').html((buyyer_total).toFixed(0));
    $(this).parent().children('#tfees').children('#fee').html((fees).toFixed(0))
    $(this).parent().children('#tfees').children('#buyertotal').html((buyyer_total).toFixed(0))
});