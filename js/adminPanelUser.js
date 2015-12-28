function showEditUser(user) {
    var ajaxRequest = getXMLHTTPRequest();
    ajaxRequest.open("POST", "include/ajaxGetUsers.php", true);
    ajaxRequest.onreadystatechange = response;
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.send("user=" + user + "&single=true");
    
    function response() {
        if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
            $('#update-user-modal').openModal();

            var response = ajaxRequest.responseXML;
            var currentUser = response.getElementsByTagName("user")[0];


            var username = document.getElementById("edit-username");
            var password = document.getElementById("edit-password");
            var fullname = document.getElementById("edit-full-name");
            var id = document.getElementById("edit-id");
            var position = document.getElementById("edit-position");
            var department = document.getElementById("edit-department");
            var email = document.getElementById("edit-email");
            var phone = document.getElementById("edit-phone");
            var typeUser = document.getElementById("edit-type-user");
            var typeAdmin = document.getElementById("edit-type-admin");
            var save = document.getElementById("edit-save-button");

            username.className = "valid";
            password.className = "valid";
            fullname.className = "valid";
            id.className = "valid";
            email.className = "validate valid";
            phone.className = "valid";

            var oldFullname = currentUser.childNodes[2].childNodes[0].nodeValue;
            var oldId = currentUser.childNodes[3].childNodes[0].nodeValue;
            var oldEmail = currentUser.childNodes[7].childNodes[0].nodeValue;
            var oldPhone = currentUser.childNodes[6].childNodes[0].nodeValue;

            fullname.onchange = function() {validateFullname("edit-full-name", "edit-full-name-label", fullname.value, oldFullname);};
            id.onchange = function() {validateId("edit-id", "edit-id-label", oldId);};
            email.onchange = function() {validateEmail("edit-email", "edit-email-label", oldEmail);};
            phone.onchange = function() {validatePhone("edit-phone", "edit-phone-label", oldPhone);};

            username.value = currentUser.childNodes[0].childNodes[0].nodeValue;
            fullname.value = currentUser.childNodes[2].childNodes[0].nodeValue;
            id.value = currentUser.childNodes[3].childNodes[0].nodeValue;

            for(var i = 0; i < position.length; i++) {
                if(position.options[i].text == currentUser.childNodes[4].childNodes[0].nodeValue) {
                    position.selectedIndex = i;
                    $('select').material_select();
                    break;
                }
            }
            for(var i = 0; i < department.length; i++) {
                if(department.options[i].text == currentUser.childNodes[5].childNodes[0].nodeValue) {
                    department.selectedIndex = i;
                    $('select').material_select();
                    break;
                }
            }
            phone.value = currentUser.childNodes[6].childNodes[0].nodeValue;
            email.value = currentUser.childNodes[7].childNodes[0].nodeValue;
            currentUser.childNodes[8].childNodes[0].nodeValue == "admin" ? typeAdmin.checked = true : typeUser.checked = true;

            save.onclick = function() {
                if(username.className == "valid" && fullname.className == "valid" && email.className == "validate valid" && id.className == "valid" && phone.className == "valid") {
                    var data = {
                        username : username.value,
                        password : password.value,
                        fullname : fullname.value,
                        id : id.value,
                        phone : phone.value,
                        email : email.value,
                        position : position.options[position.selectedIndex].text,
                        department : department.options[department.selectedIndex].text,
                        type : document.getElementById("edit-type-user").checked ? "user" : "admin"
                    }


                    ajaxRequest = getXMLHTTPRequest();
                    ajaxRequest.open("POST", "include/ajaxUpdateUser.php", true);
                    ajaxRequest.onreadystatechange = response2;
                    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    ajaxRequest.send("data=" + JSON.stringify(data));

                    function response2() {
                        if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                            if(ajaxRequest.responseText == "true") {
                                document.getElementById("update-user-form").reset();

                                updateUserList(currentUserPage, pagination, document.getElementById("search-user").value);

                                $('#update-user-modal').closeModal();
                                Materialize.toast('User modified successfully!', 2000);
                            }
                            else {
                                Materialize.toast('Failed to modify user!', 2000);
                            }
                        }
                    }
                }
                else {
                    alert("Please fix the errors");
                }

            }


        }
    }
    
    
}

