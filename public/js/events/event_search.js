$( document ).ready(function() {

    
    $("#cat_date").click(function(){
         $("#cat_date").attr("data-url", "cat--date--all");
         $("#cat_menu").attr("data-url", "cat--date--all");
         $("#sub_cat").attr("data-url", "cat--date--all");
    });
  
    $("#sub_cat").click(function(){
        $("#sub_cat").attr("data-url", "cat--date--all");
    });

    $('.shorting').click(function(){

        //$(this).attr('data-url',"cat--date--all")
         $("#cat_date").attr("data-url", "cat--date--all");
         $("#cat_menu").attr("data-url", "cat--date--all");
         $("#sub_cat").attr("data-url", "cat--date--all");
        
    	var dataUrl = $(this).attr('data-url')
    	var dataId = $(this).attr('data-id')
    	var dataType = $(this).attr('data-type')

        if(dataUrl == ''){dataUrl = "cat--date--all"}
            
    	var dataUrlArray = dataUrl.split('--');

        if(dataType == 0) {
            dataUrlArray[0] = dataId
        } else if(dataType == 1) {
            dataUrlArray[1] = dataId
        } else if(dataType == 2) {
            dataUrlArray[2] = dataId
        } else {
            //
        }
        var newstartdate    = '';
        var newenddate      = '';
        if(dataUrlArray[1] == 'cdate'){
            var start_date  = $('.cdate').children('#start_date').val()
            var end_date    = $('.cdate').children('#end_date').val()
            if(start_date != '' && Date.parse(start_date)) {                
                newstartdate = new Date(start_date).getTime()/1000;
            }
            if(end_date != '' && Date.parse(end_date)){
                newenddate = new Date(end_date).getTime()/1000;
            }
        }else{            
            dataUrl = dataUrlArray[2].split('?')
            dataUrlArray[2] = dataUrl[0]
        }

        var fUrl = dataUrlArray.join("--")
        if(newstartdate == '' && newenddate == ''){
            window.location = '/events/' + fUrl
        } else {        
            window.location = '/events/' + fUrl + '?ds=' + newstartdate + '&de=' + newenddate
        }
    });
});

$('body').on('click','.custom_date_data',function(){
    alert();
});