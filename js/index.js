function validateLoginForm() {
    var username = document.getElementById("login-username");
    var password = document.getElementById("login-password");
    
    if(username.value == "") {
        alert("Please enter a username");
    }
    else if(password.value == "") {
        aleart("Please enter a password");
    }
    else {
        var ajaxRequest = getXMLHTTPRequest();
        ajaxRequest.open("POST", "include/ajaxLogin.php", true);
        ajaxRequest.onreadystatechange = response;
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        if(document.getElementById("login-remember").checked) ajaxRequest.send("username=" + username.value + "&password=" + password.value + "&checked=true");
        else ajaxRequest.send("username=" + username.value + "&password=" + password.value);
        
        function response() {
            if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                console.log(ajaxRequest.responseText);
                if(ajaxRequest.responseText == "admin") {
                    window.location = "admin_panel.php";
                }
                else if(ajaxRequest.responseText == "user") {
                    window.location = "user_panel.php";
                }
                else {
                    alert("Wrong Credentials!");
                }
            }
        }
    }
}



$('.create-user-modal-trigger').leanModal({
    dismissible: true, // Modal can be dismissed by clicking outside of the modal
    opacity: .5, // Opacity of modal background
    in_duration: 300, // Transition in duration
    out_duration: 200, // Transition out duration
    ready: function() { 
        $('select').material_select();
    }, // Callback for Modal open
    complete: function() { 
        document.getElementById("create-user-form").reset();
    } // Callback for Modal close
});


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
            type : "user"
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

                    newUsername.className = "";
                    newPassword.className = "";
                    retypePassword.className = "";
                    fullname.className = "";
                    id.className = "";
                    phone.className = "";
                    email.className = "validate";
                    
                    
                    $('#create-user-modal').closeModal();
                    Materialize.toast('Registered successfully!', 2000);
                }
                else {
                    Materialize.toast('Failed to register!', 2000);
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

