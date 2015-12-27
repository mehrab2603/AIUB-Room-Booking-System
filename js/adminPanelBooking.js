function getBookingsContent() {
    
    $("#" + contentId).load( htmlContent + "booking_static.html", function() {
        $(".create-booking-modal-trigger").leanModal({
            dismissible: true, // Modal can be dismissed by clicking outside of the modal
            opacity: .5, // Opacity of modal background
            in_duration: 300, // Transition in duration
            out_duration: 200, // Transition out duration
            ready: function() { 
                loadBookingFormData("create-booking-room", "create-booking-user", "create-booking-button");
            }, // Callback for Modal open
            complete: function() { 
                document.getElementById("create-booking-form").reset();
            }
        });
        
        document.getElementById("create-booking-course").onchange = function() {validateBookingCourse("create-booking-course", "create-booking-course-label");};
        document.getElementById("create-booking-button").onclick = function() {validateBookingForm("create-booking-room", "create-booking-user", "create-booking-course", "create-booking-start", "create-booking-end", "create-booking-date", "create-booking-type-makeup", "create-booking-type-advanced-makeup", "create-booking-type-other", "create-booking-modal", "create-booking-form", "include/ajaxRegisterBooking.php");};


        var searchUsername = document.getElementById("search-booking-username");
        var searchRoom = document.getElementById("search-booking-room");
        searchUsername.onkeyup = function() {
            updateBookingList(0, pagination, searchUsername.value, searchRoom.value); 
        };
        
        searchRoom.onkeyup = function() {
            updateBookingList(0, pagination, searchUsername.value, searchRoom.value); 
        };

        updateBookingList(0, pagination, searchUsername.value, searchRoom.value); 
        
    });
}

function loadBookingFormData(room, user, disabledButton, roomDefault, userDefault) {
    var room = document.getElementById(room);
    var user = document.getElementById(user);
    
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
                room.appendChild(option);
            }
            
            ajaxRequest = getXMLHTTPRequest();
            ajaxRequest.open("POST", "include/ajaxGetUsers.php", true);
            ajaxRequest.onreadystatechange = response2;
            ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajaxRequest.send("userPerPage=1000000000");
            
            function response2() {
                if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                    var response2 = ajaxRequest.responseXML;
                    var users = response2.getElementsByTagName("user");
                    
                    for(var i = 0; i < users.length; i++) {
                        var option = document.createElement("option");
                        option.value = users[i].getElementsByTagName("username")[0].childNodes[0].nodeValue;
                        option.text = users[i].getElementsByTagName("username")[0].childNodes[0].nodeValue;
                        user.appendChild(option);
                    }
                    
                    document.getElementById(disabledButton).className = "btn waves-effect waves-light";
                    
                    if(roomDefault != null) room.value = roomDefault;
                    if(userDefault != null) user.value = userDefault;
                    
                    $('select').material_select();
                }
            }
        }
    }
    
}

function validateBookingCourse(id, label) {
    var course = document.getElementById(id);
    var courseLabel = document.getElementById(label);
    var pattern = /^[a-z\d\-\s]+$/i;
    var value = course.value;
    var result = pattern.exec(value);
    
    if(value == "") {
        course.className = "";
    }
    else if(result == null) {
        courseLabel.setAttribute("data-error", "Error");
        course.className = "invalid";
    }
    else {
        course.className = "valid";
    }
}