function showDeleteUser(user) {
    $('#delete-user-modal').openModal();
    var button = document.getElementById("delete-yes-button");
    
    button.onclick = function() {
        var ajaxRequest = getXMLHTTPRequest();
        ajaxRequest.open("POST", "include/ajaxDeleteUser.php", true);
        ajaxRequest.onreadystatechange = response;
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxRequest.send("user=" + user);

        function response() {
                if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                    if(ajaxRequest.responseText == "true") {
                        updateUserList(currentUserPage, pagination, document.getElementById("search-user").value);
                        $('#delete-user-modal').closeModal();
                        Materialize.toast('Deleted user!', 2000);
                    }
                    else {
                        Materialize.toast('Failed to delete user!', 2000);
                    }
                }
        }
        
    };
    
    
                
    
}

function getUsersContent() {
    
    var temp = "<div class=\"row\">" + 
               "    <div class=\"col s12\"><h4>Users<h4><hr /></div>" +
               "    <div class=\"col s12\">" + 
               "        <button data-target=\"create-user-modal\" class=\"btn col s12 waves-effect waves-light create-user-modal-trigger\">Create User</button>" + 
               "    </div>" +
               "    <div class=\"col s12\" >" +
               "        <table id=\"user-list-table\" class=\"responsive-table striped\">" +
               "            <thead>" +
               "                <tr><th colspan=\"4\">User List</th></tr>" +
               "                <tr>" +
               "                    <th data-field=\"username\">Username</th>" +
               "                    <th data-field=\"fullname\">Full Name</th>" +
               "                    <th data-field=\"type\">Account Type</th>" +
               "                    <th data-field=\"options\"><div class=\"col s8 right\"><input placeholder=\"Search User\" id=\"search-user\" type=\"search\"></div></th>" +
               "                </tr>" +
               "            </thead><tbody id=\"user-list-table-body\"></tbody>" +
               "        </table>" +
               "    </div>" +
               "    <div id=\"user-pagination-area\"></div>" +
               "</div>";
    
    content.innerHTML = temp;
    
    $(".create-user-modal-trigger").leanModal({
        dismissible: true, // Modal can be dismissed by clicking outside of the modal
        opacity: .5, // Opacity of modal background
        in_duration: 300, // Transition in duration
        out_duration: 200, // Transition out duration
        ready: function() { }, // Callback for Modal open
        complete: function() { 
            document.getElementById("create-user-form").reset();
        }
    });
    
    
    var search = document.getElementById("search-user");
    search.onkeyup = function() {
        updateUserList(0, pagination, search.value); 
    };
    
    updateUserList(0, pagination, search.value);
    
}

