function getProfileContent() {
    
    $("#" + contentId).load(htmlContent + "profile.html", function() {
        document.getElementById("username-cell").innerHTML = userInfo["username"];
        document.getElementById("password-cell").innerHTML = "*****";
        document.getElementById("fullname-cell").innerHTML = userInfo["fullname"];
        document.getElementById("id-cell").innerHTML = userInfo["id"];
        document.getElementById("position-cell").innerHTML = userInfo["position"];
        document.getElementById("department-cell").innerHTML = userInfo["department"];
        document.getElementById("phone-cell").innerHTML = userInfo["phone"];
        document.getElementById("email-cell").innerHTML = userInfo["email"];
        
        $('.edit-password-modal-trigger').leanModal({
            dismissible: true, // Modal can be dismissed by clicking outside of the modal
            opacity: .5, // Opacity of modal background
            in_duration: 300, // Transition in duration
            out_duration: 200, // Transition out duration
            ready: function() { 
                var oldPassword = document.getElementById("edit-password-old");
                var newPassword = document.getElementById("edit-password-new");
                var retypePassword = document.getElementById("edit-password-retype");
                var oldPasswordLabel = document.getElementById("edit-password-old-label");
                var newPasswordLabel = document.getElementById("edit-password-new-label");
                var retypePasswordLabel = document.getElementById("edit-password-retype-label");
                var button = document.getElementById("password-save-button");
                
                
                button.onclick = function() {
                    var ajaxRequest = getXMLHTTPRequest();
                    var oldValue = oldPassword.value;
                    var newValue = newPassword.value;
                    var retypeValue = retypePassword.value;
                    
                    if(oldValue == "" || newValue == "" || retypeValue == "") {
                        alert("Please fill up all the fields!");
                        return;
                    }
                    else {
                        ajaxRequest.open("POST", "include/ajaxCheck.php", true);
                        ajaxRequest.onreadystatechange = response;
                        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        ajaxRequest.send("password=" + oldValue + "&hash=" + userInfo["password"]);
                        
                        function response() {
                            if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                                var passwordValid = ajaxRequest.responseXML.getElementsByTagName("password")[0].childNodes[0].nodeValue;
                                if(passwordValid == "true") {
                                    if(newValue != retypeValue) {
                                        alert("Passwords do not match!");
                                    }
                                    else {
                                        var newUserInfo = userInfo;
                                        newUserInfo["password"] = newValue;
                                        updateUser(newUserInfo, "edit-password-modal", "Successfully edited password!", "Failed to edit password!", true);
                                    }
                                }
                                else {
                                    alert("Wrong old password entered!");
                                }
                            }
                        }
                        
                        
                    }
                };
            }, // Callback for Modal open
            complete: function() { } // Callback for Modal close
        });
        
        
        $('.edit-fullname-modal-trigger').leanModal({
            dismissible: true, // Modal can be dismissed by clicking outside of the modal
            opacity: .5, // Opacity of modal background
            in_duration: 300, // Transition in duration
            out_duration: 200, // Transition out duration
            ready: function() { 
                var input = document.getElementById("edit-fullname");
                var label = document.getElementById("edit-fullname-label");
                var button = document.getElementById("fullname-save-button");
                
                input.value = userInfo["fullname"];
                input.className = "valid";
                
                button.onclick = function() {
                    var ajaxRequest = getXMLHTTPRequest();
                    var value = input.value;
                    var pattern = /^[a-z\d\-\s]+$/i;
                    var result = pattern.exec(value);
                    if(value == "") {
                        alert("Please enter your Full Name!");
                        return;
                    }
                    else if(result == null) {
                        alert("Input contains invalid characters");
                        input.className = "invalid";
                    }
                    else {
                        input.className = "valid";
                        var newUserInfo = userInfo;
                        newUserInfo["fullname"] = value;
                        
                        updateUser(newUserInfo, "edit-fullname-modal", "Successfully edited Full Name!", "Failed to edit Full Name!", false);
                    }
                };
            }, // Callback for Modal open
            complete: function() { } // Callback for Modal close
        });
        
        $('.edit-id-modal-trigger').leanModal({
            dismissible: true, // Modal can be dismissed by clicking outside of the modal
            opacity: .5, // Opacity of modal background
            in_duration: 300, // Transition in duration
            out_duration: 200, // Transition out duration
            ready: function() { 
                var input = document.getElementById("edit-id");
                var label = document.getElementById("edit-id-label");
                var button = document.getElementById("id-save-button");
                
                input.value = userInfo["id"];
                input.className = "valid";
                
                button.onclick = function() {
                    var ajaxRequest = getXMLHTTPRequest();
                    var value = input.value;
                    var pattern = /^[a-z\d\-\s]+$/i;
                    var result = pattern.exec(value);
                    if(value == "") {
                        alert("Please enter your ID!");
                        return;
                    }
                    else if(result == null) {
                        label.setAttribute("data-error", "Error");
                        alert("Input contains invalid characters");
                        input.className = "invalid";
                    }
                    else {
                        ajaxRequest.open("POST", "include/ajaxCheck.php", true);
                        ajaxRequest.onreadystatechange = response;
                        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        ajaxRequest.send("id=" + value);
                        
                        function response() {
                            if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                                var idTaken = ajaxRequest.responseXML.getElementsByTagName("id")[0].childNodes[0].nodeValue;

                                if(idTaken == "true") {
                                    label.setAttribute("data-error", "Taken");
                                    input.className = "invalid";
                                    alert("ID already registered!");
                                }
                                else {
                                    label.setAttribute("data-error", "Error");
                                    input.className = "valid";
                                    var newUserInfo = userInfo;
                                    newUserInfo["id"] = value;

                                    updateUser(newUserInfo, "edit-id-modal", "Successfully edited ID!", "Failed to edit ID!", false);
                                }
                            }
                            else {

                            }
                        }
                    }
                };
            }, // Callback for Modal open
            complete: function() { } // Callback for Modal close
        });
        
        $('.edit-email-modal-trigger').leanModal({
            dismissible: true, // Modal can be dismissed by clicking outside of the modal
            opacity: .5, // Opacity of modal background
            in_duration: 300, // Transition in duration
            out_duration: 200, // Transition out duration
            ready: function() { 
                var input = document.getElementById("edit-email");
                var label = document.getElementById("edit-email-label");
                var button = document.getElementById("email-save-button");
                
                input.value = userInfo["email"];
                input.className = "valid";
                
                button.onclick = function() {
                    var ajaxRequest = getXMLHTTPRequest();
                    var value = input.value;
                    var pattern = /^([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22))*\x40([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d))*$/; //(Licensed under a Creative Commons Attribution-ShareAlike 2.5 License, or the GPL) If you use this code you must include the original copyright as stated at http://rosskendall.com/files/rfc822validemail.js.txt
                    
                    var result = pattern.exec(value);
                    if(value == "") {
                        alert("Please enter your Email!");
                        return;
                    }
                    else if(result == null) {
                        label.setAttribute("data-error", "Error");
                        alert("Invalid input!");
                        input.className = "invalid";
                    }
                    else {
                        var ajaxRequest = getXMLHTTPRequest();
                        ajaxRequest.open("POST", "include/ajaxCheck.php", true);
                        ajaxRequest.onreadystatechange = response;
                        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        ajaxRequest.send("email=" + value);
                        
                        function response() {
                            if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                                var emailTaken = ajaxRequest.responseXML.getElementsByTagName("email")[0].childNodes[0].nodeValue;

                                if(emailTaken == "true") {
                                    label.setAttribute("data-error", "Taken");
                                    input.className = "invalid";
                                    alert("Email already registered!");
                                }
                                else {
                                    label.setAttribute("data-error", "Error");
                                    input.className = "valid";
                                    var newUserInfo = userInfo;
                                    newUserInfo["email"] = value;

                                    updateUser(newUserInfo, "edit-email-modal", "Successfully edited Email!", "Failed to edit Email!", false);
                                }
                            }
                            else {

                            }
                        }
                    }
                };
            }, // Callback for Modal open
            complete: function() { } // Callback for Modal close
        });
        
        $('.edit-phone-modal-trigger').leanModal({
            dismissible: true, // Modal can be dismissed by clicking outside of the modal
            opacity: .5, // Opacity of modal background
            in_duration: 300, // Transition in duration
            out_duration: 200, // Transition out duration
            ready: function() { 
                var input = document.getElementById("edit-phone");
                var label = document.getElementById("edit-phone-label");
                var button = document.getElementById("phone-save-button");
                
                input.value = userInfo["phone"];
                input.className = "valid";
                
                button.onclick = function() {
                    var ajaxRequest = getXMLHTTPRequest();
                    var value = input.value;
                    var pattern = new RegExp("^[0-9]{7,}$");
                    
                    var result = pattern.exec(value);
                    if(value == "") {
                        alert("Please enter your Phone Number!");
                        return;
                    }
                    else if(result == null) {
                        label.setAttribute("data-error", "Error");
                        alert("Invalid input!");
                        input.className = "invalid";
                    }
                    else {
                        var ajaxRequest = getXMLHTTPRequest();
                        ajaxRequest.open("POST", "include/ajaxCheck.php", true);
                        ajaxRequest.onreadystatechange = response;
                        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        ajaxRequest.send("phone=" + value);
                        
                        function response() {
                            if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                                var phoneTaken = ajaxRequest.responseXML.getElementsByTagName("phone")[0].childNodes[0].nodeValue;

                                if(phoneTaken == "true") {
                                    label.setAttribute("data-error", "Taken");
                                    input.className = "invalid";
                                    alert("Phone already registered!");
                                }
                                else {
                                    label.setAttribute("data-error", "Error");
                                    input.className = "valid";
                                    var newUserInfo = userInfo;
                                    newUserInfo["phone"] = value;

                                    updateUser(newUserInfo, "edit-phone-modal", "Successfully edited Phone!", "Failed to edit Phone!", false);
                                }
                            }
                            else {

                            }
                        }
                    }
                };
            }, // Callback for Modal open
            complete: function() { } // Callback for Modal close
        });
        
        
        $('.edit-department-modal-trigger').leanModal({
            dismissible: true, // Modal can be dismissed by clicking outside of the modal
            opacity: .5, // Opacity of modal background
            in_duration: 300, // Transition in duration
            out_duration: 200, // Transition out duration
            ready: function() {
                var input = document.getElementById("edit-department");
                var label = document.getElementById("edit-department-label");
                var button = document.getElementById("department-save-button");
                
                input.value = userInfo["department"];
                input.className = "valid";
                
                $('select').material_select();
                
                button.onclick = function() {
                    var newUserInfo = userInfo;
                    newUserInfo["department"] = input.value;
                    updateUser(newUserInfo, "edit-department-modal", "Successfully edited department!", "Failed to edit department!", false);
                };

            }, // Callback for Modal open
            complete: function() { } // Callback for Modal close
        });
        
        $('.edit-position-modal-trigger').leanModal({
            dismissible: true, // Modal can be dismissed by clicking outside of the modal
            opacity: .5, // Opacity of modal background
            in_duration: 300, // Transition in duration
            out_duration: 200, // Transition out duration
            ready: function() {
                var input = document.getElementById("edit-position");
                var label = document.getElementById("edit-position-label");
                var button = document.getElementById("position-save-button");
                
                input.value = userInfo["position"];
                input.className = "valid";
                
                $('select').material_select();
                
                button.onclick = function() {
                    var newUserInfo = userInfo;
                    newUserInfo["position"] = input.value;
                    updateUser(newUserInfo, "edit-position-modal", "Successfully edited department!", "Failed to edit department!", false);
                };

            }, // Callback for Modal open
            complete: function() { } // Callback for Modal close
        });
        
        
        
    });
}

