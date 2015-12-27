var pagination = 5;
pagination = parseInt(pagination);

var currentUserPage, currentRoomPage, currentSchedulePage, currentBookingPage;

// Initialize Materialize Components
$(document).ready(function(){
    $('select').material_select();
    $(".button-collapse").sideNav();
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15 // Creates a dropdown of 15 years to control year
      });
});

function getXMLHTTPRequest() {
    var req = false;
    try {
        /* for Firefox */
        req = new XMLHttpRequest();
    } catch (err) {
        try {
            /* for some versions of IE */
            req = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (err) {
            try {
            /* for some other versions of IE */
                req = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (err) {
                req = false;
            }
        }
    }
    return req;
}

var content = document.getElementById(<?php echo "\"".$this->contentId."\""; ?>);
var contentId = <?php echo "\"".$this->contentId."\""; ?>;
var htmlContent = "html/";
var timeBlock = {
    1 : "8:00 AM",
    2 : "8:30 AM",
    3 : "9:00 AM",
    4 : "9:30 AM",
    5 : "10:00 AM",
    6 : "10:30 AM",
    7 : "11:00 AM",
    8 : "11:30 AM",
    9 : "12:00 PM",
    10 : "12:30 PM",
    11 : "1:00 PM",
    12 : "1:30 PM",
    13 : "2:00 PM",
    14 : "2:30 PM",
    15 : "3:00 PM",
    16 : "3:30 PM",
    17 : "4:00 PM",
    18 : "4:30 PM",
    19 : "5:00 PM",
    20 : "5:30 PM",
    21 : "6:00 PM",
    22 : "6:30 PM",
    23 : "7:00 PM",
    24 : "7:30 PM",
    25 : "8:00 PM",
    26 : "8:30 PM",
    27 : "9:00 PM",
    28 : "9:30 PM",
    29 : "10:00 PM"
}
var dayMap = {
    0 : "Sunday",
    1 : "Monday",
    2 : "Tuesday",
    3 : "Wednesday",
    4 : "Thursday",
    5 : "Friday",
    6 : "Saturday"
}
var monthMap = {
    0 : "January",
    1 : "February",
    2 : "March",
    3 : "April",
    4 : "May",
    5 : "June",
    6 : "July",
    7 : "August",
    8 : "September",
    9 : "October",
    10 : "November",
    11 : "December"
}
