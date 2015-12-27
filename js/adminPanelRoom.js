
function getRoomsContent() {
    var temp = "<div class=\"row\">" + 
               "    <div class=\"col s12\"><h4>Rooms<h4><hr /></div>" +
               "    <div class=\"col s12\">" + 
               "        <button data-target=\"create-room-modal\" class=\"btn col s12 waves-effect waves-light create-room-modal-trigger\">Create Room</button>" + 
               "    </div>" +
               "    <div class=\"col s12\" >" +
               "        <table id=\"room-list-table\" class=\"responsive-table striped\">" +
               "            <thead>" +
               "                <tr><th colspan=\"4\">Room List</th></tr>" +
               "                <tr>" +
               "                    <th data-field=\"id\">ID</th>" +
               "                    <th data-field=\"campus\">Campus</th>" +
               "                    <th data-field=\"capacity\">Capacity</th>" +
               "                    <th data-field=\"type\">Type</th>" +
               "                    <th data-field=\"option\"><div class=\"col s8 right\"><input placeholder=\"Search Room\" id=\"search-room\" type=\"search\"></div></th>" +
               "                </tr>" +
               "            </thead><tbody id=\"room-list-table-body\"></tbody>" +
               "        </table>" +
               "    </div>" +
               "    <div id=\"room-pagination-area\"></div>" +
               "</div>";
    
    content.innerHTML = temp;
    
    $(".create-room-modal-trigger").leanModal({
        dismissible: true, // Modal can be dismissed by clicking outside of the modal
        opacity: .5, // Opacity of modal background
        in_duration: 300, // Transition in duration
        out_duration: 200, // Transition out duration
        ready: function() { }, // Callback for Modal open
        complete: function() { 
            document.getElementById("create-room-form").reset();
        }
    });
    
    document.getElementById("room-id").onchange = function() {validateRoomId("room-id", "room-id-label");};
    document.getElementById("room-floor").onchange = function() {validateRoomFloor("room-floor", "room-floor-label");};
    document.getElementById("room-campus").onchange = function() {validateRoomCampus("room-campus", "room-campus-label");};
    document.getElementById("room-capacity").onchange = function() {validateRoomCapacity("room-capacity", "room-capacity-label");};
    document.getElementById("create-room-button").onclick = function() {validateRoomForm("room-id", "room-floor", "room-campus", "room-capacity", "room-type", "create-room-form");};
    
    
    var search = document.getElementById("search-room");
    search.onkeyup = function() {
        updateRoomList(0, pagination, search.value); 
    };
    
    updateRoomList(0, pagination, search.value);
    
}

function validateRoomId(id, label, old) {
    var room = document.getElementById(id);
    var roomLabel = document.getElementById(label);
    var pattern = /^[a-z\d\-\s]+$/i;
    var value = room.value;
    var result = pattern.exec(value);
    
    var ajaxRequest = getXMLHTTPRequest();
    
    if(value == "") {
        room.className = "";
    }
    else if(old != null && value == old) {
        room.className = "valid";
    }
    else if(result == null) {
        roomLabel.setAttribute("data-error", "Error");
        room.className = "invalid";
    }
    else {
        ajaxRequest.open("POST", "include/ajaxCheck.php", true);
        ajaxRequest.onreadystatechange = response;
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxRequest.send("roomId=" + value);
        
        function response() {
            if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                console.log(ajaxRequest.responseText);
                var roomIdTaken = ajaxRequest.responseXML.getElementsByTagName("roomId")[0].childNodes[0].nodeValue;
                if(roomIdTaken == "true") {
                    roomLabel.setAttribute("data-error", "Taken");
                    room.className = "invalid";
                }
                else {
                    roomLabel.setAttribute("data-error", "Error");
                    room.className = "valid";
                }
            }
        }
    }
}

function validateRoomFloor(id, label, old) {
    var floor = document.getElementById(id);
    var floorLabel = document.getElementById(label);
    var pattern = /^[0-9]+$/i;
    var value = floor.value;
    var result = pattern.exec(value);
    
    if(value == "") {
        floor.className = "";
    }
    else if(old != null && value == old) {
        floor.className = "valid";
    }
    else if(result == null) {
        floorLabel.setAttribute("data-error", "Error");
        floor.className = "invalid";
    }
    else {
        floor.className = "valid";
    }
}

function validateRoomCampus(id, label, old) {
    var campus = document.getElementById(id);
    var campusLabel = document.getElementById(label);
    var pattern = /^[0-9]+$/i;
    var value = campus.value;
    var result = pattern.exec(value);
    
    if(value == "") {
        campus.className = "";
    }
    else if(old != null && value == old) {
        campus.className = "valid";
    }
    else if(result == null) {
        campusLabel.setAttribute("data-error", "Error");
        campus.className = "invalid";
    }
    else {
        campus.className = "valid";
    }
}

