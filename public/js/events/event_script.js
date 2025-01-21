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
        $('#org_error').html(response.responseJSON.errors)            
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
    if($('#tickets > .row.tickets-box:last-child').length!=0){ var nn=$('#tickets > .row.tickets-box:last-child').data('nbtick')+1; }else{ var nn=1; }
  i++;
  $("#tickets").append (
    '<div class="row tickets-box ticket-' + i + '" data-nbtick="'+nn+'">' 
    + typehid + $('.addeventtickets').html() +
    '</div>'    
  )
  
    $('.row.tickets-box.ticket-'+i+' .fieldBlock .nbvalue').val(0); 
    $('.row.tickets-box.ticket-'+i+' .fieldBlock .nbvalue').attr('name','nbvalue['+nn+']'); 
    $('.row.tickets-box.ticket-'+i+' .fieldBlock .selectfiledtype').attr('name','field_type['+nn+'][]'); 
    $('.row.tickets-box.ticket-'+i+' .fieldBlock .fieldtitle').attr('name','field_title['+nn+'][]'); 
    console.log("--"+nn);
  
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


$('body').on("click", ".addFields", function (event) {
   $(this).parent().parent().children('.formFields').toggle('1000');
 $(this).parent().parent().children('.formFields').children('.fieldBlock').toggle('1000');
});

$('body').on("change", ".selectfiledtype", function (event) {
  var typefield=$(this).find(":selected").val();
if(typefield=="list"){
  var Ticketfield=$(this).parent().parent().parent().parent().data('nbtick');
  $(this).parent().parent().children('.addoptions').removeClass('hidden');//'.fieldBlock .addoptions .morelines .values'
   var field=$(this).parent().parent().data('nbop');
   var callfield=$(this).parent().parent().parent().find('.morelines').length;
   var nbListField=$(this).parent().parent().parent().find('.addoptions:not(.hidden) .morelines > .values').length;
  
   var nboption=$(this).parent().parent().children('.addoptions').children('.morelines').children('.values').attr('name','value['+Ticketfield+']['+field+'][]');
   var nboption=$(this).parent().parent().children('.addoptions').children('.morelines').children('.values').attr('data-list',nbListField);

}else{
  if(!$(this).parent().parent().children('.addoptions').hasClass('hidden')){
    $(this).parent().parent().children('.addoptions').addClass('hidden');
  }
}
});

$('body').on("click", ".duplicatevalue", function(event) {
var n=$(this).parent().find('.values').data('list');
$(this).parent().clone().appendTo( $(this).parent().parent() );
var boption=$(this).parent().find('.values').data('list',n+1);
});
$('body').on("click", ".removevalue", function (event) {

if($(this).parent().parent().children('.morelines').length > 1){
  $(this).parent('.morelines').remove();		
}else{
  alert("Impossible de supprimer ce champ!")
}

});

$('body').on("click", ".newfield", function (event) {
var nn=$(this).parent().parent().children('.fieldBlock:last-child').data('nbtick');
var nv=$('#tickets > .row.tickets-box:last-child').data('nbtick'); 
var nbop=$(this).parent().parent().children('.fieldBlock:last-child').data('nbop')+1;
 // <option value="teaxtarea">Texte multiligne</option>
var content='<div class="fieldBlock" data-nbop="'+nbop+'"><input type="hidden" name="nbvalue['+nv+']" value="'+nbop+'"> <a type="button" class="removefield"><i class="fa fa-times" aria-hidden="true"></i></a><div class="form-group" style="width:48%; float:left"> <label class="text-uppercase label-text">Type de champ</label> <select name="field_type['+nv+'][]" class="form-control selectfiledtype form-textbox"> <option value="">S&eacute;lectionner un type de champ</option> <option value="text">Texte</option> <option value="list">Liste</option>	</select></div> <div class="form-group" style="width:48%; float:right">	<label class="text-uppercase label-text">Titre du champ</label>	<input type="text" name="field_title['+nv+'][]" class="form-control fieldtitle form-textbox"> </div><div class="form-group addoptions hidden"><label class="text-uppercase label-text">Valeurs du champ</label>	<div class="morelines"><a type="button" class="removevalue"><i class="fa fa-minus-circle" aria-hidden="true"></i></a> <input type="text" name="value['+nv+']['+nbop+'][]" class="form-control form-textbox values"> <a type="button" class="duplicatevalue"><i class="fa fa-plus-circle" aria-hidden="true"></i></a></div> </div></div>';
$(this).parent().parent().children('.formFields > .fieldBlock:last-child').after( content );
});

$('body').on("click", ".removefield", function (event) {
if(confirm("Voulez-vous vraiment supprimer ce champ ?")){
  $(this).parent('.fieldBlock').remove();
}
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