<?php
    class User {
        private $username, $password, $fullname, $id, $position, $department, $phone, $email, $type;
        
        public function __construct($username, $password, $fullname, $id, $position, $department, $phone, $email, $type) {
            $this->username = $username;
            $this->password = $password;
            $this->fullname = $fullname;
            $this->id = $id;
            $this->position = $position;
            $this->department = $department;
            $this->phone = $phone;
            $this->email = $email;
            $this->type = $type;
        }
        
        public function getUsername() {return $this->username;}
        public function getPassword() {return $this->password;}
        public function getFullname() {return $this->fullname;}
        public function getId() {return $this->id;}
        public function getPosition() {return $this->position;}
        public function getDepartment() {return $this->department;}
        public function getPhone() {return $this->phone;}
        public function getEmail() {return $this->email;}
        public function getType() {return $this->type;}
    }

    class Option {
        private $text, $id, $onClick;
        public function __construct($text, $id, $onClick) {
            $this->text = $text;
            $this->id = $id;
            $this->onClick = $onClick;
        }
        public function getText() {return $this->text;}
        public function getId() {return $this->id;}
        public function getOnClick() {return $this->onClick;}
        
    }
    class AdminPanelPage {
        private $content, $navBarId, $contentId;
        private $logo;
        private $options;
        public function __construct($content) {
            $this->content = $content;
            $this->navBarId = "admin-nav";
            $this->contentId = "content-area";
            $this->logo = array("text" => "Logo", "image" => "", "url" => "#");
            $this->options = array(new Option("Users", "users", "getUsersContent()"), new Option("Rooms", "rooms", "getRoomsContent()"), new Option("Bookings", "bookings", "getBookingsContent()"), new Option("Logout", "logout", "getLogoutContent()"));
        }
        
        public function display() {
            echo "<!DOCTYPE html><html>";
            $this->head();
            $this->body();
            
            echo "</html>";
        }
        
        
        
        protected function head() {
            ?>
            <head>
                <!--Import Google Icon Font-->
                <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
                <!--Import materialize.css-->
                <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
                <!--Import styles.css-->
                <link type="text/css" rel="stylesheet" href="css/styles.css"  media="screen,projection"/>
                
                <!--Let browser know website is optimized for mobile-->
                <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
            </head>
            <?php
        }
        
        protected function extra() {
            ?>
                <!-- Registration Modal -->
                <div id="create-user-modal" class="modal">
                    <div class="modal-content">
                        <div class="row">
                            <h5>Create User</h5>
                            <form>
                                <div class="row">
                                    <div class="input-field col s12">

                                        <input type="text" id="new-username" placeholder="5 to 15 alpha-numeric characters or underscores or hyphens" required>
                                        <label for="new-username" id="new-username-label" data-error="Error">Username</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="input-field col s12">

                                        <input type="password" id="new-password" required>
                                        <label for="new-password" id="new-password-label" data-error="Error">Password</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="input-field col s12">

                                        <input type="password" id="retype-password" required>
                                        <label for="retype-password" id="retype-password-label">Retype Password</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="text" id="full-name" maxlength="100" placeholder="Maximum 100 characters" required>
                                        <label for="full-name" id="full-name-label">Full Name</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="text" id="id" placeholder="Maximum 100 alphabetic characters or - or ." required>
                                        <label for="id" id="id-label">ID</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <select id="position" required>
                                            <option value="1" selected>Part Timer</option>
                                            <option value="2">Instructor</option>
                                            <option value="3">Lecturer</option>
                                            <option value="4">Assistant Professor</option>
                                            <option value="5">Associate Professor</option>
                                            <option value="6">Professor</option>
                                            <option value="7">Head of Department</option>
                                            <option value="8">Dean</option>
                                            <option value="9">Vice Chancellor</option>
                                            <option value="10">Other</option>
                                        </select>
                                        <label for="position" id="position-label" data-error="Error">Position</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <select id="department" required>
                                            <option value="1" selected>Arts and Social Sciences</option>
                                            <option value="2">Business Administration</option>
                                            <option value="3">Engineering</option>
                                            <option value="4">Science and Information Technology
</option>
                                            <option value="5">Other</option>
                                        </select>
                                        <label for="department" id="department-label" data-error="Error">Department</label>
                                    </div>
                                </div>
                                
                                <div class="phone">
                                    <div class="input-field col s12">
                                        <input type="text" class="validate" id="phone" maxlength="40" placeholder="Valid phone number(At least 7 digits and only digits)" required>
                                        <label for="phone" id="phone-label" data-error="Error">Phone</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="email" class="validate" maxlength="100" id="email" placeholder="Valid email address" required>
                                        <label for="email" id="email-label" data-error="Error">Email</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s1">
                                        <span>Type</span>
                                    </div>
                                    
                                    <div class="col s3">
                                        <div class="row">
                                            <div class="col s12">
                                                <input class="with-gap" name="type" type="radio" id="type-user" checked="checked"/>
                                                <label for="type-user">User</label>
                                            </div>
                                            <div class="col s12">
                                                <input class="with-gap" name="type" type="radio" id="type-admin" />
                                                <label for="type-admin">Admin</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row right">
                                    <button class="btn waves-effect waves-light red" type="button" onclick="$('#create-user-modal').closeModal();">Cancel</button>
                                    <button class="btn waves-effect waves-light" type="button" onclick="return validateRegistrationForm();">Create</button>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php
        }
        
        protected function body() {
            ?>

            <body>
                <div class="row">
                    <div class="col s2">
                        <?php $this->sideBar(); ?>
                    </div>
                    <div class="col s10 offset-s2">
                        <a href="#" data-activates="<?php echo $this->navBarId; ?>" class="button-collapse top-nav full hide-on-large-only"><i class="mdi-navigation-menu"></i></a>
                        <div class="container" id="<?php echo $this->contentId; ?>">
                            <?php //echo $this->content; ?>
                        </div>
                    </div>
                </div>
                <?php $this->extra(); $this->scripts(); ?>
            </body>
            <?php
        }
        
        protected function sideBar() {
            
            echo "<ul id=\"$this->navBarId\" class=\"side-nav fixed\"";
            echo "  <a href=\"".$this->logo['url']."\" class=\"brand-logo\">".$this->logo['text']."</a>";
            
            reset($this->options);
            foreach($this->options as $option) {
                echo "<li onclick=\"".$option->getOnClick()."\" id=\"".$option->getId()."\" class=\"bold\"><a class=\"waves-effect waves-teal\">".$option->getText()."</a></li>";
            }
            echo "</ul>";
            reset($this->options);
        }
        
        protected function navigationBar() {
            $logo = array("text" => "Logo", "image" => "", "url" => "#");
            $options = array("Home" => "admin_panel.php", "Options" => array("attributes" => array("text" => "Options", "id" => "option-dropdown"), "content" => array("Manage Users" => "users.php", "Manage Rooms"=> "rooms.php", "Manage Bookings" => "bookings.php")), "Logout" => "logout.php");
            reset($options);
            foreach($options as $option) {
                if(is_array($option)) {
                    echo "<ul id=".$option['attributes']['id']." class=\"dropdown-content\">";
                    reset($option["content"]);
                    foreach($option["content"] as $contentText => $contentURL) {
                        echo "<li><a href=\"".$contentURL."\">".$contentText."</a></li>";
                    }
                    echo "</ul>";
                }
            }
            
            echo "<nav class=\"#01579b light-blue darken-4\">";
            echo "  <div class=\"nav-wrapper\">";
            echo "      <a href=\"".$logo['url']."\" class=\"brand-logo\">".$logo['text']."</a>";
            echo "      <a href=\"#\" data-activates=\"admin-sidenav\" class=\"button-collapse\"><i class=\"material-icons\">menu</i></a>";
            
            echo "      <ul id=\"admin-nav\" class=\"right hide-on-med-and-down\">";
            reset($options);
            foreach($options as $key => $value) {
                if(is_array($value)) {
                    echo "<li><a class=\"dropdown-button\" href=\"#!\" data-activates=\"".$value['attributes']['id']."\">".$key."<i class=\"material-icons right\">arrow_drop_down</i></a></li>";
                }
                else {
                    echo "<li><a href=\"".$value."\">".$key."</a></li>";
                }
            }
            echo "      </ul>";
            
            echo "      <ul id=\"admin-sidenav\" class=\"side-nav\">";
            reset($options);
            foreach($options as $key => $value) {
                if(is_array($value)) {
                    echo "<li><a class=\"dropdown-button\" href=\"#!\" data-activates=\"".$value['attributes']['id']."\">".$key."<i class=\"material-icons right\">arrow_drop_down</i></a></li>";
                }
                else {
                    echo "<li><a href=\"".$value."\">".$key."</a></li>";
                }
            }
            echo "      </ul>";
            
            echo "  </div>";
            echo "</nav>";
        }
        
        protected function scripts() {
            ?>
            <!--Import jQuery before materialize.js-->
            <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
            <script type="text/javascript" src="js/materialize.min.js"></script>
            <script>
                // Initialize Materialize Components
                $(document).ready(function(){
                    $('select').material_select();
                    $(".button-collapse").sideNav();
                });
                
                function getXMLHTTPRequest() {
                    var req = false;
                    try {
                        /* for Firefox */
                        req = new XMLHttpRequest();
                    } catch (err) {
                        try {
                            /* for some versions of IE */
                            req = new ActiveXObject("Msxml2.XMLHTTP");
                        } catch (err) {
                            try {
                            /* for some other versions of IE */
                                req = new ActiveXObject("Microsoft.XMLHTTP");
                            } catch (err) {
                                req = false;
                            }
                        }
                    }
                    return req;
                }
                
                var content = document.getElementById(<?php echo "\"".$this->contentId."\""; ?>);
                
                function getUsersContent() {
                    
                    var header = "<h5>Users<h5><hr />";
                    var createUserButton = "<button data-target=\"create-user-modal\" class=\"btn waves-effect waves-light create-user-modal-trigger\">Create User</button>";
                    
                    var searchUser = "<div class=\"input-field col s4 right\"><input id=\"search-user\" type=\"search\"><label style=\"font-size:24px;\" for=\"search-user\"><i class=\"material-icons\">search</i>SEARCH USER</label><i class=\"material-icons\">close</i></div>";
                    
                    var userList = "<div id=\"user-list\"></div>";
                    
                    content.innerHTML = header + createUserButton + searchUser + userList;
                    
                    $(".create-user-modal-trigger").leanModal({
                        dismissible: true, // Modal can be dismissed by clicking outside of the modal
                        opacity: .5, // Opacity of modal background
                        in_duration: 300, // Transition in duration
                        out_duration: 200, // Transition out duration
                        ready: function() { }, // Callback for Modal open
                        complete: function() { 
                            newUsername.value = "";
                            newPassword.value = "";
                            retypePassword.value = "";
                            fullName.value = "";
                            id.value = "";
                            phone.value = "";
                            email.value = "";
                            position.selectedIndex = 0;
                            department.selectedIndex = 0;
                            document.getElementById("type-user").checked = "checked";

                            newUsername.className = "";
                            newPassword.className = "";
                            retypePassword.className = "";
                            fullName.className = "";
                            id.className = "";
                            email.className = "validate";
                        
                        } // Callback for Modal close
                    });
                    
                    var dynamicContent = document.getElementById("user-list");
                    
                    updateUserList(0, 15, 1, dynamicContent);
                    
                    function updateUserList(page, userPerPage, user, userListContent) {
                        var ajaxRequest = getXMLHTTPRequest();
                        ajaxRequest.open("POST", "include/users.php", true);
                        ajaxRequest.onreadystatechange = response;
                        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        ajaxRequest.send();
                        
                        function response() {
                            if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                                userListContent.innerHTML = "hello";
                            }
                            else {
                                userListContent.innerHTML = "Loading...";
                            }
                        }
                        
                    } 
                    
                    
                    
                    
                    
                    
                }
            </script>
            <script>
                var newUsername = document.getElementById("new-username");
                var newPassword = document.getElementById("new-password");
                var retypePassword = document.getElementById("retype-password");
                var fullName = document.getElementById("full-name");
                var id = document.getElementById("id");
                var position = document.getElementById("position");
                var department = document.getElementById("department");
                var email = document.getElementById("email");
                var phone = document.getElementById("phone");

                var newUsernameLabel = document.getElementById("new-username-label");
                var newPasswordLabel = document.getElementById("new-password-label");
                var retypePasswordLabel = document.getElementById("retype-password-label");
                var fullNameLabel = document.getElementById("full-name-label");
                var idLabel = document.getElementById("id-label");
                var positionLabel = document.getElementById("position-label");
                var departmentLabel = document.getElementById("department-label");
                var emailLabel = document.getElementById("email-label");
                var phoneLabel = document.getElementById("phone-label");

                newUsername.onchange = function() {
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

                newPassword.onchange = function() {
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

                retypePassword.onchange = function() {
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

                fullName.onchange = function() {
                    var value = fullName.value;
                    if(value == "") {
                        fullName.className = "";
                        return;
                    }
                    else {
                        fullName.className = "valid";
                    }
                }
                
                id.onchange = function() {
                    var ajaxRequest = getXMLHTTPRequest();
                    var value = id.value;
                    
                    if(value == "") {
                        id.className = "";
                        return;
                    }
                    
                    if(id.className == "" || id.className == "valid") {
                        ajaxRequest.open("POST", "include/ajaxCheck.php", true);
                        ajaxRequest.onreadystatechange = response;
                        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        ajaxRequest.send("id=" + value);
                    }
                    
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
                
                phone.onchange = function() {
                    var ajaxRequest = getXMLHTTPRequest();
                    var value = phone.value;
                    var pattern = new RegExp("^[0-9]{7,}$");
                    var result = pattern.exec(value);
                    
                    
                    if(value == "") {
                        phone.className = "";
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
                
                

                email.onchange = function() {
                    var ajaxRequest = getXMLHTTPRequest();
                    var value = email.value;
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
                

                function validateRegistrationForm() {
                    var ajaxRequest = getXMLHTTPRequest();
                    
                    if(newUsername.className == "valid" && newPassword.className == "valid" && retypePassword.className == "valid" && fullName.className == "valid" && email.className == "validate valid" && id.className == "valid") {
                        
                        var data = {
                            username : newUsername.value,
                            password : newPassword.value,
                            fullName : fullName.value,
                            id : id.value,
                            phone : phone.value,
                            email : email.value,
                            position : position.options[position.selectedIndex].text,
                            department : department.options[department.selectedIndex].text,
                            type : document.getElementById("type-user").checked ? "user" : "admin"
                        }
                        
                        ajaxRequest.open("POST", "include/ajaxRegister.php", true);
                        ajaxRequest.onreadystatechange = response;
                        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        ajaxRequest.send("data=" + JSON.stringify(data));
                        
                        function response() {
                            if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                                if(ajaxRequest.responseText == "true") {
                                    
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
            </script>
            <?php
        }
    }

?>