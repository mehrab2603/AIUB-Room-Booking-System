var bookingOrder = function() {
    var obj = [];
    return {
        indexOfItem : function(criteria) {
            for(var i = 0; i < obj.length; i++) {
                if(obj[i] == criteria) return i;
            }
            return -1;
        },
        pushItem : function(criteria, mode) {
            obj.push([criteria, mode]);
        },
        removeItem : function(index) {
            obj.splice(index, 1);
        },
        updateItem : function(index, mode) {
            obj[i] = value;
        },
        getArray : function() {
            return obj;
        },
        clearArray : function() {
            obj.splice(0, obj.length);
        }
    }
}();

var bookingSearchParameters = {
    room : null,
    user : null,
    course : null,
    start : null,
    end : null,
    date : null,
    type : null,
    dateRange : null
};


function getBookingsContent() {
    
    $("#" + contentId).load( htmlContent + "admin_booking_static.html", function() {
        
        $('select').material_select();
        $(".button-collapse").sideNav();
        $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 15 // Creates a dropdown of 15 years to control year
          });
        
        
        $(".search-booking-modal-trigger").leanModal({
            dismissible: true, // Modal can be dismissed by clicking outside of the modal
            opacity: .5, // Opacity of modal background
            in_duration: 300, // Transition in duration
            out_duration: 200, // Transition out duration
            ready: function() {
                document.getElementById("search-booking-date-from").value = new Date().toDateString();
                document.getElementById("search-booking-date-to").value = new Date().toDateString();
                loadBookingFormData("search-booking-room", "search-booking-user", "search-booking-search-button", null, null, true);
            }, // Callback for Modal open
            complete: function() { 
                document.getElementById("create-booking-form").reset();
            }
        });
        
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
        
        $(".sort-booking-modal-trigger").leanModal({
            dismissible: true, // Modal can be dismissed by clicking outside of the modal
            opacity: .5, // Opacity of modal background
            in_duration: 300, // Transition in duration
            out_duration: 200, // Transition out duration
            ready: function() { 
                //addRow(table);
            }, // Callback for Modal open
            complete: function() { 
                //document.getElementById("create-room-form").reset();
            }
        });
        
        
        document.getElementById("create-booking-course").onchange = function() {validateBookingCourse("create-booking-course", "create-booking-course-label");};
        document.getElementById("create-booking-button").onclick = function() {validateBookingForm("create-booking-room", "create-booking-user", "create-booking-course", "create-booking-start", "create-booking-end", "create-booking-date", "create-booking-type-makeup", "create-booking-type-advanced-makeup", "create-booking-type-other", "create-booking-modal", "create-booking-form", "include/ajaxRegisterBooking.php");};
        
        
        //performRoomSearch(room, user, course, startTime, endTime, startDate, endDate, type1, type2, type3)
        document.getElementById("search-booking-search-button").onclick = function() {performBookingSearch("search-booking-room", "search-booking-user", "search-booking-course", "search-booking-start", "search-booking-end", "search-date-check", "search-booking-date-from", "search-booking-date-to", "search-booking-type");};
        
        
        var table = document.getElementById("booking-sort-criteria-table");
        var addCriteriaButton = document.getElementById("booking-add-sort");
        var deleteCriteriaButton = document.getElementById("booking-delete-sort");
        
        addCriteriaButton.onclick = function() {
            var row = table.insertRow(-1);
            var col1 = row.insertCell(-1);
            var col2 = row.insertCell(-1);
            var col3 = row.insertCell(-1);

            col1.innerHTML = "Criteria";

            var criteriaSelect = document.createElement("select");
            criteriaSelect.id = "criteria-select-" + table.rows.length;
            
            
            var roomOption = document.createElement("option");
            roomOption.value = "room";
            roomOption.innerHTML = "Room";
            
            var userOption = document.createElement("option");
            userOption.value = "user";
            userOption.innerHTML = "User";
            
            var courseOption = document.createElement("option");
            courseOption.value = "course";
            courseOption.innerHTML = "Course";
            
            var startOption = document.createElement("option");
            startOption.value = "start";
            startOption.innerHTML = "Start";
            
            var endOption = document.createElement("option");
            endOption.value = "end";
            endOption.innerHTML = "End";
            
            var dateOption = document.createElement("option");
            dateOption.value = "date";
            dateOption.innerHTML = "Date";
            
            var typeOption = document.createElement("option");
            typeOption.value = "type";
            typeOption.innerHTML = "Type";

            criteriaSelect.appendChild(roomOption);
            criteriaSelect.appendChild(userOption);
            criteriaSelect.appendChild(courseOption);
            criteriaSelect.appendChild(startOption);
            criteriaSelect.appendChild(endOption);
            criteriaSelect.appendChild(dateOption);
            criteriaSelect.appendChild(typeOption);

            col2.appendChild(criteriaSelect);
            
            col3.innerHTML = "<input name=\"radioMode-" + table.rows.length + "\" type=\"radio\" id=\"asc-" + table.rows.length + "\" checked /><label for=\"asc-" + table.rows.length + "\">Ascending</label><input name=\"radioMode-" + table.rows.length + "\" type=\"radio\" id=\"desc-" + table.rows.length + "\" /><label for=\"desc-" + table.rows.length + "\" >Descending</label>";
            
            if(table.rows.length >= 7) addCriteriaButton.className = "btn disabled";
            deleteCriteriaButton.className = "btn waves-effect waves-light";
            
            $("select").material_select();
        };

        deleteCriteriaButton.onclick = function() {
            if(table.rows.length > 0) table.deleteRow(table.rows.length -1);
            
            if(table.rows.length <= 0) deleteCriteriaButton.className = "btn disabled";
            addCriteriaButton.className = "btn waves-effect waves-light";
            
            $("select").material_select();
        };

        document.getElementById("booking-sort-criteria-button").onclick = function() {
            bookingOrder.clearArray();
            for(var i = 0; i < table.rows.length; i++) {
                var currentCritera = document.getElementById("criteria-select-"+(i+1)).value;
                var currentMode = table.rows[i].cells[2].childNodes[0].checked ? "ASC" : "DESC";
                
                if(roomOrder.indexOfItem(currentCritera) == -1) {
                    bookingOrder.pushItem(currentCritera, currentMode);
                }
            }
            updateBookingList(0, pagination);
            $('#sort-booking-modal').closeModal();
        };
        
        
        document.getElementById("booking-reset-button").onclick = function() {
            bookingOrder.clearArray();
            
            bookingSearchParameters["room"] = null;
            bookingSearchParameters["user"] = null;
            bookingSearchParameters["course"] = null;
            bookingSearchParameters["start"] = null;
            bookingSearchParameters["end"] = null;
            bookingSearchParameters["type"] = null;
            bookingSearchParameters["dateRange"] = null;
            
            updateBookingList(0, pagination);
            
        };


        updateBookingList(0, pagination); 
        
    });
}

