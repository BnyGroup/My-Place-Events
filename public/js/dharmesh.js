$(function () {
    var $tblrows = $("#tblProducts tbody tr");

    $tblrows.each(function (index) {

        var $tblrow = $(this);

        $tblrow.find('.qty').on('change', function () {

            var qty = $tblrow.find(".qty").val();
            if (qty > $tblrow.find(".qty").data('remain')) {
          $tblrow.find(".qty").val($tblrow.find(".qty").data('remain'))
          swal("Cancelled",'You can enter maximum '+ $tblrow.find(".qty").data('remain') +' QTY',"error");
            }

              var price = $tblrow.find(".price").val();
              if (qty >= $tblrow.find(".qty").data('remain')) {
              	var subTotal = parseInt($tblrow.find(".qty").data('remain'), 10) * parseFloat(price);
              }else{
              	var subTotal = parseInt(qty, 10) * parseFloat(price);
              }

              if (!isNaN(subTotal)) {

                  $tblrow.find('.subtot').val(subTotal.toFixed(2));
                  var grandTotal = 0;

                  $(".subtot").each(function () {
                      	var stval = parseFloat($(this).val());
                    	grandTotal += isNaN(stval) ? 0 : stval;
            			$('.grdtot').val(grandTotal.toFixed(2));
                  });
              }

              var tikcekts = 0;
              $(".qty").each(function () {
                var qtyss = $(this).val();
                tikcekts += isNaN(qtyss) ? 0 : qtyss;
          $('#total_tik').val(tikcekts);
              });
              if(grandTotal > 0 || qty > 0){
                $('#mual-con').removeAttr('disabled','disabled');
              }else{
                $('#mual-con').attr('disabled','disabled');
              }
        });
    });
});


var co = 0;
$('body').on('change','#multi_send',function(event) {
    if($(this).is(':checked')){
        var co = $('.button-email').length
        $('.button-email').each(function(){                                   
            $(this).prop("checked", true);                      
        });
        if(co > 0){
          $('#multi_send_email').show();
        }
    }else{
      $('.button-email').each(function(){                                   
            $(this).prop("checked", false); 
        });
        var co = 0;
        if(co < 1){
          $('#multi_send_email').hide();
        }
    }
});


var $checkboxes = $('.button-email');

$('body').on('change','.button-email',function(event) {
    var countCheckedCheckboxes = $checkboxes.filter(':checked').length;

    if(countCheckedCheckboxes < 1){
        $('#multi_send_email').hide();
    }else{
        $('#multi_send_email').show();
    }

    var chk = $checkboxes.length;
    
    if(chk == countCheckedCheckboxes){
      $('#multi_send').prop('checked',true);
    }else{
      $('#multi_send').prop('checked',false);
    }
});




$('body').on('click','#sub_msg',function(event) {
    var token = $('#token').val();
    var event_description = $('#event_description').val();
    var sub = $('#sub').val();
    var email = [];
    $("input[name='multi_send_email']:checked").each(function(){
      email.push(this.value);
    });

    $.ajax({
      url: '/attendees/contact_multi',
      type: 'POST',
      dataType: 'json',
      data: {_token:token,email:email,subject:sub,event_description:event_description},
      beforeSend:function(){
        $('#mail-multi').modal('hide');
        $('.img-loeader').show();
      },
      success:function(data){ 
        if(data.status == 0){
          $('.img-loeader').hide();
          $('#error').html(' ')
          $('#error').show();
          $('#mail-multi').modal('show');
          $('#error').append('<li>'+ data.error +'</li>');
        }else{
          $('#mail-multi').modal('hide');
          $('.img-loeader').hide();
          swal("Good job!",data.success, "success")
        }
      }
    })
});


function copyDivToClipboard() {
    var range = document.getSelection().getRangeAt(0);
    range.selectNode(document.getElementById("proceed"));
    window.getSelection().addRange(range);
    document.execCommand("copy")
  $('#proceed').tooltip('show');
}

$('.snippet-btn').click(function(){
  $('#proceed').delay(5000).show(0);
  $('#load-img').show(0).delay(5000).hide(0);
  $('.event-snippet-btn').delay(5000).hide(0);
})


$('#claim-form').validate({
    rules: {
        firstname : 'required',
        lastname : 'required',
        email: {
          required: true,
          email: true
        },
        phone_number: {
          required: true,
          digits: true
        },
        about_us: {
          required: true,
          minlength:5
        }
    },
});

$("body").on("click",".claim-this-profile",function(e){
    var frm = $('#claim-form');

    $.ajax({
      url: '/orgs/claim',
      type: 'POST',
      dataType: 'json',
      data:frm.serialize(),
      beforeSend:function(){
        $('.img-loeader').show();
        $('#myModal-contact').modal('hide');
      },
      success:function(data){
        $('.img-loeader').hide();
        swal('Submitted',data.success, "success");
        $('#claim-form')[0].reset();
      }
    });
    
});