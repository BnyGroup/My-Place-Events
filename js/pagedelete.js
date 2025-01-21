 $('#btn-page-delete').click(function(){
  var urls = $(this).attr('data-url');
  // alert(urls);
  swal({
    title: "Are you sure?",
    text: "Are You Sure You Want To Delete This Page ?",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Yes, delete it!",
    cancelButtonText: "No, cancel plz!",
    closeOnConfirm: false,
    closeOnCancel: false
  },
  function(isConfirm) {
    if (isConfirm) {
      $.ajax({
        url:urls,
        method:'get',
        success: function ( output ) {
          //alert(output);  
          swal({
            title:"Deleted Page.",
            text:' ',
            type:'success',
          },function(){
            window.location.href = output            
          })
        }
      })
    } else {
      swal("Cancelled", " ", "error");
    }
});
});