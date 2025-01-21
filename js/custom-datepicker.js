$(function () {

    /*========================== create and update events ====================================*/
    $('.time-1').datetimepicker({
        //format: 'hh:mm A',
        format: 'hh:mm',
    });
    $('.time-2').datetimepicker({
       //format: 'hh:mm A',
        format: 'hh:mm',
    });

    $('.datetimepicker1').datetimepicker({
        useCurrent: false,
        //format: 'MM/DD/YYYY',
        format: 'DD/MM/YYYY',
        minDate:new Date(),
    });
    $('.datetimepicker2').datetimepicker({
        useCurrent: false,
        //format: 'MM/DD/YYYY',
        format: 'DD/MM/YYYY',
    });
    $(".datetimepicker1").on("change.datetimepicker", function (e) {
        $('.datetimepicker2').datetimepicker('minDate', e.date);
    });
    $(".datetimepicker2").on("change.datetimepicker", function (e) {
        $('.datetimepicker1').datetimepicker('maxDate', e.date);
    });

    var time3 = $('.time-3').data('val')
    var time4 = $('.time-4').data('val')
    var date3 = $('.datetimepicker3').data('val')
    var date4 = $('.datetimepicker4').data('val')


    var _startTimeStr = time3;
    var _startTimeStr1 = time4;
    //if (moment(_startTimeStr, 'h:mm a').isValid()) {
    if (moment(_startTimeStr, 'h:mm').isValid()) {
        var hr = moment(_startTimeStr, 'h:mm').hour();
        var min = moment(_startTimeStr, 'h:mm').minutes();
    }
    if (moment(_startTimeStr1, 'h:mm').isValid()) {
        var hrs = moment(_startTimeStr1, 'h:mm').hour();
        var mins = moment(_startTimeStr1, 'h:mm').minutes();
    }

    // var dt = new Date();
    // if(hrs1 == undefined || mins1 == undefined){
    //     hrs = dt.getHours()
    //     mins = dt.getMinutes()
    // }else{
    //     hrs = hrs1;
    //     mins = mins1;
    // }


    $('.time-3').datetimepicker({
        //format: 'hh:mm A',
        format: 'hh:mm',
        defaultDate:moment().hours(Number(hr)).minutes(Number(min)).seconds(0).milliseconds(0)
    });
    $('.time-4').datetimepicker({
        //format: 'hm:mm A',
        format: 'hh:mm',
        defaultDate:moment().hours(Number(hrs)).minutes(Number(mins)).seconds(0).milliseconds(0)
    });

    $('.datetimepicker3').datetimepicker({
        //format: 'MM/DD/YYYY',
        format: 'DD/MM/YYYY',
        defaultDate: date3,
    });
    $('.datetimepicker4').datetimepicker({
        //format: 'MM/DD/YYYY',
        format: 'DD/MM/YYYY',
        defaultDate: date4,
    });
    $(".datetimepicker3").on("change.datetimepicker", function (e) {
        $('.datetimepicker4').datetimepicker('minDate', e.date);
    });
    $(".datetimepicker4").on("change.datetimepicker", function (e) {
        $('.datetimepicker3').datetimepicker('maxDate', e.date);
    });
    /*========================== create and update events ====================================*/

    /*========================== Event List ====================================*/
        var date5 = $('.datetimepicker1-events').data('val')
        var date6 = $('.datetimepicker2-events').data('val')

        $('.datetimepicker1-events').datetimepicker({
            //format: 'MM/DD/YYYY',
            format: 'DD/MM/YYYY',
            defaultDate: date5,
        });
        $('.datetimepicker2-events').datetimepicker({
            //format: 'MM/DD/YYYY',
            format: 'DD/MM/YYYY',
            defaultDate: date6,
        });
        $(".datetimepicker1-events").on("change.datetimepicker", function (e) {
            $('.datetimepicker2-events').datetimepicker('minDate', e.date);
        });
        $(".datetimepicker2-events").on("change.datetimepicker", function (e) {
            $('.datetimepicker1-events').datetimepicker('maxDate', e.date);
        });
    /*========================== Event List ====================================*/

});