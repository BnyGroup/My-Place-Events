 $('body').on('click','.delete-box',function(){
  
    var url = $(this).data('url')
    var id = $(this).data('id')

      swal({
          title: "Are you sure?",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: 'btn-danger btn-flat',
          confirmButtonText: ' Delete',
          cancelButtonText: "Cancel",
          cancelButtonClass: "btn-flat ",
          closeOnConfirm: false,
          closeOnCancel: false,
        },
        function(isConfirm){
          if (isConfirm){

            $.ajax({
              url: url,
              type: 'GET',
              success:function(data){
                swal({
                  title:"Deleted!", 
                  type: "success",
                  text:data.success, 
                  confirmButtonClass:"btn-info btn-flat ",
                  confirmButtonText:"Close",
                },function(){
                  window.location.href = data; 
                });
              }
            });
          } else {
            swal({
                title:"Cancelled", 
                type: "error",
                confirmButtonClass:"btn-info btn-flat",
                confirmButtonText:"Close",
            });
          }
        });
});