function updateUserList(page, userPerPage, user) {
    var ajaxRequest = getXMLHTTPRequest();
    ajaxRequest.open("POST", "include/ajaxGetUsers.php", true);
    ajaxRequest.onreadystatechange = response;
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.send("page=" + page + "&userPerPage=" + userPerPage + "&user=" + user);
    
    var table = document.getElementById("user-list-table-body");

    function response() {
        if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
            var response = ajaxRequest.responseXML;
            if(response == null) {table.innerHTML = ""; document.getElementById("user-pagination-area").innerHTML = ""; return;}
            var pageRequired = response.getElementsByTagName("pageRequired")[0].childNodes[0].nodeValue;
            var users = response.getElementsByTagName("user");
            
            table.innerHTML = "";

            for(var i = 0; i < users.length; i++) {
                var username = users[i].getElementsByTagName("username")[0].childNodes[0].nodeValue;
                var fullname = users[i].getElementsByTagName("fullname")[0].childNodes[0].nodeValue;
                var type = users[i].getElementsByTagName("type")[0].childNodes[0].nodeValue;
                
                var row = table.insertRow(i);
                var usernameCell = row.insertCell(0);
                var fullnameCell = row.insertCell(1);
                var typeCell = row.insertCell(2);
                var optionCell = row.insertCell(3);
                
                usernameCell.innerHTML = username;
                fullnameCell.innerHTML = fullname;
                typeCell.innerHTML = type;
                optionCell.innerHTML = "<div class=\"right\"><a class=\"waves-effect waves-light btn\" onclick=\"return showEditUser('" + username  + "');\">Edit User</a><a class=\"waves-effect waves-light btn\" onclick=\"return showDeleteUser('" + username  + "');\">Delete User</a></div>";
            }
            
            if(page >= pageRequired) page = pageRequired - 1;
            else if(page < 0) page = 0;
            
            currentUserPage = page;
            
            var search = document.getElementById("search-user");
            var paginationHTML = "<ul class=\"pagination\">";
            if(page - 1 < 0) paginationHTML = paginationHTML + "<li class=\"disabled\"><a href=\"#\"><i class=\"material-icons\">chevron_left</i></a></li>";
            else paginationHTML = paginationHTML + "<li onclick=\"updateUserList(" + (page - 1) + ", " + pagination + ", '" + search.value + "');\"><a href=\"#\"><i class=\"material-icons\">chevron_left</i></a></li>";
            
            for(var i = 0; i < pageRequired; i++) {
                if(i == page) paginationHTML = paginationHTML + "<li class=\"active\" onclick=\"updateUserList(" + i + ", " + pagination + ", '" + search.value + "');\"><a href=\"#\">" + (i + 1) + "</a></li>";
                else paginationHTML = paginationHTML + "<li onclick=\"updateUserList(" + i + ", " + pagination + ", '" + search.value + "');\"><a href=\"#\">" + (i + 1) + "</a></li>";
            }
            
            if(page + 1 >= pageRequired) paginationHTML = paginationHTML + "<li class=\"disabled\"><a href=\"#\"><i class=\"material-icons\">chevron_right</i></a></li>";
            else paginationHTML = paginationHTML + "<li onclick=\"updateUserList(" + (page + 1) + ", " + pagination + ", '" + search.value + "');\"><a href=\"#\"><i class=\"material-icons\">chevron_right</i></a></li>";
            
            paginationHTML = paginationHTML + "</ul>";
            
            document.getElementById("user-pagination-area").innerHTML = "<div class=\"right\">" + paginationHTML + "</div>";

        }
        else {
            table.innerHTML = "";
            var row = table.insertRow(0);
            var cell = row.insertCell(0);
        }
    }

}    

function validateUsername(input, label) {
    var newUsername = document.getElementById(input);
    var newUsernameLabel = document.getElementById(label);
    
    
    var ajaxRequest = getXMLHTTPRequest();
    var value = newUsername.value;
    var pattern = new RegExp("^[A-Za-z0-9_-]{5,15}$");
    var result = pattern.exec(value);
    if(value == "") {
        newUsername.className = "";
        return;
    }
    else if(result == null) {
        newUsernameLabel.setAttribute("data-error", "Error");
        newUsername.className = "invalid";

    }
    else {
        ajaxRequest.open("POST", "include/ajaxCheck.php", true);
        ajaxRequest.onreadystatechange = response;
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxRequest.send("username=" + value);
    }

    function response() {
        if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
            var usernameTaken = ajaxRequest.responseXML.getElementsByTagName("username")[0].childNodes[0].nodeValue;

            if(usernameTaken == "true") {
                newUsernameLabel.setAttribute("data-error", "Taken");
                newUsername.className = "invalid";
            }
            else {
                newUsernameLabel.setAttribute("data-error", "Error");
                newUsername.className = "valid";
            }
        }
        else {

        }
    }
}