function validateRoomCapacity(id, label, old) {
    var capacity = document.getElementById(id);
    var capacityLabel = document.getElementById(label);
    var pattern = /^[0-9]+$/i;
    var value = capacity.value;
    var result = pattern.exec(value);
    
    if(value == "") {
        capacity.className = "";
    }
    else if(old != null && value == old) {
        capacity.className = "valid";
    }
    else if(result == null) {
        capacityLabel.setAttribute("data-error", "Error");
        capacity.className = "invalid";
    }
    else {
        capacity.className = "valid";
    }
}

function validateRoomForm(id, floor, campus, capacity, type, form) {
    id = document.getElementById(id);
    floor = document.getElementById(floor);
    campus = document.getElementById(campus);
    capacity = document.getElementById(capacity);
    type = document.getElementById(type);
    form = document.getElementById(form);
    
    var ajaxRequest = getXMLHTTPRequest();
    
    if(id.className == "valid" && floor.className == "valid" && capacity.className == "valid" && campus.className == "valid") {
        var data = {
            id : id.value,
            floor : floor.value,
            campus : campus.value,
            capacity : capacity.value,
            type : type.options[type.selectedIndex].text
        }
        
        ajaxRequest.open("POST", "include/ajaxRegisterRoom.php", true);
        ajaxRequest.onreadystatechange = response;
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxRequest.send("data=" + JSON.stringify(data));
        
        function response() {
            if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                console.log(ajaxRequest.responseText);
                if(ajaxRequest.responseText == "true") {
                    form.reset();
                    
                    updateRoomList(currentRoomPage, pagination, document.getElementById("search-room").value);
                    
                    $('#create-room-modal').closeModal();
                    Materialize.toast('Room created successfully!', 2000);
                }
                else {
                    Materialize.toast('Failed to create room!', 2000);
                }
            }
        }
        
    }
}

function updateRoomList(page, roomPerPage, room) {
    var ajaxRequest = getXMLHTTPRequest();
    ajaxRequest.open("POST", "include/ajaxGetRooms.php", true);
    ajaxRequest.onreadystatechange = response;
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.send("page=" + page + "&roomPerPage=" + roomPerPage + "&room=" + room);
    
    var table = document.getElementById("room-list-table-body");
    
    function response() {
        if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
            var response = ajaxRequest.responseXML;
            if(response == null) {table.innerHTML = ""; document.getElementById("room-pagination-area").innerHTML = ""; return;}
            var pageRequired = response.getElementsByTagName("pageRequired")[0].childNodes[0].nodeValue;
            var rooms = response.getElementsByTagName("room");
            
            table.innerHTML = "";
            
            for(var i = 0; i < rooms.length; i++) {
                var id = rooms[i].getElementsByTagName("id")[0].childNodes[0].nodeValue;
                var campus = rooms[i].getElementsByTagName("campus")[0].childNodes[0].nodeValue;
                var capacity = rooms[i].getElementsByTagName("capacity")[0].childNodes[0].nodeValue;
                var type = rooms[i].getElementsByTagName("type")[0].childNodes[0].nodeValue;
                
                var row = table.insertRow(i);
                var idCell = row.insertCell(0);
                var campusCell = row.insertCell(1);
                var capacityCell = row.insertCell(2);
                var typeCell = row.insertCell(3);
                var optionCell = row.insertCell(4);
                
                idCell.innerHTML = id;
                campusCell.innerHTML = campus;
                capacityCell.innerHTML = capacity;
                typeCell.innerHTML = type;
                
                optionCell.innerHTML = "<div class=\"right\"><a class=\"waves-effect waves-light btn\" onclick=\"return showEditRoom('" + id  + "');\">Edit Room</a><a class=\"waves-effect waves-light btn\" onclick=\"return showDeleteRoom('" + id  + "');\">Delete Room</a></div>";
            }
            
            if(page >= pageRequired) page = pageRequired - 1;
            else if(page < 0) page = 0;
            
            currentRoomPage = page;
            
            var search = document.getElementById("search-room");
            var paginationHTML = "<ul class=\"pagination\">";
            if(page - 1 < 0) paginationHTML = paginationHTML + "<li class=\"disabled\"><a href=\"#\"><i class=\"material-icons\">chevron_left</i></a></li>";
            else paginationHTML = paginationHTML + "<li onclick=\"updateRoomList(" + (page - 1) + ", " + pagination + ", '" + search.value + "');\"><a href=\"#\"><i class=\"material-icons\">chevron_left</i></a></li>";
            
            for(var i = 0; i < pageRequired; i++) {
                if(i == page) paginationHTML = paginationHTML + "<li class=\"active\" onclick=\"updateRoomList(" + i + ", " + pagination + ", '" + search.value + "');\"><a href=\"#\">" + (i + 1) + "</a></li>";
                else paginationHTML = paginationHTML + "<li onclick=\"updateRoomList(" + i + ", " + pagination + ", '" + search.value + "');\"><a href=\"#\">" + (i + 1) + "</a></li>";
            }
            
            if(page + 1 >= pageRequired) paginationHTML = paginationHTML + "<li class=\"disabled\"><a href=\"#\"><i class=\"material-icons\">chevron_right</i></a></li>";
            else paginationHTML = paginationHTML + "<li onclick=\"updateRoomList(" + (page + 1) + ", " + pagination + ", '" + search.value + "');\"><a href=\"#\"><i class=\"material-icons\">chevron_right</i></a></li>";
            
            paginationHTML = paginationHTML + "</ul>";
            
            document.getElementById("room-pagination-area").innerHTML = "<div class=\"right\">" + paginationHTML + "</div>";
        }
        else {
            table.innerHTML = "";
            var row = table.insertRow(0);
            var cell = row.insertCell(0);
            cell.innerHTML = "Loading...";
        }
    }
    
}

