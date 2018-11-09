var nationalDays = ["3-12", "12-12", "26-12"];


function DisableDays(date) {
    var m = date.getMonth();
    var d = date.getDate();
    var currentDate = d + "-" + (m + 1);
    var day = date.getDay();

    if (day === 2 || day === 0) {
        return [false];
    }

    for (var i = 0; i < nationalDays.length; i++) {
        if ($.inArray(currentDate, nationalDays) != -1) {
            return [false];
        }
    }
    return [true]
}


$("#datepicker").datepicker({
    //minDate: 0,
    beforeShowDay: DisableDays,
    dateFormat: "yy-mm-dd"
});