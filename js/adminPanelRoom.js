var roomOrder = function() {
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

var roomSearchParameters = {
    id : null,
    floor : null,
    campus : null,
    capacity : null,
    type : null
};


function getRoomsContent() {
    $("#" + contentId).load( htmlContent + "admin_room_static.html", function() {
        $("select").material_select();
        
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
        
        $(".search-room-modal-trigger").leanModal({
            dismissible: true, // Modal can be dismissed by clicking outside of the modal
            opacity: .5, // Opacity of modal background
            in_duration: 300, // Transition in duration
            out_duration: 200, // Transition out duration
            ready: function() { 
                

            }, // Callback for Modal open
            complete: function() { 
                document.getElementById("room-sort-criteria-table").innerHTML = "";
            }
        });
        
        $(".sort-room-modal-trigger").leanModal({
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
        
        document.getElementById("room-id").onchange = function() {validateRoomId("room-id", "room-id-label");};
        document.getElementById("room-floor").onchange = function() {validateRoomFloor("room-floor", "room-floor-label");};
        document.getElementById("room-campus").onchange = function() {validateRoomCampus("room-campus", "room-campus-label");};
        document.getElementById("room-capacity").onchange = function() {validateRoomCapacity("room-capacity", "room-capacity-label");};
        document.getElementById("create-room-button").onclick = function() {validateRoomForm("room-id", "room-floor", "room-campus", "room-capacity", "room-type", "create-room-form");};

        updateRoomList(0, pagination);
        
        document.getElementById("search-room-search-button").onclick = function() {performRoomSearch("search-room-id", "search-room-floor", "search-room-campus", "search-room-capacity", "search-room-type", "search-room-modal");};
        
        var table = document.getElementById("room-sort-criteria-table");
        var addCriteriaButton = document.getElementById("room-add-sort");
        var deleteCriteriaButton = document.getElementById("room-delete-sort");

        addCriteriaButton.onclick = function() {
            var row = table.insertRow(-1);
            var col1 = row.insertCell(-1);
            var col2 = row.insertCell(-1);
            var col3 = row.insertCell(-1);

            col1.innerHTML = "Criteria";

            var criteriaSelect = document.createElement("select");
            criteriaSelect.id = "criteria-select-" + table.rows.length;
            var idOption = document.createElement("option");
            idOption.value = "id";
            idOption.innerHTML = "ID";

            var floorOption = document.createElement("option");
            floorOption.value = "floor";
            floorOption.innerHTML = "Floor";

            var campusOption = document.createElement("option");
            campusOption.value = "campus";
            campusOption.innerHTML = "Campus";

            var capacityOption = document.createElement("option");
            capacityOption.value = "capacity";
            capacityOption.innerHTML = "Capacity";

            var typeOption = document.createElement("option");
            typeOption.value = "type";
            typeOption.innerHTML = "Type";

            criteriaSelect.appendChild(idOption);
            criteriaSelect.appendChild(floorOption);
            criteriaSelect.appendChild(campusOption);
            criteriaSelect.appendChild(capacityOption);
            criteriaSelect.appendChild(typeOption);

            col2.appendChild(criteriaSelect);
            
            col3.innerHTML = "<input name=\"radioMode-" + table.rows.length + "\" type=\"radio\" id=\"asc-" + table.rows.length + "\" checked /><label for=\"asc-" + table.rows.length + "\">Ascending</label><input name=\"radioMode-" + table.rows.length + "\" type=\"radio\" id=\"desc-" + table.rows.length + "\" /><label for=\"desc-" + table.rows.length + "\" >Descending</label>";
            
            if(table.rows.length >= 5) addCriteriaButton.className = "btn disabled";
            deleteCriteriaButton.className = "btn waves-effect waves-light";
            
            $("select").material_select();
        };

        deleteCriteriaButton.onclick = function() {
            if(table.rows.length > 0) table.deleteRow(table.rows.length -1);
            
            if(table.rows.length <= 0) deleteCriteriaButton.className = "btn disabled";
            addCriteriaButton.className = "btn waves-effect waves-light";
            
            $("select").material_select();
        };

        document.getElementById("room-sort-criteria-button").onclick = function() {
            roomOrder.clearArray();
            for(var i = 0; i < table.rows.length; i++) {
                var currentCritera = document.getElementById("criteria-select-"+(i+1)).value;
                var currentMode = table.rows[i].cells[2].childNodes[0].checked ? "ASC" : "DESC";
                
                if(roomOrder.indexOfItem(currentCritera) == -1) {
                    roomOrder.pushItem(currentCritera, currentMode);
                }
            }
            updateRoomList(0, pagination);
            $('#sort-room-modal').closeModal();
        };
        
        document.getElementById("room-reset-button").onclick = function() {
            roomOrder.clearArray();
            roomSearchParameters["id"] = null;
            roomSearchParameters["floor"] = null;
            roomSearchParameters["campus"] = null;
            roomSearchParameters["capacity"] = null;
            roomSearchParameters["type"] = null;
            updateRoomList(0, pagination);
            
        };
        
    });
    
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
        ajaxRequest.open("POST", phpContent + "ajaxCheck.php", true);
        ajaxRequest.onreadystatechange = response;
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxRequest.send("roomId=" + value);
        
        function response() {
            if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
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
        
        ajaxRequest.open("POST", phpContent + "ajaxRegisterRoom.php", true);
        ajaxRequest.onreadystatechange = response;
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxRequest.send("data=" + JSON.stringify(data));
        
        function response() {
            if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                console.log(ajaxRequest.responseText);
                if(ajaxRequest.responseText == "true") {
                    form.reset();
                    
                    updateRoomList(currentRoomPage, pagination);
                    
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

function updateRoomList(page, roomPerPage) {
    var ajaxRequest = getXMLHTTPRequest();
    ajaxRequest.open("POST", phpContent + "ajaxGetRooms.php", true);
    ajaxRequest.onreadystatechange = response;
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var roomPostString = "page=" + page + "&roomPerPage=" + roomPerPage + "&order=" + JSON.stringify(roomOrder.getArray());
    
    if(roomSearchParameters["id"] != null) roomPostString = roomPostString + "&id=" + roomSearchParameters["id"];
    if(roomSearchParameters["floor"] != null) roomPostString = roomPostString + "&floor=" + roomSearchParameters["floor"];
    if(roomSearchParameters["campus"] != null) roomPostString = roomPostString + "&campus=" + roomSearchParameters["campus"];
    if(roomSearchParameters["capacity"] != null) roomPostString = roomPostString + "&capacity=" + roomSearchParameters["capacity"];
    if(roomSearchParameters["type"] != null) roomPostString = roomPostString + "&type=" + roomSearchParameters["type"];
    
    ajaxRequest.send(roomPostString);
    
    var table = document.getElementById("room-list-table-body");
    
    function response() {
        if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
            var response = ajaxRequest.responseXML;
            if(response == null || response.getElementsByTagName("room").length == 0) {table.innerHTML = ""; document.getElementById("room-pagination-area").innerHTML = ""; return;}
            var pageRequired = response.getElementsByTagName("pageRequired")[0].childNodes[0].nodeValue;
            var rooms = response.getElementsByTagName("room");
            
            table.innerHTML = "";
            
            for(var i = 0; i < rooms.length; i++) {
                var id = rooms[i].getElementsByTagName("id")[0].childNodes[0].nodeValue;
                var floor = rooms[i].getElementsByTagName("floor")[0].childNodes[0].nodeValue;
                var campus = rooms[i].getElementsByTagName("campus")[0].childNodes[0].nodeValue;
                var capacity = rooms[i].getElementsByTagName("capacity")[0].childNodes[0].nodeValue;
                var type = rooms[i].getElementsByTagName("type")[0].childNodes[0].nodeValue;
                
                var row = table.insertRow(i);
                var idCell = row.insertCell(0);
                var floorCell = row.insertCell(1);
                var campusCell = row.insertCell(2);
                var capacityCell = row.insertCell(3);
                var typeCell = row.insertCell(4);
                var optionCell = row.insertCell(5);
                
                idCell.innerHTML = id;
                floorCell.innerHTML = floor;
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
            else paginationHTML = paginationHTML + "<li onclick=\"updateRoomList(" + (page - 1) + ", " + pagination + ");\"><a href=\"#\"><i class=\"material-icons\">chevron_left</i></a></li>";
            
            for(var i = 0; i < pageRequired; i++) {
                if(i == page) paginationHTML = paginationHTML + "<li class=\"active\" onclick=\"updateRoomList(" + i + ", " + pagination + ");\"><a href=\"#\">" + (i + 1) + "</a></li>";
                else paginationHTML = paginationHTML + "<li onclick=\"updateRoomList(" + i + ", " + pagination + ");\"><a href=\"#\">" + (i + 1) + "</a></li>";
            }
            
            if(page + 1 >= pageRequired) paginationHTML = paginationHTML + "<li class=\"disabled\"><a href=\"#\"><i class=\"material-icons\">chevron_right</i></a></li>";
            else paginationHTML = paginationHTML + "<li onclick=\"updateRoomList(" + (page + 1) + ", " + pagination + ");\"><a href=\"#\"><i class=\"material-icons\">chevron_right</i></a></li>";
            
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
    ajaxRequest.open("POST", phpContent + "ajaxGetRooms.php", true);
    ajaxRequest.onreadystatechange = response;
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.send("id=" + room + "&single=true");
    
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
                    ajaxRequest.open("POST", phpContent + "ajaxUpdateRoom.php", true);
                    ajaxRequest.onreadystatechange = response2;
                    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    ajaxRequest.send("data=" + JSON.stringify(data) + "&old=" + oldId);

                    function response2() {
                        if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                            console.log(ajaxRequest.responseText);
                            if(ajaxRequest.responseText == "true") {
                                document.getElementById("update-room-form").reset();
                                    
                                updateRoomList(currentRoomPage, pagination);

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
        ajaxRequest.open("POST", phpContent + "ajaxDeleteRoom.php", true);
        ajaxRequest.onreadystatechange = response;
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxRequest.send("id=" + room);

        function response() {
                if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                    if(ajaxRequest.responseText == "true") {
                        updateRoomList(currentRoomPage, pagination);
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

function performRoomSearch(id, floor, campus, capacity, type, modal) {
    id = document.getElementById(id).value;
    floor = document.getElementById(floor).value;
    campus = document.getElementById(campus).value;
    capacity = document.getElementById(capacity).value;
    type = document.getElementById(type);
    type = type.options[type.selectedIndex].text;
    
    $('#search-room-modal').closeModal();
    
    roomSearchParameters["id"] = id == "" ? null : id;
    roomSearchParameters["floor"] = floor == "" ? null : floor;
    roomSearchParameters["campus"] = campus == "" ? null : campus;
    roomSearchParameters["capacity"] = capacity == "" ? null : capacity;
    roomSearchParameters["type"] = type == "Any" ? null : type;
    
    
    updateRoomList(0, pagination);
}
