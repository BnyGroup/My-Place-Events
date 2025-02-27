$('.summernote').summernote({
	height: 500,


	// toolbar
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'italic', 'underline','clear']],
        ['fontname', ['fontname']],
        ['fontsize', ['fontsize']], 
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video', 'hr']],
        ['view', ['fullscreen', 'codeview']],
        ['help', ['help']]
      ],

      // style tag
      styleTags: ['p', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'],

      // default fontName
      defaultFontName: 'Arial',

      // fontName
      fontNames: [
        'Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
        'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande',
        'Lucida Sans', 'Tahoma', 'Times', 'Times New Roman', 'Verdana'
      ],

      // pallete colors(n x n)
      colors: [
        ['#000000', '#424242', '#636363', '#9C9C94', '#CEC6CE', '#EFEFEF', '#F7F7F7', '#FFFFFF'],
        ['#FF0000', '#FF9C00', '#FFFF00', '#00FF00', '#00FFFF', '#0000FF', '#9C00FF', '#FF00FF'],
        ['#F7C6CE', '#FFE7CE', '#FFEFC6', '#D6EFD6', '#CEDEE7', '#CEE7F7', '#D6D6E7', '#E7D6DE'],
        ['#E79C9C', '#FFC69C', '#FFE79C', '#B5D6A5', '#A5C6CE', '#9CC6EF', '#B5A5D6', '#D6A5BD'],
        ['#E76363', '#F7AD6B', '#FFD663', '#94BD7B', '#73A5AD', '#6BADDE', '#8C7BC6', '#C67BA5'],
        ['#CE0000', '#E79439', '#EFC631', '#6BA54A', '#4A7B8C', '#3984C6', '#634AA5', '#A54A7B'],
        ['#9C0000', '#B56308', '#BD9400', '#397B21', '#104A5A', '#085294', '#311873', '#731842'],
        ['#630000', '#7B3900', '#846300', '#295218', '#083139', '#003163', '#21104A', '#4A1031']
      ],

      // fontSize
      fontSizes:['8', '9', '10', '11', '12', '14', '18', '24', '36'],

      // lineHeight
      lineHeights: ['1.0', '1.2', '1.4', '1.5', '1.6', '1.8', '2.0', '3.0'],


});


$('.paid-order').change(function(){

    $('#order-box').show();

    var orderid = $(this).data('orderid')
    var currency = $(this).data('currency')
    var price = Number($(this).val())
    var amount = Number($('#txtGrandTotal').val())

    if($(this).prop('checked')){

         if(price > 0.00 && amount == 0.00){
            $('#txtGrandTotal').val(price)
            $('#tot').html(price.toFixed(2))
        }else{
            gtotal = price + amount
            $('#txtGrandTotal').val(gtotal)
            $('#tot').html(gtotal.toFixed(2))
        }
      var div = '<tr id="'+ orderid +'">'+
                    '<td>'+ orderid +'</td>'+
                    '<td>'+ currency +' '+ price.toFixed(2) +'</td>'
                +'</tr>';
        $('#order-tbl').find('tbody').append(div);
        var input = '<input type="hidden" name="order_id[]" id="'+ orderid +'" value="'+ orderid +'"/>'
        $('#order-form').append(input);

    }else{
        gtotal =  amount - price
        $('#txtGrandTotal').val(gtotal)
        $('#tot').html(gtotal.toFixed(2))
        $('#order-tbl').find('tbody').find('#'+orderid).remove();
        $('#order-form').find('#'+orderid).remove()
    }
})




var optionsUser = { 
    complete: function(response) 
    {
        console.log(response);
        if($.isEmptyObject(response.responseJSON.error)){
            window.location.href = window.location.href;
        }else{
            printErrorMsg(response.responseJSON.error);
        }
    }
};

$("body").on("click",".cancel-rason",function(e){
  $(this).parents("form").ajaxForm(optionsUser);
});

function printErrorMsg (msg) {
  $(".print-error-msg").html('');
  $(".print-error-msg").css('display','block');
  $.each( msg, function( key, value ) {
    $(".print-error-msg").append(value);
  });
}

$('.close-canel').click(function(){
  $(".print-error-msg").html('');
})


$(document).ajaxStart(function() {
  // $('.modal').hide();
  $("#loading").show();
});

$(document).ajaxStop(function() {
  $("#loading").hide();
});