function validatePassword(input1, label1, input2, label2) {
    var newPassword = document.getElementById(input1);
    var newPasswordLabel = document.getElementById(label1);
    
    var retypePassword = document.getElementById(input2);
    var retypePasswordLabel = document.getElementById(label2);
    
    var value = newPassword.value;
    
    if(value == "") {
        newPassword.className = "";
        retypePassword.className = "";
        return;
    }
    else {
        newPassword.className = "valid";
        if(retypePassword.value != "") {
            if(retypePassword.value != value) {
                retypePasswordLabel.setAttribute("data-error", "Error"); 
                retypePassword.className = "invalid";
            }
            else {
                retypePassword.className = "valid";
            }
        }
    }
}

function validateRetypePassword(input1, label1, input2, label2) {
    var retypePassword = document.getElementById(input1);
    var retypePasswordLabel = document.getElementById(label1);
    
    var newPassword = document.getElementById(input2);
    var newPasswordLabel = document.getElementById(label2);
    
    
    var originalValue = newPassword.value;
    var retypeValue = retypePassword.value;
    
    if(retypeValue == "") {
        retypePassword.className = "";
        return;
    }
    if(originalValue != "") {
        if(retypeValue != originalValue) {
            retypePasswordLabel.setAttribute("data-error", "Error");
            retypePassword.className = "invalid";
        }
        else {
            retypePassword.className = "valid";
        }
    }
}

function validateFullname(input, label) {
    var fullname = document.getElementById(input);
    var fullnameLabel = document.getElementById(label);
    
    var value = fullname.value;
    if(value == "") {
        fullname.className = "";
        return;
    }
    else {
        fullname.className = "valid";
    }
}

function validateId(input, label, old) {
    var id = document.getElementById(input);
    var idLabel = document.getElementById(label);
    
    var ajaxRequest = getXMLHTTPRequest();
    var value = id.value;
    
    if(value == "") {
        id.className = "";
        return;
    }
    else if(value == old) {
        id.className = "valid";
        return;
    }
    
    
    ajaxRequest.open("POST", "include/ajaxCheck.php", true);
    ajaxRequest.onreadystatechange = response;
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.send("id=" + value);
    
    
    function response() {
        if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
            var idTaken = ajaxRequest.responseXML.getElementsByTagName("id")[0].childNodes[0].nodeValue;

            if(idTaken == "true") {
                idLabel.setAttribute("data-error", "Taken");
                id.className = "invalid";
            }
            else {
                idLabel.setAttribute("data-error", "Error");
                id.className = "valid";
            }
        }
        else {

        }
    }
}

function validatePhone(input, label, old) {
    var phone = document.getElementById(input);
    var phoneLabel = document.getElementById(label);
    
    
    var ajaxRequest = getXMLHTTPRequest();
    var value = phone.value;
    var pattern = new RegExp("^[0-9]{7,}$");
    var result = pattern.exec(value);
    
    if(value == "") {
        phone.className = "";
        return;
    }
    else if(value == old) {
        phone.className = "valid";
        return;
    }
    else if(result == null) {
        phoneLabel.setAttribute("data-error", "Error");
        phone.className = "invalid";
    }
    else {
        ajaxRequest.open("POST", "include/ajaxCheck.php", true);
        ajaxRequest.onreadystatechange = response;
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxRequest.send("phone=" + value);
    }

    function response() {
        if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
            var phoneTaken = ajaxRequest.responseXML.getElementsByTagName("phone")[0].childNodes[0].nodeValue;

            if(phoneTaken == "true") {
                phoneLabel.setAttribute("data-error", "Taken");
                phone.className = "invalid";
            }
            else {
                phoneLabel.setAttribute("data-error", "Error");
                phone.className = "valid";
            }
        }
        else {

        }
    }
}



