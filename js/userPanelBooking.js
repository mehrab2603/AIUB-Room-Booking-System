function getBookingsContent() {
    $("#" + contentId).load(htmlContent + "user_booking.html", function() {
        
        $(".create-booking-modal-trigger").leanModal({
            dismissible: true, // Modal can be dismissed by clicking outside of the modal
            opacity: .5, // Opacity of modal background
            in_duration: 300, // Transition in duration
            out_duration: 200, // Transition out duration
            ready: function() { 
                loadBookingFormData("create-booking-room", "create-booking-button");
            }, // Callback for Modal open
            complete: function() { 
                document.getElementById("create-booking-form").reset();
            }
        });
        
        document.getElementById("create-booking-course").onchange = function() {validateBookingCourse("create-booking-course", "create-booking-course-label");};
        document.getElementById("create-booking-button").onclick = function() {validateBookingForm("create-booking-room", "create-booking-course", "create-booking-start", "create-booking-end", "create-booking-date", "create-booking-type-makeup", "create-booking-type-advanced-makeup", "create-booking-type-other", "create-booking-modal", "create-booking-form", "include/ajaxRegisterBooking.php");};
        
        var bookingFilter = document.getElementById("booking-filter");
        bookingFilter.onchange = function() {
            updateBookingList(0, pagination, bookingFilter.value); 
        };
        updateBookingList(0, pagination, bookingFilter.value); 
        
        $(".report-booking-modal-trigger").leanModal({
            dismissible: true, // Modal can be dismissed by clicking outside of the modal
            opacity: .5, // Opacity of modal background
            in_duration: 300, // Transition in duration
            out_duration: 200, // Transition out duration
            ready: function() {
                var reportContent = document.getElementById("report-content");
                reportContent.innerHTML = "";
                
                var header = document.createElement("h5");
                header.style.textAlign = "center";
                header.innerHTML = "Room Booking Report of " + userInfo["username"];
                
                reportContent.appendChild(header);
                reportContent.appendChild(document.createElement("hr"));
                
                var ajaxRequest = getXMLHTTPRequest();
                ajaxRequest.open("POST", "include/ajaxBookingReport.php", true);
                ajaxRequest.onreadystatechange = response;
                ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                
                var dateValue = new Date();
                dateValue.setHours(0, -dateValue.getTimezoneOffset(), 0, 0);
                var date = dateValue.toISOString().slice(0, 10).replace('T', ' ');
                
                ajaxRequest.send("date=" + date + "&user=" + userInfo["username"]);
                
                function response() {
                    if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                        var response = ajaxRequest.responseXML;
                        var expiredBookings = response.getElementsByTagName("expired")[0].getElementsByTagName("booking");
                        var validBookings = response.getElementsByTagName("valid")[0].getElementsByTagName("booking");
                        
                        var statisticsTable = document.createElement("table");
                        statisticsTable.style.border = "1px solid black";
                        
                        statisticsTable.innerHTML = "<thead><tr><th colspan=\"2\" style=\"text-align:center;\">Statistics</th></tr></thead>";
                        
                        var statisticsTableBody = document.createElement("tbody");
                        
                        var totalRow = statisticsTableBody.insertRow(0);
                        var totalTextCell = totalRow.insertCell(0);
                        var totalValueCell = totalRow.insertCell(1);
                        totalTextCell.innerHTML = "Total Bookings";
                        totalValueCell.innerHTML = response.getElementsByTagName("total")[0].childNodes[0].nodeValue;
                        
                        var expiredRow = statisticsTableBody.insertRow(1);
                        var expiredTextCell = expiredRow.insertCell(0);
                        var expiredValueCell = expiredRow.insertCell(1);
                        expiredTextCell.innerHTML = "Expired Bookings";
                        expiredValueCell.innerHTML = response.getElementsByTagName("expiredCount")[0].childNodes[0].nodeValue;
                        
                        var validRow = statisticsTableBody.insertRow(2);
                        var validTextCell = validRow.insertCell(0);
                        var validValueCell = validRow.insertCell(1);
                        validTextCell.innerHTML = "Valid Bookings";
                        validValueCell.innerHTML = response.getElementsByTagName("validCount")[0].childNodes[0].nodeValue;
                        
                        statisticsTable.appendChild(statisticsTableBody);
                        reportContent.appendChild(statisticsTable);
                        
                        if(expiredValueCell.innerHTML != "0") {
                        
                        var expiredTable = document.createElement("table");
                        expiredTable.style.border = "1px solid black";
                        
                        expiredTable.innerHTML = "<thead><tr><th colspan=\"6\" style=\"text-align:center;\">Expired Bookings</th></tr><tr><th>Room</th><th>Date</th><th>Course</th><th>From</th><th>To</th><th>Type</th></tr></thead>";
                        
                        var expiredTableBody = document.createElement("tbody");
                        
                            for(var i = 0; i < expiredBookings.length; i++) {
                                var room = expiredBookings[i].getElementsByTagName("room")[0].childNodes[0].nodeValue;
                                var date = expiredBookings[i].getElementsByTagName("date")[0].childNodes[0].nodeValue;
                                var course = expiredBookings[i].getElementsByTagName("course")[0].childNodes[0].nodeValue;
                                var start = expiredBookings[i].getElementsByTagName("start")[0].childNodes[0].nodeValue;
                                var end = expiredBookings[i].getElementsByTagName("end")[0].childNodes[0].nodeValue;
                                var type = expiredBookings[i].getElementsByTagName("type")[0].childNodes[0].nodeValue;

                                var row = expiredTableBody.insertRow(i);
                                var roomCell = row.insertCell(0);
                                var dateCell = row.insertCell(1);
                                var courseCell = row.insertCell(2);
                                var startCell = row.insertCell(3);
                                var endCell = row.insertCell(4);
                                var typeCell = row.insertCell(5);

                                var newDate = new Date(date);

                                roomCell.innerHTML = room;
                                dateCell.innerHTML = newDate.toDateString();
                                courseCell.innerHTML = course;
                                startCell.innerHTML = timeBlock[start];
                                endCell.innerHTML = timeBlock[parseInt(end) + 1];
                                typeCell.innerHTML = type;

                            }

                            expiredTable.appendChild(expiredTableBody);
                            reportContent.appendChild(expiredTable);
                        }
                        
                        if(validValueCell.innerHTML != "0") {
                        
                            var validTable = document.createElement("table");
                            validTable.style.border = "1px solid black";

                            validTable.innerHTML = "<thead><tr><th colspan=\"6\" style=\"text-align:center;\">Valid Bookings</th></tr><tr><th>Room</th><th>Date</th><th>Course</th><th>From</th><th>To</th><th>Type</th></tr></thead>";

                            var validTableBody = document.createElement("tbody");

                            for(var i = 0; i < validBookings.length; i++) {
                                var room = validBookings[i].getElementsByTagName("room")[0].childNodes[0].nodeValue;
                                var date = validBookings[i].getElementsByTagName("date")[0].childNodes[0].nodeValue;
                                var course = validBookings[i].getElementsByTagName("course")[0].childNodes[0].nodeValue;
                                var start = validBookings[i].getElementsByTagName("start")[0].childNodes[0].nodeValue;
                                var end = validBookings[i].getElementsByTagName("end")[0].childNodes[0].nodeValue;
                                var type = validBookings[i].getElementsByTagName("type")[0].childNodes[0].nodeValue;

                                var row = validTableBody.insertRow(i);
                                var roomCell = row.insertCell(0);
                                var dateCell = row.insertCell(1);
                                var courseCell = row.insertCell(2);
                                var startCell = row.insertCell(3);
                                var endCell = row.insertCell(4);
                                var typeCell = row.insertCell(5);

                                var newDate = new Date(date);

                                roomCell.innerHTML = room;
                                dateCell.innerHTML = newDate.toDateString();
                                courseCell.innerHTML = course;
                                startCell.innerHTML = timeBlock[start];
                                endCell.innerHTML = timeBlock[parseInt(end) + 1];
                                typeCell.innerHTML = type;

                            }

                            validTable.appendChild(validTableBody);
                            reportContent.appendChild(validTable);
                            reportContent.appendChild(document.createElement("br"));
                            
                            var footer = document.createElement("div");
                            footer.className = "row";
                            
                            var pdfButton = document.createElement("a");
                            pdfButton.className = "waves-effect waves-light btn col s12";
                            pdfButton.innerHTML = "Download Report";
                            pdfButton.id = "download-button";
                            
                            pdfButton.onclick = function() {
                                var doc = new jsPDF();          
                                var elementHandler = {
                                    '#download-button': function (element, renderer) {
                                        return true;
                                    }
                                };
                                
                                var source = reportContent;
                                doc.fromHTML(
                                    source,
                                    15,
                                    15,
                                    {
                                        'width': 180,'elementHandlers': elementHandler
                                    }
                                );
                                $("report-booking-modal").closeModal();

                                doc.output("dataurlnewwindow");
                                
                                
                            };
                            
                            footer.appendChild(pdfButton);
                            reportContent.appendChild(footer);
                            
                        }
                        
                        
                    }
                }
                
            }, // Callback for Modal open
            complete: function() { 
                
            }
        });
        
        $('select').material_select();
        $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 15 // Creates a dropdown of 15 years to control year
          });
    });
}


