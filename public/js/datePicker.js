// function JoursFeries (an){
//     var JourAn = new Date(an, "00", "01");
//     var FeteTravail = new Date(an, "04", "01");
//     var Victoire1945 = new Date(an, "04", "08");
//     var FeteNationale = new Date(an,"06", "14");
//     var Assomption = new Date(an, "07", "15");
//     var Toussaint = new Date(an, "10", "01");
//     var Armistice = new Date(an, "10", "11");
//     var Noel = new Date(an, "11", "25");
//     var SaintEtienne = new Date(an, "11", "26");
//
//     var G = an%19;
//     var C = Math.floor(an/100);
//     var H = (C - Math.floor(C/4) - Math.floor((8*C+13)/25) + 19*G + 15)%30;
//     var I = H - Math.floor(H/28)*(1 - Math.floor(H/28)*Math.floor(29/(H + 1))*Math.floor((21 - G)/11));
//     var J = (an*1 + Math.floor(an/4) + I + 2 - C + Math.floor(C/4))%7;
//     var L = I - J;
//     var MoisPaques = 3 + Math.floor((L + 40)/44);
//     var JourPaques = L + 28 - 31*Math.floor(MoisPaques/4);
//     var Paques = new Date(an, MoisPaques-1, JourPaques);
//     var VendrediSaint = new Date(an, MoisPaques-1, JourPaques-2);
//     var LundiPaques = new Date(an, MoisPaques-1, JourPaques+1);
//     var Ascension = new Date(an, MoisPaques-1, JourPaques+39);
//     var Pentecote = new Date(an, MoisPaques-1, JourPaques+49);
//     var LundiPentecote = new Date(an, MoisPaques-1, JourPaques+50);
//
//     return new Array(JourAn, VendrediSaint, Paques, LundiPaques, FeteTravail, Victoire1945, Ascension, Pentecote, LundiPentecote, FeteNationale, Assomption, Toussaint, Armistice, Noel, SaintEtienne)
// }

function JoursFeries (an){
    var JourAn = new Date(an, "00", "02");
    var FeteTravail = new Date(an, "04", "02");
    var Victoire1945 = new Date(an, "04", "09");
    var FeteNationale = new Date(an,"06", "15");
    var Assomption = new Date(an, "07", "16");
    var Toussaint = new Date(an, "10", "02");
    var Armistice = new Date(an, "10", "12");
    var Noel = new Date(an, "11", "26");
    var SaintEtienne = new Date(an, "11", "27");

    var G = an%19;
    var C = Math.floor(an/100);
    var H = (C - Math.floor(C/4) - Math.floor((8*C+13)/25) + 19*G + 15)%30;
    var I = H - Math.floor(H/28)*(1 - Math.floor(H/28)*Math.floor(29/(H + 1))*Math.floor((21 - G)/11));
    var J = (an*1 + Math.floor(an/4) + I + 2 - C + Math.floor(C/4))%7;
    var L = I - J;
    var MoisPaques = 3 + Math.floor((L + 40)/44);
    var JourPaques = L + 28 - 31*Math.floor(MoisPaques/4);
    var Paques = new Date(an, MoisPaques-1, JourPaques+1);
    var VendrediSaint = new Date(an, MoisPaques-1, JourPaques-1);
    var LundiPaques = new Date(an, MoisPaques-1, JourPaques+2);
    var Ascension = new Date(an, MoisPaques-1, JourPaques+40);
    var Pentecote = new Date(an, MoisPaques-1, JourPaques+50);
    var LundiPentecote = new Date(an, MoisPaques-1, JourPaques+51);

    return new Array(JourAn, VendrediSaint, Paques, LundiPaques, FeteTravail, Victoire1945, Ascension, Pentecote, LundiPentecote, FeteNationale, Assomption, Toussaint, Armistice, Noel, SaintEtienne)
}

// function isHolydays(date){
//     var holidays = JoursFeries(date.getFullYear());
//
//     holidays.forEach(function(elt){
//         if(elt.toDateString() === date.toDateString()){
//             console.log(elt.toDateString(),date.toDateString(),date);
//             return true;
//         }
//     });
//
//     return false;
// }
//
// function DisableDays(date) {
//     if (isHolydays(date) === true/* || date.getDay() === 2 ||date.getDay() === 0*/) {
//         return [false];
//     }
//     return [true]
// }


function mergeHolidays()
{
    var feries1 = JoursFeries(new Date().getFullYear());
    var feries2 = JoursFeries(new Date().getFullYear()+1);

    return feries1.concat(feries2);
}

$('.datepicker').datepicker({
    language: "fr",
    daysOfWeekDisabled: [0,2],
    datesDisabled: mergeHolidays(),
    maxViewMode: "year",
    weekStart: 1,
    startDate: new Date(),
    format: "yyyy-mm-dd"
});