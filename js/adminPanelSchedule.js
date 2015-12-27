
var scheduleRoom, scheduleDay;

function getScheduleContent() {
    var temp = "<h4>Semester Schedule</h4><hr />" +
               "<div style=\"height:70vmin; \" class=\"valign-wrapper\">" +
               "    <div class=\"valign\" style=\"margin: 0 auto;\">" +
               "        <table>" +
               "            <tr>" +
               "                <td><span>Select a room</span></td>" +
               "                <td><select id=\"schedule-room-select\"></select></td>" +
               "            </tr>" +
               "            <tr>" +
               "                <td><span>Select a day</span></td>" +
               "                <td><select id=\"schedule-day-select\"></select></td>" +
               "            </tr>" +
               "            <tr><td style=\"text-align: right;\" colspan=\"2\"><a id=\"schedule-next-button\" class=\"waves-effect waves-light btn disabled\"><i class=\"material-icons right\">send</i>Next</a></td></tr>" +
               "        </table>" +
               "    </div>" +
               "</div>";
    
    content.innerHTML = temp;
    
    var dayArray = ["Saturday", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];
    
    var roomSelect = document.getElementById("schedule-room-select");
    var daySelect = document.getElementById("schedule-day-select");
    var nextButton = document.getElementById("schedule-next-button");
    
    for (var i = 0; i < dayArray.length; i++) {
        var option = document.createElement("option");
        option.value = dayArray[i];
        option.text = dayArray[i];
        daySelect.appendChild(option);
    }
    
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
            
            nextButton.onclick = function() {getRoomScheduleContent(roomSelect.value, daySelect.value);};
        }
    }
            
}

function getRoomScheduleContent(room, day) {
    scheduleRoom = room;
    scheduleDay = day;
    
    var temp = "<h4>Semester Schedule of " + room + " on " + day + "s</h4><hr />" +
               "    <div class=\"col s12\">" + 
               "        <button data-target=\"create-schedule-modal\" class=\"btn col s12 waves-effect waves-light create-schedule-modal-trigger\">Create Schedule</button>" +
               "        <button data-target=\"delete-all-schedule-modal\" class=\"btn col s12 waves-effect waves-light delete-all-schedule-modal-trigger\">Delete All Schedule</button>" + 
               "    </div>" +
               "    <div class=\"col s12\" >" +
               "        <table id=\"schedule-list-table\" class=\"responsive-table striped\">" +
               "            <thead>" +
               "                <tr><th colspan=\"4\">Schedule List</th></tr>" +
               "                <tr>" +
               "                    <th data-field=\"course\">Course</th>" +
               "                    <th data-field=\"start\">From</th>" +
               "                    <th data-field=\"end\">To</th>" +
               "                    <th data-field=\"options\"></th>" +
               "                </tr>" +
               "            </thead><tbody id=\"schedule-list-table-body\"></tbody>" +
               "        </table>" +
               "    </div>" +
               "    <div id=\"schedule-pagination-area\"></div>" +
               "</div>";
    
    
    content.innerHTML = temp;
    
    $(".create-schedule-modal-trigger").leanModal({
        dismissible: true, // Modal can be dismissed by clicking outside of the modal
        opacity: .5, // Opacity of modal background
        in_duration: 300, // Transition in duration
        out_duration: 200, // Transition out duration
        ready: function() { }, // Callback for Modal open
        complete: function() { 
            document.getElementById("create-schedule-form").reset();
        }
    });
    $(".delete-all-schedule-modal-trigger").leanModal({
        dismissible: true, // Modal can be dismissed by clicking outside of the modal
        opacity: .5, // Opacity of modal background
        in_duration: 300, // Transition in duration
        out_duration: 200, // Transition out duration
        ready: function() { }, // Callback for Modal open
        complete: function() { }
    });
    
    document.getElementById("schedule-course").onchange = function() {validateScheduleCourse("schedule-course", "schedule-course-label");};
    document.getElementById("create-schedule-button").onclick = function() {validateScheduleForm("schedule-course", "schedule-start", "schedule-end");};
    
    document.getElementById("delete-all-schedule-yes-button").onclick = function() {
        var ajaxRequest = getXMLHTTPRequest();
        ajaxRequest.open("POST", "include/ajaxDeleteSchedule.php", true);
        ajaxRequest.onreadystatechange = response;
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxRequest.send("all=true&room=" + scheduleRoom + "&day=" + scheduleDay);
        
        function response() {
            if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                if(ajaxRequest.responseText == "true") {
                    updateScheduleList(currentSchedulePage, pagination);
                    $('#delete-all-schedule-modal').closeModal();
                    Materialize.toast('Deleted all schedule!', 2000);
                }
                else {
                    Materialize.toast('Failed to delete all schedule!', 2000);
                }
            }
        }
        
    };
    
    updateScheduleList(0, pagination);
}