function loadBookingFormData(roomId, disabledButton, roomDefault) {
    var room = document.getElementById(roomId);
    
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
            
            document.getElementById(disabledButton).className = "btn waves-effect waves-light";
                    
            if(roomDefault != null) room.value = roomDefault;

            $('select').material_select();
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


function validateBookingForm(roomId, courseId, startId, endId, dateId, type1Id, type2Id, type3Id, modalId, formId, ajaxFile, id) {
    var room = document.getElementById(roomId);
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
                user : userInfo["username"],
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
                                    
                                    updateBookingList(currentBookingPage, pagination, document.getElementById("booking-filter").value);
                                    
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


function updateBookingList(page, bookingPerPage, bookingFilter) {
    var ajaxRequest = getXMLHTTPRequest();
    ajaxRequest.open("POST", "include/ajaxGetBookings.php", true);
    ajaxRequest.onreadystatechange = response;
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    var today = new Date();
    today.setHours(0, -today.getTimezoneOffset(), 0, 0);
    today = today.toISOString().slice(0, 10).replace('T', ' ');
    
    
    if(bookingFilter == "0") ajaxRequest.send("page=" + page + "&bookingPerPage=" + bookingPerPage + "&user=" + userInfo["username"]);
    else if(bookingFilter == "1") ajaxRequest.send("page=" + page + "&bookingPerPage=" + bookingPerPage + "&user=" + userInfo["username"] + "&date=" + today + "&expired=false");
    else if(bookingFilter == "2") ajaxRequest.send("page=" + page + "&bookingPerPage=" + bookingPerPage + "&user=" + userInfo["username"] + "&date=" + today + "&expired=true");
    
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
                var date = bookings[i].getElementsByTagName("date")[0].childNodes[0].nodeValue;
                var course = bookings[i].getElementsByTagName("course")[0].childNodes[0].nodeValue;
                var start = bookings[i].getElementsByTagName("start")[0].childNodes[0].nodeValue;
                var end = bookings[i].getElementsByTagName("end")[0].childNodes[0].nodeValue;
                var type = bookings[i].getElementsByTagName("type")[0].childNodes[0].nodeValue;
                
                var row = table.insertRow(i);
                var roomCell = row.insertCell(0);
                var dateCell = row.insertCell(1);
                var courseCell = row.insertCell(2);
                var startCell = row.insertCell(3);
                var endCell = row.insertCell(4);
                var optionCell = row.insertCell(5);
                
                var newDate = new Date(date);
                
                date = newDate.getDate() + " " + monthMap[newDate.getMonth()] + ", " + newDate.getFullYear();
                
                today = new Date();
                today.setHours(0, -today.getTimezoneOffset(), 0, 0);
                
                var isExpired = today >= newDate ? true : false;
                
                roomCell.innerHTML = room;
                dateCell.innerHTML = newDate.toDateString();
                courseCell.innerHTML = course;
                startCell.innerHTML = timeBlock[start];
                endCell.innerHTML = timeBlock[parseInt(end) + 1];
                
                if(!isExpired) {
                    
                    optionCell.innerHTML = "<div class=\"right\"><a onclick=\"showEditBooking('" + id + "', '" + room + "', '" + date + "', '" + course + "', '" + start + "', '" + end + "', '" + type + "' )\" id=\"edit-booking-button-" + i + "\" class=\"waves-effect waves-light btn\">Edit Booking</a><a class=\"waves-effect waves-light btn\"  onclick=\"showDeleteBooking('" + id + "')\" id=\"delete-booking-button-" + i + "\">Delete Booking</a></div>";
                    
                }
                
            }
            
            if(page >= pageRequired) page = pageRequired - 1;
            else if(page < 0) page = 0;
            
            currentBookingPage = page;
            
            var filterValue = document.getElementById("booking-filter").value;
            
            var paginationHTML = "<ul class=\"pagination\">";
            if(page - 1 < 0) paginationHTML = paginationHTML + "<li class=\"disabled\"><a href=\"#\"><i class=\"material-icons\">chevron_left</i></a></li>";
            else paginationHTML = paginationHTML + "<li onclick=\"updateBookingList(" + (page - 1) + ", " + pagination + ", '" + filterValue + "');\"><a href=\"#\"><i class=\"material-icons\">chevron_left</i></a></li>";
            
            for(var i = 0; i < pageRequired; i++) {
                if(i == page) paginationHTML = paginationHTML + "<li class=\"active\" onclick=\"updateBookingList(" + i + ", " + pagination + ", '" + filterValue + "');\"><a href=\"#\">" + (i + 1) + "</a></li>";
                else paginationHTML = paginationHTML + "<li onclick=\"updateBookingList(" + i + ", " + pagination + ", '" + filterValue + "');\"><a href=\"#\">" + (i + 1) + "</a></li>";
            }
            
            if(page + 1 >= pageRequired) paginationHTML = paginationHTML + "<li class=\"disabled\"><a href=\"#\"><i class=\"material-icons\">chevron_right</i></a></li>";
            else paginationHTML = paginationHTML + "<li onclick=\"updateBookingList(" + (page + 1) + ", " + pagination + ", '" + filterValue + "');\"><a href=\"#\"><i class=\"material-icons\">chevron_right</i></a></li>";
            
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



function showEditBooking(id, room, date, course, start, end, type) {
    $('#edit-booking-modal').openModal();
    loadBookingFormData("edit-booking-room", "edit-booking-button", room);
    
    document.getElementById("edit-booking-course").onchange = function() {validateBookingCourse("edit-booking-course", "edit-booking-course-label");};
    
    document.getElementById("edit-booking-button").onclick = function() {validateBookingForm("edit-booking-room", "edit-booking-course", "edit-booking-start", "edit-booking-end", "edit-booking-date", "edit-booking-type-makeup", "edit-booking-type-advanced-makeup", "edit-booking-type-other", "edit-booking-modal", "edit-booking-form", "include/ajaxUpdateBooking.php", id);};

    document.getElementById("edit-booking-room").value = room;
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
                        updateBookingList(currentBookingPage, pagination, document.getElementById("booking-filter").value);
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