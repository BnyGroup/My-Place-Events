$(function(){

  var order = $('#orderdata').val();
  var obj = JSON.parse(order)
  var id = $('#data').data('id');
  var urls = $('#data').data('url');
  var client_id = $('#data').data('client-id');
  var mode = $('#data').data('mode');
  var auth = $('#data').data('authorization');
  var token = $('#data').data('token');

  braintree.client.create({
    authorization: auth
  }, function (clientErr, clientInstance) {

    if (clientErr) {
      console.error('Error creating client:', clientErr);
      return;
    }

    braintree.paypalCheckout.create({
      client: clientInstance
    }, function (paypalCheckoutErr, paypalCheckoutInstance) {

      paypal.Button.render({
      env: mode, // sandbox | production
      client: {
        sandbox: client_id,
      },
      commit: true,

        payment: function () {
        return paypalCheckoutInstance.createPayment({
            flow:'checkout',
            intent:'sale',
            amount:parseFloat(obj.amount),
            currency:'USD',
        });
      },

      // onAuthorize() is called when the buyer approves the payment
      onAuthorize: function(data, actions) {
          return actions.payment.execute().then(function() {
              $.ajax({
                url: urls,
                type: 'POST',
                dataType:'json',
                data: {'_token':token,'order_data':order,'order_id':id},
                beforeSend:function(){
                  $('.img-loeader').show();
                },success:function(datas){
                  if (datas.success == 1) {
                    $('.img-loeader').hide();
                    window.location.href = datas.done;
                  }
                }
              });
          });
      },
       onCancel : function(data){
        window.location.href = '/order/cancel/'+id;
      }
    }, '#paypal-button');
    });
  });
});