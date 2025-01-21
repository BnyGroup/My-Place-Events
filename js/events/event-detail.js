$( document ).ready(function() {
	$('body').on('click','#eventRegister',function(){
		var userid	= $(this).attr("data-user")		
		var guestdata	= $(this).attr("data-guest")
		if(userid == '') {
			if(guestdata == 1){
				registrationEvent()
			}else{
				$('#signupAlert').modal('toggle')			
			}
		} else {
			// $('#registration').modal('toggle')
			// $('.ticket').each(function(e) {
			// 	$(this).val('0')
			// 	$(this).find('option:first').attr('selected','selected');
			// 	$('#total_qty').html('0')
			// 	$('#total_amount').html('00.00')
			// 	$('#total_qty_txt').val('0')
			// 	$('#total_amount_txt').val((0.00).toFixed(2))
			// 	$('#btnBookTicket').attr("disabled", true)
			// })
			registrationEvent()
		}
	});

	function registrationEvent() {
		$('#registration').modal('toggle')
		$('.dnsprice').each(function(e) {
			$(this).val('')
		})
		$('.ticket').each(function(e) {
			$(this).val('0')
			$(this).find('option:first').attr('selected','selected');
			$('#total_qty').html('0')
			$('#total_amount').html('00.00')
			$('#total_qty_txt').val('0')
			$('#total_amount_txt').val((0.00).toFixed(2))
			$('#btnBookTicket').attr("disabled", true)
		})
	}

	$('#guestLogin').on( 'submit', function(e) {
	 	e.preventDefault();
        var email = $(this).find('input[name=guestUserEmail]').val();
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data:$(this).serialize(),
            dataType: 'json',
        }).done(function( data ) {            
            $('#signupAlert').modal('hide')            
            registrationEvent()
        });
	});


	$(".showDesc").click(function (e) {
		var parentElement = $(this).parent().children('.ticket-description').slideToggle("slow");
	});

	$('.ticket').change(function() {  
		var tickets_qty = 0;
		var t_qty		= 0;
		var price		= 0;
		var amount		= 0;
        var discount_amount = 0;
        var total_remise = $('#total_remise_txt').val();
        var total_remise_type = $('#total_remise_type_txt').val();
        


		$('.ticket').each(function(e) {
			price		= parseFloat($(this).attr("data-amount"))
			t_qty 		= parseFloat($(this).val())

			tickets_qty	+= parseFloat($(this).val())
			amount 		+= parseFloat(t_qty * price)
		})

		if(tickets_qty != 0){
			$('#btnBookTicket').removeAttr('disabled');
            
            if(total_remise_type=='percentage'){
                discount_amount = (amount*total_remise)/100;
                amount = amount - discount_amount;
            }else{
                amount = amount - total_remise;                
            }
            
            
		}else{
			$('#btnBookTicket').attr("disabled", true)
		}
    
        
		$('#total_qty').html(tickets_qty)
		$('#total_amount').html((amount).toFixed(2))
		$('#total_qty_txt').val(tickets_qty)
		$('#total_amount_txt').val((amount).toFixed(2))
	});

	$('.dnsprice').change(function() {
		var tickets_qty = 0;
		var t_qty		= 0;
		var price		= 0;
		var amount		= 0;

		price	= parseFloat($(this).val())

		if($(this).val().length <= 0 || price <= 0){
			$(this).val('')
			$(this).parent('.dntmain').children('.ticket').val('0')	
		}else{			
			$(this).parent('.dntmain').children('.ticket').val('1')
			var damt = $(this).parent('.dntmain').children('.ticket').attr('data-amount', price)
		}

		$('.ticket').each(function(e) {	
			price		= parseFloat($(this).attr("data-amount"))
			t_qty 		= parseFloat($(this).val())

			tickets_qty	+= parseFloat($(this).val())
			amount 		+= parseFloat(t_qty * price)
		})

		if(tickets_qty != 0){
			$('#btnBookTicket').removeAttr('disabled')
		}else{
			$('#btnBookTicket').attr("disabled", true)
		}
		$('#total_qty').html(tickets_qty)
		$('#total_amount').html((amount).toFixed(2))
		$('#total_qty_txt').val(tickets_qty)
		$('#total_amount_txt').val((amount).toFixed(2))

	});

});


// alert(damt.attr("data-amount"))
// alert(price + " = " + t_qty + " = " + tickets_qty + " = " + amount)

// if (/^\d+$/.test(price)) {

// } else {

// }

//onkeypress="return isNumberKey(event)"