function updateUser(user, modal, success, failure, password) {
    var ajaxRequest = getXMLHTTPRequest();
    ajaxRequest.open("POST", "include/ajaxUpdateUser.php", true);
    ajaxRequest.onreadystatechange = response;
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    if(!password) ajaxRequest.send("changeUser=true&data=" + JSON.stringify(user));
    else ajaxRequest.send("changeUser=true&password=true&data=" + JSON.stringify(user));
    
    function response() {
        if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
            if(ajaxRequest.responseText == "true") {
                if(!password) {
                    userInfo = user;
                    getProfileContent();
                    $("#" + modal).closeModal();
                    Materialize.toast(success, 2000);
                }
                else {
                    ajaxRequest.open("POST", "include/ajaxGetUsers.php", true);
                    ajaxRequest.onreadystatechange = response2;
                    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    ajaxRequest.send("user=" + userInfo["username"] + "&single=true");
                    
                    function response2() {
                        if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                            var hash = ajaxRequest.responseXML.getElementsByTagName("user")[0].getElementsByTagName("password")[0].childNodes[0].nodeValue;
                            userInfo = user;
                            userInfo["password"] = hash;
                            getProfileContent();
                            $("#" + modal).closeModal();
                            Materialize.toast(success, 2000);
                            
                        }
                    }
                }
            }
            else {
                Materialize.toast(failure, 2000);
            }
        }
    }
}