function showEditRoom(room) {
    var ajaxRequest = getXMLHTTPRequest();
    ajaxRequest.open("POST", "include/ajaxGetRooms.php", true);
    ajaxRequest.onreadystatechange = response;
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.send("room=" + room + "&single=true");
    
    function response() {
        if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
            $('#update-room-modal').openModal();
            
            var response = ajaxRequest.responseXML;
            var currentRoom = response.getElementsByTagName("room")[0];
            
            var id = document.getElementById("update-room-id");
            var floor = document.getElementById("update-room-floor");
            var campus = document.getElementById("update-room-campus");
            var capacity = document.getElementById("update-room-capacity");
            var type = document.getElementById("update-room-type");
            var save = document.getElementById("update-room-save-button");
            
            id.className = "valid";
            floor.className = "valid";
            campus.className = "valid";
            capacity.className = "valid";
            
            var oldId = currentRoom.childNodes[0].childNodes[0].nodeValue;
            var oldFloor = currentRoom.childNodes[1].childNodes[0].nodeValue;
            var oldCampus = currentRoom.childNodes[2].childNodes[0].nodeValue;
            var oldCapacity = currentRoom.childNodes[3].childNodes[0].nodeValue;
            var oldType = currentRoom.childNodes[4].childNodes[0].nodeValue;
            
            id.value = currentRoom.childNodes[0].childNodes[0].nodeValue;
            floor.value = currentRoom.childNodes[1].childNodes[0].nodeValue;
            campus.value = currentRoom.childNodes[2].childNodes[0].nodeValue;
            capacity.value = currentRoom.childNodes[3].childNodes[0].nodeValue;
            
            id.onchange = function() {validateRoomId("update-room-id","update-room-id-label", oldId);};
            floor.onchange = function() {validateRoomFloor("update-room-floor", "update-room-floor-label");};
            campus.onchange = function() {validateRoomCampus("update-room-campus", "update-room-campus-label");};
            capacity.onchange = function() {validateRoomCapacity("update-room-capacity", "update-room-capacity-label");};
            
            for(var i = 0; i < type.length; i++) {
                if(type.options[i].text == currentRoom.childNodes[4].childNodes[0].nodeValue) {
                    type.selectedIndex = i;
                    $('select').material_select();
                    break;
                }
            }
            
            save.onclick = function() {
                if(id.className == "valid" && floor.className == "valid" && campus.className == "valid" && capacity.className == "valid") {
                    var data = {
                        id : id.value,
                        floor : floor.value,
                        campus : campus.value,
                        capacity : capacity.value,
                        type : type.options[type.selectedIndex].text
                    }
                    
                    ajaxRequest = getXMLHTTPRequest();
                    ajaxRequest.open("POST", "include/ajaxUpdateRoom.php", true);
                    ajaxRequest.onreadystatechange = response2;
                    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    ajaxRequest.send("data=" + JSON.stringify(data) + "&old=" + oldId);

                    function response2() {
                        if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                            console.log(ajaxRequest.responseText);
                            if(ajaxRequest.responseText == "true") {
                                document.getElementById("update-room-form").reset();
                                    
                                updateRoomList(currentRoomPage, pagination, document.getElementById("search-room").value);

                                $('#update-room-modal').closeModal();
                                Materialize.toast('Room modified successfully!', 2000);
                            }
                            else {
                                Materialize.toast('Failed to modify room!', 2000);
                            }
                        }
                    }
                }
                else {
                    alert("Please fix the errors!");
                }
            };
            
        }
    }
    
}

function showDeleteRoom(room) {
    $('#delete-room-modal').openModal();
    var button = document.getElementById("room-delete-yes-button");
    
    button.onclick = function() {
        var ajaxRequest = getXMLHTTPRequest();
        ajaxRequest.open("POST", "include/ajaxDeleteRoom.php", true);
        ajaxRequest.onreadystatechange = response;
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxRequest.send("room=" + room);

        function response() {
                if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                    if(ajaxRequest.responseText == "true") {
                        updateRoomList(currentRoomPage, pagination, document.getElementById("search-room").value);
                        $('#delete-room-modal').closeModal();
                        Materialize.toast('Deleted room!', 2000);
                    }
                    else {
                        Materialize.toast('Failed to delete room!', 2000);
                    }
                }
        }
        
    };
    
    
}