function validateEmail(input, label, old) {
    var email = document.getElementById(input);
    var emailLabel = document.getElementById(label);
    
    var ajaxRequest = getXMLHTTPRequest();
    var value = email.value;
    
    if(value == old) {
        email.className = "validate valid";
        return;
    }
    
    if(email.className == "validate valid") {
        ajaxRequest.open("POST", "include/ajaxCheck.php", true);
        ajaxRequest.onreadystatechange = response;
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxRequest.send("email=" + value);
    }
    function response() {
        if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
            var emailTaken = ajaxRequest.responseXML.getElementsByTagName("email")[0].childNodes[0].nodeValue;

            if(emailTaken == "true") {
                emailLabel.setAttribute("data-error", "Taken");
                email.className = "validate invalid";
            }
            else {
                emailLabel.setAttribute("data-error", "Error");
                email.className = "validate valid";
            }
        }
        else {

        }
    }
}


function validateRegistrationForm(newUsernameInput, newUsernameLabelText, newPasswordInput, newPasswordLabelText, retypePasswordInput, retypePasswordLabelText, fullnameInput, fullnameLabelText, idInput, idLabelText, positionInput, positionLabelText, departmentInput, departmentLabelText, emailInput, emailLabelText, phoneInput, phoneLabelText) {
    var newUsername = document.getElementById(newUsernameInput);
    var newPassword = document.getElementById(newPasswordInput);
    var retypePassword = document.getElementById(retypePasswordInput);
    var fullname = document.getElementById(fullnameInput);
    var id = document.getElementById(idInput);
    var position = document.getElementById(positionInput);
    var department = document.getElementById(departmentInput);
    var email = document.getElementById(emailInput);
    var phone = document.getElementById(phoneInput);

    var newUsernameLabel = document.getElementById(newUsernameLabelText);
    var newPasswordLabel = document.getElementById(newPasswordLabelText);
    var retypePasswordLabel = document.getElementById(retypePasswordLabelText);
    var fullnameLabel = document.getElementById(fullnameLabelText);
    var idLabel = document.getElementById(idLabelText);
    var positionLabel = document.getElementById(positionLabelText);
    var departmentLabel = document.getElementById(departmentLabelText);
    var emailLabel = document.getElementById(emailLabelText);
    var phoneLabel = document.getElementById(phoneLabelText);
    
    
    var ajaxRequest = getXMLHTTPRequest();
    
    if(newUsername.className == "valid" && newPassword.className == "valid" && retypePassword.className == "valid" && fullname.className == "valid" && email.className == "validate valid" && id.className == "valid" && phone.className == "valid") {
        
        var data = {
            username : newUsername.value,
            password : newPassword.value,
            fullName : fullname.value,
            id : id.value,
            phone : phone.value,
            email : email.value,
            position : position.options[position.selectedIndex].text,
            department : department.options[department.selectedIndex].text,
            type : document.getElementById("type-user").checked ? "user" : "admin"
        }
        
        ajaxRequest.open("POST", "include/ajaxRegisterUser.php", true);
        ajaxRequest.onreadystatechange = response;
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxRequest.send("data=" + JSON.stringify(data));
        
        function response() {
            if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                console.log(ajaxRequest.responseText);
                if(ajaxRequest.responseText == "true") {
                    
                    
                    newUsername.value = "";
                    newPassword.value = "";
                    retypePassword.value = "";
                    fullname.value = "";
                    id.value = "";
                    phone.value = "";
                    email.value = "";
                    position.selectedIndex = 0;
                    department.selectedIndex = 0;
                    document.getElementById("type-user").checked = "checked";

                    newUsername.className = "";
                    newPassword.className = "";
                    retypePassword.className = "";
                    fullname.className = "";
                    id.className = "";
                    phone.className = "";
                    email.className = "validate";
                    
                    updateUserList(currentUserPage, pagination, document.getElementById("search-user").value);
                    
                    $('#create-user-modal').closeModal();
                    Materialize.toast('User created successfully!', 2000);
                }
                else {
                    Materialize.toast('Failed to create user!', 2000);
                }
            }
            else {

            }
        }
        
        return true;
    }
    else {
        alert("Please fix the errors!");
        return false;
    }
}
