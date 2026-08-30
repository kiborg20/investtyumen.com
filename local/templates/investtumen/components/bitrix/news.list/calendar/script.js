
$(document).ready(function(){
    var params = (new URL(document.location)).searchParams;
    //console.log('year',params.get("year"));
    var date = new Date();


    if(params.get("month")!=null ){
        curMonth = params.get("month");
        if(curMonth>=1 && curMonth<=9){
            curMonth = "0"+curMonth;
        }
    }else{
        curMonth = date.getMonth()+1;
        if(curMonth>=1 && curMonth<=9){
            curMonth = "0"+curMonth;
        }
    }

    if(params.get("year")!=null){
        curYear = params.get("year");
    }else{
        curYear = date.getFullYear();
    }

    calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'ru',
        firstDay:"1",
        events: eventsdates,
        eventClick: function(info) {
            info.jsEvent.preventDefault();
            $(".eventTitle").html(info.event.title);
            $(".eventlink").attr("href",info.event.url);
            $(".eventDescription").html(info.event.extendedProps.description);

            console.log(info);
            console.log(info.event.title);
            console.log(info.event.url);
            console.log("description",info.event.extendedProps.description);
            console.log("props",info.event.extendedProps.elid);

            Fancybox.close();
            Fancybox.show([{src: "#modalevent", type: "inline"}]);

        }
    });
    calendar.render();
    calendar.gotoDate( curYear+'-'+curMonth+'-01' );



    if(params.get("year")!=null ){
        curYearSel = params.get("year");
    }else{
        var date = new Date();
        curYearSel = date.getFullYear();
    }

    $('#calendar_year').val(curYearSel);


    $('.cal_month').click(function(e){
        e.preventDefault();
        var year = $(this).data('year');
        var month = $(this).data('month');

        window.location.href = '/personal/meropriyatiya/?year='+year+'&month='+month;
    });

    $('#calendar_year').change(function(){
        var ye = this.value;
        $('.cal_month').each(function(){
            $( this ).data("year",ye);
        });
        //window.location.href = '/personal/meropriyatiya/?year='+ye+'&month=1';
    });



});