function validateBookingForm(roomId, userId, courseId, startId, endId, dateId, type1Id, type2Id, type3Id, modalId, formId, ajaxFile, id) {
    var room = document.getElementById(roomId);
    var user = document.getElementById(userId);
    var course = document.getElementById(courseId);
    var start = document.getElementById(startId);
    var end = document.getElementById(endId);
    var date = document.getElementById(dateId);
    var type1 = document.getElementById(type1Id);
    var type2 = document.getElementById(type2Id);
    var type3 = document.getElementById(type3Id);
    
    var dateValue = new Date(date.value);
    dateValue.setHours(0, -dateValue.getTimezoneOffset(), 0, 0);

    
    
    if(course.className == "valid" && date.value != "") {
        if(parseInt(start.value) < parseInt(end.value)) {
            var schedule = {
                room : room.value,
                day : dayMap[new Date(date.value).getDay()],
                course : course.value,
                start : start.value,
                end : parseInt(end.value) - 1
            }
            
            var data = {
                id : id == null? -1 : id,
                room : room.value,
                user : user.value,
                course : course.value,
                start : start.value,
                end : parseInt(end.value) - 1,
                date : dateValue.toISOString().slice(0, 10).replace('T', ' '),
                type : type1.checked ? "Make Up" : (type2.checked ? "Advance Make Up" : "Other")
            }
            
            
            var ajaxRequest = getXMLHTTPRequest();
            ajaxRequest.open("POST", "include/ajaxCheck.php", true);
            ajaxRequest.onreadystatechange = response;
            ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajaxRequest.send("schedule=" + JSON.stringify(schedule) + "&data=" + JSON.stringify(data));
            
            function response() {
                if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                    hasClash = ajaxRequest.responseXML.getElementsByTagName("clash")[0].childNodes[0].nodeValue;
                    if(hasClash == "false") {
                        ajaxRequest = getXMLHTTPRequest();
                        ajaxRequest.open("POST", ajaxFile, true);
                        ajaxRequest.onreadystatechange = response2;
                        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        ajaxRequest.send("data=" + JSON.stringify(data));
                        
                        function response2() {
                            if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                                console.log(ajaxRequest.responseText);
                                if(ajaxRequest.responseText == "true") {
                                    document.getElementById(formId).reset();
                                    
                                    updateBookingList(currentBookingPage, pagination, document.getElementById("search-booking-username").value, document.getElementById("search-booking-room").value);
                                    
                                    $('#' + modalId).closeModal();
                                    if(id != null) Materialize.toast('Booking modified successfully!', 2000);
                                    else Materialize.toast('Booking created successfully!', 2000);
                                    
                                }
                                else {
                                    if(id != null) Materialize.toast('Failed to modify booking!', 2000);
                                    else Materialize.toast('Failed to create booking!', 2000);
                                }
                            }
                        }
                        
                    }
                    else {
                        alert("Timing has clash!");
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

function updateBookingList(page, bookingPerPage, userSearch, roomSearch) {
    var ajaxRequest = getXMLHTTPRequest();
    ajaxRequest.open("POST", "include/ajaxGetBookings.php", true);
    ajaxRequest.onreadystatechange = response;
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.send("page=" + page + "&bookingPerPage=" + bookingPerPage + "&room=" + roomSearch + "&user=" + userSearch + "&like=true");
    
    var table = document.getElementById("booking-list-table-body");
    
    function response() {
        if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
            var response = ajaxRequest.responseXML;
            if(response == null) {table.innerHTML = ""; document.getElementById("booking-pagination-area").innerHTML = ""; return;}
            var pageRequired = response.getElementsByTagName("pageRequired")[0].childNodes[0].nodeValue;
            var bookings = response.getElementsByTagName("booking");
            
            table.innerHTML = "";
            
            for(var i = 0; i < bookings.length; i++) {
                var id = bookings[i].getElementsByTagName("id")[0].childNodes[0].nodeValue;
                var room = bookings[i].getElementsByTagName("room")[0].childNodes[0].nodeValue;
                var user = bookings[i].getElementsByTagName("user")[0].childNodes[0].nodeValue;
                var date = bookings[i].getElementsByTagName("date")[0].childNodes[0].nodeValue;
                var course = bookings[i].getElementsByTagName("course")[0].childNodes[0].nodeValue;
                var start = bookings[i].getElementsByTagName("start")[0].childNodes[0].nodeValue;
                var end = bookings[i].getElementsByTagName("end")[0].childNodes[0].nodeValue;
                var type = bookings[i].getElementsByTagName("type")[0].childNodes[0].nodeValue;
                
                var row = table.insertRow(i);
                var roomCell = row.insertCell(0);
                var userCell = row.insertCell(1);
                var dateCell = row.insertCell(2);
                var courseCell = row.insertCell(3);
                var startCell = row.insertCell(4);
                var endCell = row.insertCell(5);
                var optionCell = row.insertCell(6);
                
                var newDate = new Date(date);
                
                date = newDate.getDate() + " " + monthMap[newDate.getMonth()] + ", " + newDate.getFullYear();
                
                roomCell.innerHTML = room;
                userCell.innerHTML = user;
                dateCell.innerHTML = newDate.toDateString();
                courseCell.innerHTML = course;
                startCell.innerHTML = timeBlock[start];
                endCell.innerHTML = timeBlock[parseInt(end) + 1];
                
                
                //data-target=\"create-booking-modal\" // edit-booking-modal-trigger
                
                optionCell.innerHTML = "<div class=\"right\"><a onclick=\"showEditBooking('" + id + "', '" + room + "', '" + user + "', '" + date + "', '" + course + "', '" + start + "', '" + end + "', '" + type + "' )\" id=\"edit-booking-button-" + i + "\" class=\"waves-effect waves-light btn\">Edit Booking</a><a class=\"waves-effect waves-light btn\"  onclick=\"showDeleteBooking('" + id + "')\" id=\"delete-booking-button-" + i + "\">Delete Booking</a></div>";
                
            }
            
            if(page >= pageRequired) page = pageRequired - 1;
            else if(page < 0) page = 0;
            
            currentBookingPage = page;
            
            var searchUsername = document.getElementById("search-booking-username").value;
            var searchRoom = document.getElementById("search-booking-room").value;
            
            var paginationHTML = "<ul class=\"pagination\">";
            if(page - 1 < 0) paginationHTML = paginationHTML + "<li class=\"disabled\"><a href=\"#\"><i class=\"material-icons\">chevron_left</i></a></li>";
            else paginationHTML = paginationHTML + "<li onclick=\"updateBookingList(" + (page - 1) + ", " + pagination + ", '" + searchUsername + "', '" + searchRoom + "');\"><a href=\"#\"><i class=\"material-icons\">chevron_left</i></a></li>";
            
            for(var i = 0; i < pageRequired; i++) {
                if(i == page) paginationHTML = paginationHTML + "<li class=\"active\" onclick=\"updateBookingList(" + i + ", " + pagination + ", '" + searchUsername + "', '" + searchRoom + "');\"><a href=\"#\">" + (i + 1) + "</a></li>";
                else paginationHTML = paginationHTML + "<li onclick=\"updateBookingList(" + i + ", " + pagination + ", '" + searchUsername + "', '" + searchRoom + "');\"><a href=\"#\">" + (i + 1) + "</a></li>";
            }
            
            if(page + 1 >= pageRequired) paginationHTML = paginationHTML + "<li class=\"disabled\"><a href=\"#\"><i class=\"material-icons\">chevron_right</i></a></li>";
            else paginationHTML = paginationHTML + "<li onclick=\"updateBookingList(" + (page + 1) + ", " + pagination + ", '" + searchUsername + "', '" + searchRoom + "');\"><a href=\"#\"><i class=\"material-icons\">chevron_right</i></a></li>";
            
            paginationHTML = paginationHTML + "</ul>";
            
            document.getElementById("booking-pagination-area").innerHTML = "<div class=\"right\">" + paginationHTML + "</div>";
        }
        else {
            table.innerHTML = "";
            var row = table.insertRow(0);
            var cell = row.insertCell(0);
            cell.innerHTML = "Loading...";
        }
    }
}
    
function showEditBooking(id, room, user, date, course, start, end, type) {
    $('#edit-booking-modal').openModal();
    loadBookingFormData("edit-booking-room", "edit-booking-user", "edit-booking-button", room, user);
    
    document.getElementById("edit-booking-course").onchange = function() {validateBookingCourse("edit-booking-course", "edit-booking-course-label");};
    
    document.getElementById("edit-booking-button").onclick = function() {validateBookingForm("edit-booking-room", "edit-booking-user", "edit-booking-course", "edit-booking-start", "edit-booking-end", "edit-booking-date", "edit-booking-type-makeup", "edit-booking-type-advanced-makeup", "edit-booking-type-other", "edit-booking-modal", "edit-booking-form", "include/ajaxUpdateBooking.php", id);};

    document.getElementById("edit-booking-room").value = room;
    document.getElementById("edit-booking-user").value = user;
    document.getElementById("edit-booking-date").value = date;
    document.getElementById("edit-booking-course").value = course;
    document.getElementById("edit-booking-course").className = "valid";
    document.getElementById("edit-booking-start").value = start;
    document.getElementById("edit-booking-end").value = (parseInt(end) + 1).toString();
    if(type == "Make Up") document.getElementById("edit-booking-type-makeup").checked = "true";
    else if(type == "Advance Make Up") document.getElementById("edit-booking-type-advanced-makeup").checked = "true";
    else document.getElementById("edit-booking-type-other").checked = "true";

}

function showDeleteBooking(id) {
    $('#delete-booking-modal').openModal();
    
    document.getElementById("delete-booking-yes-button").onclick = function() {
        var ajaxRequest = getXMLHTTPRequest();
        ajaxRequest.open("POST", "include/ajaxDeleteBooking.php", true);
        ajaxRequest.onreadystatechange = response;
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxRequest.send("id=" + id);

        function response() {
                if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                    if(ajaxRequest.responseText == "true") {
                        updateBookingList(currentBookingPage, pagination, document.getElementById("search-booking-username").value, document.getElementById("search-booking-room").value);
                        $('#delete-booking-modal').closeModal();
                        Materialize.toast('Deleted booking!', 2000);
                    }
                    else {
                        Materialize.toast('Failed to delete booking!', 2000);
                    }
                }
        }
        
    };
    
}
