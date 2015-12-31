function getRoomStatusContent() {
    $("#" + contentId).load(htmlContent + "user_room_status_intro.html", function() {
    
        var roomSelect = document.getElementById("status-room-select");
        var dateSelect = document.getElementById("status-date-select");
        var nextButton = document.getElementById("status-next-button");

        var ajaxRequest = getXMLHTTPRequest();
        ajaxRequest.open("POST", "include/ajaxGetRooms.php", true);
        ajaxRequest.onreadystatechange = response;
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxRequest.send("roomPerPage=10000000");

        function response() {
            if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                var response = ajaxRequest.responseXML;
                var rooms = response.getElementsByTagName("room");

                for(var i = 0; i < rooms.length; i++) {
                    var option = document.createElement("option");
                    option.value = rooms[i].getElementsByTagName("id")[0].childNodes[0].nodeValue;
                    option.text = rooms[i].getElementsByTagName("id")[0].childNodes[0].nodeValue;
                    roomSelect.appendChild(option);
                }

                nextButton.className = "waves-effect waves-light btn";
                $('select').material_select();

                nextButton.onclick = function() {
                    var dateValue = new Date(dateSelect.value);
                    dateValue.setHours(0, -dateValue.getTimezoneOffset(), 0, 0);
                    dateValue = dateValue.toISOString().slice(0, 10).replace('T', ' ');
                    getRoomContent(roomSelect.value, dateValue);
                };
            }
        }
        
        $('select').material_select();
        $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 15 // Creates a dropdown of 15 years to control year
          });
        dateSelect.value = new Date().toDateString();
    });
}

function getRoomContent(room, date) {
    $("#" + contentId).load(htmlContent + "user_room_status.html", function() {
        document.getElementById("user-status-header").innerHTML = "Room Status of " + room + " on " + new Date(date).toDateString();
        var userContent = document.getElementById("user-status-content");
        
        var ajaxRequest = getXMLHTTPRequest();
        ajaxRequest.open("POST", "include/ajaxGetSchedule.php", true);
        ajaxRequest.onreadystatechange = response;
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxRequest.send("page=0&schedulePerPage=100000000&room=" + room + "&day=" + dayMap[new Date(date).getDay()]);
        
        function response() {
            if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                var schedule = ajaxRequest.responseXML.getElementsByTagName("schedule");
                
                ajaxRequest = getXMLHTTPRequest();
                ajaxRequest.open("POST", "include/ajaxGetBookings.php", true);
                ajaxRequest.onreadystatechange = response2;
                ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                ajaxRequest.send("page=0&bookingPerPage=100000000&room=" + room + "&dateRange=" + JSON.stringify([date, date]));

                function response2() {
                    if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                        var bookings = ajaxRequest.responseXML.getElementsByTagName("booking");
                        
                        var dateRoutine = {
                        }
                        
                        for(var i = 0; i < schedule.length; i++) {
                            var scheduleCourseName = schedule[i].getElementsByTagName("course")[0].childNodes[0].nodeValue;
                            var scheduleCourseStart = parseInt(schedule[i].getElementsByTagName("start")[0].childNodes[0].nodeValue);
                            var scheduleCourseEnd = parseInt(schedule[i].getElementsByTagName("end")[0].childNodes[0].nodeValue);
                            for(var j = scheduleCourseStart; j <= scheduleCourseEnd; j++) {
                                dateRoutine[j] = scheduleCourseName + " (Schedule)";
                            }
                        }
                        for(var i = 0; i < bookings.length; i++) {
                            var bookingCourseName = bookings[i].getElementsByTagName("course")[0].childNodes[0].nodeValue;
                            var bookingCourseStart = parseInt(bookings[i].getElementsByTagName("start")[0].childNodes[0].nodeValue);
                            var bookingCourseEnd = parseInt(bookings[i].getElementsByTagName("end")[0].childNodes[0].nodeValue);
                            for(var j = bookingCourseStart; j <= bookingCourseEnd; j++) {
                                dateRoutine[j] = bookingCourseName + " (Booked)";
                            }
                        }
                        
                        var table = document.createElement("table");
                        table.className = "striped bordered";
                        for(var i = 1; i < 29; i++) {
                            var row = table.insertRow(-1);
                            var col1 = row.insertCell(-1);
                            var col2 = row.insertCell(-1);
                            
                            col1.innerHTML = timeBlock[i] + " - " + timeBlock[i + 1];
                            if(dateRoutine[i] != null) {
                                col2.innerHTML = dateRoutine[i];
                            }
                            else {
                                col2.innerHTML = "Free";
                            }
                        }
                        
                        userContent.appendChild(table);
                    }
                }
            }
        }
    });
}