function loadBookingFormData(room, user, disabledButton, roomDefault, userDefault, any) {
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
            
            if(any) {
                var defaultRoomOption = document.createElement("option");
                defaultRoomOption.value = "Any";
                defaultRoomOption.text = "Any";
                //defaultRoomOption.selected = true;
                room.appendChild(defaultRoomOption);
                room.value = "Any";
            }
            
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
                    
                    if(any) {
                        var defaultUserOption = document.createElement("option");
                        defaultUserOption.value = "Any";
                        defaultUserOption.text = "Any";
                        //defaultUserOption.selected = true;
                        user.appendChild(defaultUserOption);
                        user.value = "Any";
                    }
                    
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
                                    
                                    updateBookingList(currentBookingPage, pagination);
                                    
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

function updateBookingList(page, bookingPerPage) {
    var ajaxRequest = getXMLHTTPRequest();
    ajaxRequest.open("POST", "include/ajaxGetBookings.php", true);
    ajaxRequest.onreadystatechange = response;
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    var bookingPostString = "page=" + page + "&bookingPerPage=" + bookingPerPage + "&like=true&order=" + JSON.stringify(bookingOrder.getArray());
    
    if(bookingSearchParameters["room"] != null) bookingPostString = bookingPostString + "&room=" + bookingSearchParameters["room"];
    if(bookingSearchParameters["user"] != null) bookingPostString = bookingPostString + "&user=" + bookingSearchParameters["user"];
    if(bookingSearchParameters["course"] != null) bookingPostString = bookingPostString + "&course=" + bookingSearchParameters["course"];
    if(bookingSearchParameters["start"] != null) bookingPostString = bookingPostString + "&start=" + bookingSearchParameters["start"];
    if(bookingSearchParameters["end"] != null) bookingPostString = bookingPostString + "&end=" + bookingSearchParameters["end"];
    if(bookingSearchParameters["date"] != null) bookingPostString = bookingPostString + "&date=" + bookingSearchParameters["date"];
    if(bookingSearchParameters["type"] != null) bookingPostString = bookingPostString + "&type=" + bookingSearchParameters["type"];
    if(bookingSearchParameters["dateRange"] != null) bookingPostString = bookingPostString + "&dateRange=" + JSON.stringify(bookingSearchParameters["dateRange"]);
    
    
    
    ajaxRequest.send(bookingPostString);
    
    var table = document.getElementById("booking-list-table-body");
    
    function response() {
        if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
            //console.log(ajaxRequest.responseText);
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
                var typeCell = row.insertCell(6);
                var optionCell = row.insertCell(7);
                
                var newDate = new Date(date);
                
                date = newDate.getDate() + " " + monthMap[newDate.getMonth()] + ", " + newDate.getFullYear();
                
                roomCell.innerHTML = room;
                userCell.innerHTML = user;
                dateCell.innerHTML = newDate.toDateString();
                courseCell.innerHTML = course;
                startCell.innerHTML = timeBlock[start];
                endCell.innerHTML = timeBlock[parseInt(end) + 1];
                typeCell.innerHTML = type;
                
                //data-target=\"create-booking-modal\" // edit-booking-modal-trigger
                
                optionCell.innerHTML = "<a onclick=\"showEditBooking('" + id + "', '" + room + "', '" + user + "', '" + date + "', '" + course + "', '" + start + "', '" + end + "', '" + type + "' )\" id=\"edit-booking-button-" + i + "\" class=\"waves-effect waves-light btn\">Edit</a><a class=\"waves-effect waves-light btn\"  onclick=\"showDeleteBooking('" + id + "')\" id=\"delete-booking-button-" + i + "\">Delete</a>";
                
            }
            
            if(page >= pageRequired) page = pageRequired - 1;
            else if(page < 0) page = 0;
            
            currentBookingPage = page;
            
            
            var paginationHTML = "<ul class=\"pagination\">";
            if(page - 1 < 0) paginationHTML = paginationHTML + "<li class=\"disabled\"><a href=\"#\"><i class=\"material-icons\">chevron_left</i></a></li>";
            else paginationHTML = paginationHTML + "<li onclick=\"updateBookingList(" + (page - 1) + ", " + pagination + ");\"><a href=\"#\"><i class=\"material-icons\">chevron_left</i></a></li>";
            
            for(var i = 0; i < pageRequired; i++) {
                if(i == page) paginationHTML = paginationHTML + "<li class=\"active\" onclick=\"updateBookingList(" + i + ", " + pagination + ");\"><a href=\"#\">" + (i + 1) + "</a></li>";
                else paginationHTML = paginationHTML + "<li onclick=\"updateBookingList(" + i + ", " + pagination + ");\"><a href=\"#\">" + (i + 1) + "</a></li>";
            }
            
            if(page + 1 >= pageRequired) paginationHTML = paginationHTML + "<li class=\"disabled\"><a href=\"#\"><i class=\"material-icons\">chevron_right</i></a></li>";
            else paginationHTML = paginationHTML + "<li onclick=\"updateBookingList(" + (page + 1) + ", " + pagination + ");\"><a href=\"#\"><i class=\"material-icons\">chevron_right</i></a></li>";
            
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
                        updateBookingList(currentBookingPage, pagination);
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

function performBookingSearch(room, user, course, startTime, endTime, searchDateCheckBox, startDate, endDate, type) {
    room = document.getElementById(room).value == "Any" ? null : document.getElementById(room).value;
    user = document.getElementById(user).value == "Any" ? null : document.getElementById(user).value;
    course = document.getElementById(course).value == "" ? null : document.getElementById(course).value;
    startTime = document.getElementById(startTime).value == "0" ? null : document.getElementById(startTime).value;
    endTime = document.getElementById(endTime).value == "0" ? null : parseInt(document.getElementById(endTime).value) - 1;
    type = document.getElementById(type).value == "Any" ? null : document.getElementById(type).value;
    searchDateCheckBox = document.getElementById(searchDateCheckBox).checked;
    
    bookingSearchParameters["room"] = room;
    bookingSearchParameters["user"] = user;
    bookingSearchParameters["course"] = course;
    bookingSearchParameters["start"] = startTime;
    bookingSearchParameters["end"] = endTime;
    bookingSearchParameters["type"] = type;
    
    if(searchDateCheckBox) {
        startDate = document.getElementById(startDate).value;
        endDate = document.getElementById(endDate).value;

        var startDateValue = new Date(startDate);
        startDateValue.setHours(0, -startDateValue.getTimezoneOffset(), 0, 0);

        var endDateValue = new Date(endDate);
        endDateValue.setHours(0, -endDateValue.getTimezoneOffset(), 0, 0);

        startDateValue = startDateValue.toISOString().slice(0, 10).replace('T', ' ');
        endDateValue = endDateValue.toISOString().slice(0, 10).replace('T', ' ');

        bookingSearchParameters["dateRange"] = [startDateValue, endDateValue];
    }
    else {
        bookingSearchParameters["dateRange"] = null;
    }
    
    updateBookingList(0, pagination);
    
    $('#search-booking-modal').closeModal();
    
}