function validateScheduleCourse(id, label, old) {
    var course = document.getElementById(id);
    var courseLabel = document.getElementById(label);
    var pattern = /^[a-z\d\-\s]+$/i;
    var value = course.value;
    var result = pattern.exec(value);
    var ajaxRequest = getXMLHTTPRequest();
    
    if(value == "") {
        course.className = "";
    }
    else if(old != null && old == value) {
        course.className = "valid";
    }
    else if(result == null) {
        courseLabel.setAttribute("data-error", "Error");
        course.className = "invalid";
    }
    else {
        ajaxRequest.open("POST", "include/ajaxCheck.php", true);
        ajaxRequest.onreadystatechange = response;
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxRequest.send("course=" + value + "&room=" + scheduleRoom + "&day=" + scheduleDay);
        
        function response() {
            if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                var courseAlreadyAssigned = ajaxRequest.responseXML.getElementsByTagName("schedule")[0].childNodes[0].nodeValue;
                if(courseAlreadyAssigned == "true") {
                    courseLabel.setAttribute("data-error", "Exists");
                    course.className = "invalid";
                }
                else {
                    courseLabel.setAttribute("data-error", "Error");
                    course.className = "valid";
                }
            }
        }
        
    }
}

function validateScheduleForm(course, start, end) {
    course = document.getElementById(course);
    start = document.getElementById(start);
    end = document.getElementById(end);
    
    var ajaxRequest = getXMLHTTPRequest();
    
    if(course.className == "valid") {
        if(parseInt(start.value) < parseInt(end.value)) {
            var data = {
                room : scheduleRoom,
                day : scheduleDay,
                course : course.value,
                start : start.value,
                end : parseInt(end.value) - 1
            }
            
            
            ajaxRequest.open("POST", "include/ajaxRegisterSchedule.php", true);
            ajaxRequest.onreadystatechange = response;
            ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajaxRequest.send("data=" + JSON.stringify(data));

            function response() {
                if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                    if(ajaxRequest.responseText == "clash") {
                        alert("Selected timing has clash!");
                    }
                    else if(ajaxRequest.responseText == "true") {
                        
                        document.getElementById("create-schedule-form").reset();
                        
                        updateScheduleList(currentSchedulePage, pagination);
                        
                        $('#create-schedule-modal').closeModal();
                        Materialize.toast('Schedule created successfully!', 2000);
                    }
                    else if(ajaxRequest.response == "false") {
                        Materialize.toast('Failed to create schedule!', 2000);
                    }
                }
            }
        }
        else {
            alert("Invalid time range selected!");
        }
    }
    else {
        alert("Please fix the errors!");
    }
}


function updateScheduleList(page, schedulePerPage) {
    var ajaxRequest = getXMLHTTPRequest();
    ajaxRequest.open("POST", "include/ajaxGetSchedule.php", true);
    ajaxRequest.onreadystatechange = response;
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.send("page=" + page + "&schedulePerPage=" + schedulePerPage + "&room=" + scheduleRoom + "&day=" + scheduleDay);
    
    
    var table = document.getElementById("schedule-list-table-body");
    
    function response() {
        if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
            var response = ajaxRequest.responseXML;
            if(response == null) {table.innerHTML = ""; document.getElementById("schedule-pagination-area").innerHTML = ""; return;}
            var pageRequired = response.getElementsByTagName("pageRequired")[0].childNodes[0].nodeValue;
            
            var schedule = response.getElementsByTagName("schedule");
            
            table.innerHTML = "";
            
            for(var i = 0; i < schedule.length; i++) {
                var course = schedule[i].getElementsByTagName("course")[0].childNodes[0].nodeValue;
                var start = schedule[i].getElementsByTagName("start")[0].childNodes[0].nodeValue;
                var end = schedule[i].getElementsByTagName("end")[0].childNodes[0].nodeValue;
                
                var row = table.insertRow(i);
                var courseCell = row.insertCell(0);
                var startCell = row.insertCell(1);
                var endCell = row.insertCell(2);
                var optionCell = row.insertCell(3);
                
                courseCell.innerHTML = course;
                startCell.innerHTML = timeBlock[start];
                endCell.innerHTML = timeBlock[parseInt(end) + 1];
                
                optionCell.innerHTML = "<div class=\"right\"><a class=\"waves-effect waves-light btn\" onclick=\"return showEditSchedule('" + course + "', '"+ start +"', '" + (parseInt(end) + 1) + "');\">Edit Schedule</a><a class=\"waves-effect waves-light btn\" onclick=\"return showDeleteSchedule('" + course + "', '"+ start +"', '" + (parseInt(end) + 1) + "');\">Delete Schedule</a></div>";
            }
            
            if(page >= pageRequired) page = pageRequired - 1;
            else if(page < 0) page = 0;
            
            currentSchedulePage = page;
            
            var paginationHTML = "<ul class=\"pagination\">";
            if(page - 1 < 0) paginationHTML = paginationHTML + "<li class=\"disabled\"><a href=\"#\"><i class=\"material-icons\">chevron_left</i></a></li>";
            else paginationHTML = paginationHTML + "<li onclick=\"updateScheduleList(" + (page - 1) + ", " + pagination + ");\"><a href=\"#\"><i class=\"material-icons\">chevron_left</i></a></li>";
            
            for(var i = 0; i < pageRequired; i++) {
                if(i == page) paginationHTML = paginationHTML + "<li class=\"active\" onclick=\"updateScheduleList(" + i + ", " + pagination + ");\"><a href=\"#\">" + (i + 1) + "</a></li>";
                else paginationHTML = paginationHTML + "<li onclick=\"updateScheduleList(" + i + ", " + pagination + ");\"><a href=\"#\">" + (i + 1) + "</a></li>";
            }
            
            if(page + 1 >= pageRequired) paginationHTML = paginationHTML + "<li class=\"disabled\"><a href=\"#\"><i class=\"material-icons\">chevron_right</i></a></li>";
            else paginationHTML = paginationHTML + "<li onclick=\"updateScheduleList(" + (page + 1) + ", " + pagination + ");\"><a href=\"#\"><i class=\"material-icons\">chevron_right</i></a></li>";
            
            paginationHTML = paginationHTML + "</ul>";
            
            document.getElementById("schedule-pagination-area").innerHTML = "<div class=\"right\">" + paginationHTML + "</div>";
        }
    }
}

