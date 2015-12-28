<?php
require "include/database.php";
session_start();

$db = new Database();

if(isset($_COOKIE["user"])) $_SESSION["user"] = $db->getUser($_COOKIE["user"]);

if(isset($_SESSION["user"])) {
    if($_SESSION["user"]->getType() == "admin") header("Location: admin_panel.php");
    else header("Location: user_panel.php");
}

?>

<!DOCTYPE html>
<html>
    <head>
        <!--Import Google Icon Font-->
        <link type="text/css" rel="stylesheet" href="css/material_icons.css">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        <!--Import styles.css-->
        <link type="text/css" rel="stylesheet" href="css/styles.css"  media="screen,projection"/>

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body>
        <div class="container">
            <div class="valign-wrapper row" style="height:100vmin;">
                <div style="margin: 0 auto; text-align: center"><h2>AIUB Room Booking System</h2></div>
                <div class="valign center col s5" style="margin: 0 auto;">
                    <form>
                        <div class="row">
                            <span style="text-align:center;"><h5>Login</h5></span>
                        </div>

                        <div class="input-field row">
                            <label for="login-username">Username</label>
                            <input placeholder="Username" class="col s12" id="login-username" type="text" />
                        </div>
                        
                        <div class="input-field row">
                            <label for="login-password">Password</label>
                            <input placeholder="Password" class="col s12" id="login-password" type="password" />
                        </div>
                        <div class="input-field row right">
                            <input class="col s12" type="checkbox" id="login-remember" />
                            <label for="login-remember">Remember Me</label>
                        </div>
                        <div class="row">
                            <a class="waves-effect waves-light btn col s12" onclick="validateLoginForm();">Login</a>
                        </div>
                        <a class="waves-effect waves-light create-user-modal-trigger" data-target="create-user-modal" >Not a member? Register</a>

                    </form>
                </div>
            </div>
        </div>
        
        
        <div id="create-user-modal" class="modal">
            <div class="modal-content">
                <div class="row">
                    <h5 id="create-user-header">Create User</h5>
                    <form id="create-user-form">
                        <div class="row">
                            <div class="input-field col s12">

                                <input type="text" id="new-username" onchange="return validateUsername('new-username', 'new-username-label');" placeholder="5 to 15 alpha-numeric characters or underscores or hyphens" required>
                                <label for="new-username" id="new-username-label" data-error="Error">Username</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">

                                <input type="password" id="new-password" onchange="return validatePassword('new-password', 'new-password-label', 'retype-password', 'retype-password-label');" required>
                                <label for="new-password" id="new-password-label" data-error="Error">Password</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">

                                <input type="password" id="retype-password" onchange="return validateRetypePassword('retype-password', 'retype-password-label', 'new-password', 'new-password-label');" required>
                                <label for="retype-password" id="retype-password-label">Retype Password</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <input type="text" id="full-name" onchange="return validateFullname('full-name', 'full-name-label');" maxlength="100" placeholder="Maximum 100 characters" required>
                                <label for="full-name" id="full-name-label">Full Name</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <input type="text" id="id" onchange="return validateId('id', 'id-label');" placeholder="Maximum 100 alphabetic characters or - or ." required>
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
                                <input type="text" id="phone" onchange="return validatePhone('phone', 'phone-label');" maxlength="40" placeholder="Valid phone number(At least 7 digits and only digits)" required>
                                <label for="phone" id="phone-label" data-error="Error">Phone</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <input type="email" class="validate" maxlength="100" id="email" onchange="return validateEmail('email', 'email-label');" placeholder="Valid email address" required>
                                <label for="email" id="email-label" data-error="Error">Email</label>
                            </div>
                        </div>


                        <div class="row right">
                            <button class="btn waves-effect waves-light red" type="button" onclick="$('#create-user-modal').closeModal();">Cancel</button>
                            <button class="btn waves-effect waves-light" type="button" onclick="return validateRegistrationForm('new-username', 'new-username-label', 'new-password', 'new-password-label', 'retype-password', 'retype-password-label', 'full-name', 'full-name-label', 'id', 'id-label', 'position', 'position-label', 'department', 'department-label', 'email', 'email-label', 'phone', 'phone-label');">Create</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        
        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        <script>
            
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
        
        </script>
        <script type="text/javascript" src="js/index.js"></script>
    </body>
</html>
