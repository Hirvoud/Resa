
function DisableTuesday(date) {

    var day = date.getDay();

    if (day == 2) {

        return [false] ;

    } else {

        return [true] ;
    }

}


var disableddates = ["3-12-2018", "11-12-2018", "25-12-2018"];

function DisableSpecificDates(date) {

    var string = jQuery.datepicker.formatDate('dd-mm-yy', date);
    return [ disableddates.indexOf(string) == -1 ] }