function showEditSchedule(courseValue, startValue, endValue) {
    $('#edit-schedule-modal').openModal();
    
    var course = document.getElementById("edit-schedule-course");
    var start = document.getElementById("edit-schedule-start");
    var end = document.getElementById("edit-schedule-end");
    var button = document.getElementById("edit-schedule-button");
    
    course.className = "valid";
    
    course.value = courseValue;
    start.value = startValue;
    end.value = endValue;
    
    $('select').material_select();
    
    course.onchange = function() {validateScheduleCourse("edit-schedule-course", "edit-schedule-course-label", courseValue);};
    button.onclick = function() {
        if(course.className == "valid") {
            if(parseInt(start.value) < parseInt(end.value)) {
                var data = {
                    room : scheduleRoom,
                    day : scheduleDay,
                    course : course.value,
                    start : start.value,
                    end : parseInt(end.value) - 1
                }
                
                var oldData = {
                    room : scheduleRoom,
                    day : scheduleDay,
                    course : courseValue,
                    start : startValue,
                    end : endValue - 1
                }


                ajaxRequest.open("POST", "include/ajaxUpdateSchedule.php", true);
                ajaxRequest.onreadystatechange = response;
                ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                ajaxRequest.send("data=" + JSON.stringify(data) + "&old=" + JSON.stringify(oldData));

                function response() {
                    if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                        console.log(ajaxRequest.responseText);
                        if(ajaxRequest.responseText == "clash") {
                            alert("Selected timing has clash!");
                        }
                        else if(ajaxRequest.responseText == "true") {

                            document.getElementById("edit-schedule-form").reset();

                            updateScheduleList(currentSchedulePage, pagination);

                            $('#edit-schedule-modal').closeModal();
                            Materialize.toast('Schedule edited successfully!', 2000);
                        }
                        else if(ajaxRequest.response == "false") {
                            Materialize.toast('Failed to edit schedule!', 2000);
                        }
                    }
                }
            }
            else {
                alert("Invalid time range selected!");
            }
        }
    };
}

function showDeleteSchedule(courseValue, startValue, endValue) {
    $('#delete-schedule-modal').openModal();
    
    var button = document.getElementById("delete-schedule-yes-button");
    
    button.onclick = function() {
        var data = {
            room : scheduleRoom,
            day : scheduleDay,
            course : courseValue,
            start : startValue,
            end : endValue - 1
        }
        
        var ajaxRequest = getXMLHTTPRequest();
        ajaxRequest.open("POST", "include/ajaxDeleteSchedule.php", true);
        ajaxRequest.onreadystatechange = response;
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxRequest.send("data=" + JSON.stringify(data));
        
        function response() {
            if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                console.log(ajaxRequest.responseText);
                if(ajaxRequest.responseText == "true") {
                    updateScheduleList(currentUserPage, pagination);
                    $('#delete-schedule-modal').closeModal();
                    Materialize.toast('Deleted schedule!', 2000);
                }
                else {
                    Materialize.toast('Failed to delete schedule!', 2000);
                }
            }
        }
    };
}
