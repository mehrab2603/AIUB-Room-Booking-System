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

    class Room {
        private $id, $floor, $campus, $capacity, $type;
        
        public function __construct($id, $floor, $campus, $capacity, $type) {
            $this->id = $id;
            $this->floor = $floor;
            $this->campus = $campus;
            $this->capacity = $capacity;
            $this->type = $type;
        }
        
        public function getId() {return $this->id;}
        public function getFloor() {return $this->floor;}
        public function getCampus() {return $this->campus;}
        public function getCapacity() {return $this->capacity;}
        public function getType() {return $this->type;}
    }

    class RoomSchedule {
        private $room, $day, $course, $start, $end;
        public function __construct($room, $day, $course, $start, $end) {
            $this->room = $room;
            $this->day = $day;
            $this->course = $course;
            $this->start = $start;
            $this->end = $end;
        }
        public function getRoom() {return $this->room;}
        public function getDay() {return $this->day;}
        public function getCourse() {return $this->course;}
        public function getStart() {return $this->start;}
        public function getEnd() {return $this->end;}
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
        private $content, $navBarId, $contentId, $pagination;
        private $logo;
        private $options;
        public function __construct($content) {
            $this->content = $content;
            $this->navBarId = "admin-nav";
            $this->contentId = "content-area";
            $this->logo = array("text" => "Logo", "image" => "", "url" => "#");
            $this->options = array(new Option("Users", "users", "getUsersContent()"), new Option("Rooms", "rooms", "getRoomsContent()"), new Option("Semester Schedule", "schedule", "getScheduleContent()"), new Option("Bookings", "bookings", "getBookingsContent()"), new Option("Logout", "logout", "getLogoutContent()"));
            $this->pagination = 5;
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
                                    <button class="btn waves-effect waves-light" type="button" onclick="return validateRegistrationForm('new-username', 'new-username-label', 'new-password', 'new-password-label', 'retype-password', 'retype-password-label', 'full-name', 'full-name-label', 'id', 'id-label', 'position', 'position-label', 'department', 'department-label', 'email', 'email-label', 'phone', 'phone-label');">Create</button>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div id="update-user-modal" class="modal">
                    <div class="modal-content">
                        <div class="row">
                            <h5 id="update-user-header">Edit User</h5>
                            <form id="update-user-form">
                                <div class="row">
                                    <div class="input-field col s12">

                                        <input type="text" id="edit-username" class="valid" placeholder="5 to 15 alpha-numeric characters or underscores or hyphens" required disabled>
                                        <label for="edit-username" id="edit-username-label" data-error="Error">Username</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="input-field col s12">

                                        <input type="password" id="edit-password" class="valid">
                                        <label for="edit-password" id="edit-password-label" data-error="Error">Password</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="text" id="edit-full-name" maxlength="100" placeholder="Maximum 100 characters" required>
                                        <label for="edit-full-name" id="edit-full-name-label">Full Name</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="text" id="edit-id" placeholder="Maximum 100 alphabetic characters or - or ." required>
                                        <label for="edit-id" id="edit-id-label">ID</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <select id="edit-position" required>
                                            <option value="1">Part Timer</option>
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
                                        <label for="edit-position" id="edit-position-label" data-error="Error">Position</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <select id="edit-department" required>
                                            <option value="1">Arts and Social Sciences</option>
                                            <option value="2">Business Administration</option>
                                            <option value="3">Engineering</option>
                                            <option value="4">Science and Information Technology
</option>
                                            <option value="5">Other</option>
                                        </select>
                                        <label for="edit-department" id="edit-department-label" data-error="Error">Department</label>
                                    </div>
                                </div>
                                
                                <div class="phone">
                                    <div class="input-field col s12">
                                        <input type="text" id="edit-phone" maxlength="40" placeholder="Valid phone number(At least 7 digits and only digits)" required>
                                        <label for="edit-phone" id="edit-phone-label" data-error="Error">Phone</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="email" class="validate" maxlength="100" id="edit-email" placeholder="Valid email address" required>
                                        <label for="edit-email" id="edit-email-label" data-error="Error">Email</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s1">
                                        <span>Type</span>
                                    </div>
                                    
                                    <div class="col s3">
                                        <div class="row">
                                            <div class="col s12">
                                                <input class="with-gap" name="edit-type" type="radio" id="edit-type-user"/>
                                                <label for="edit-type-user">User</label>
                                            </div>
                                            <div class="col s12">
                                                <input class="with-gap" name="edit-type" type="radio" id="edit-type-admin" />
                                                <label for="edit-type-admin">Admin</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row right">
                                    <button class="btn waves-effect waves-light red" type="button" onclick="$('#update-user-modal').closeModal();">Cancel</button>
                                    <button id="edit-save-button" class="btn waves-effect waves-light" type="button">Save</button>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="delete-user-modal" class="modal">
                    <div class="modal-content">
                        <div class="row">
                            <h5 id="delete-user-header">Delete User</h5>
                            <span>Are you sure? All information, including class booking information, related to this user will be deleted permanently.</span>
                        </div>
                        <div class="row right">
                                <button class="btn waves-effect waves-light red" type="button" onclick="$('#delete-user-modal').closeModal();">No</button>
                                <button id="delete-yes-button" class="btn waves-effect waves-light" type="button">Yes</button>

                        </div>
                    </div>
                </div>


                <div id="create-room-modal" class="modal">
                    <div class="modal-content">
                        <div class="row">
                            <h5 id="create-room-header">Create Room</h5>
                            <form id="create-room-form">
                                
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="text" id="room-id" maxlength="20" placeholder="Maximum 20 alphanumeric character or hyphen or space" required>
                                        <label for="room-id" id="room-id-label">Room ID</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="text" id="room-floor" maxlength="10" placeholder="Only numeric characters" required>
                                        <label for="room-floor" id="room-floor-label">Floor</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="text" id="room-campus" maxlength="10" placeholder="Only numeric characters" required>
                                        <label for="room-campus" id="room-campus-label">Campus</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="text" id="room-capacity" maxlength="10" placeholder="Only numeric characters" required>
                                        <label for="room-capacity" id="room-capacity-label">Capacity</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <select id="room-type" required>
                                            <option value="1" selected>Theory</option>
                                            <option value="2">Lab(Computer)</option>
                                            <option value="3">Lab(Electronics)</option>
                                            <option value="4">Lab(Natural Science)</option>
                                            <option value="5">Other</option>
                                        </select>
                                        <label for="room-type" id="room-type-label" data-error="Error">Type</label>
                                    </div>
                                </div>
                                
                                


                                <div class="row right">
                                    <button class="btn waves-effect waves-light red" type="button" onclick="$('#create-room-modal').closeModal();">Cancel</button>
                                    <button class="btn waves-effect waves-light" type="button" id="create-room-button">Create</button>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="update-room-modal" class="modal">
                    <div class="modal-content">
                        <div class="row">
                            <h5 id="update-room-header">Edit Room</h5>
                            <form id="update-room-form">
                                
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="text" id="update-room-id" maxlength="20" placeholder="Maximum 20 alphanumeric character or hyphen or space" required>
                                        <label for="update-room-id" id="update-room-id-label">Room ID</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="text" id="update-room-floor" maxlength="10" placeholder="Only numeric characters" required>
                                        <label for="update-room-floor" id="update-room-floor-label">Floor</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="text" id="update-room-campus" maxlength="10" placeholder="Only numeric characters" required>
                                        <label for="update-room-campus" id="update-room-campus-label">Campus</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="text" id="update-room-capacity" maxlength="10" placeholder="Only numeric characters" required>
                                        <label for="update-room-capacity" id="update-room-capacity-label">Capacity</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <select id="update-room-type" required>
                                            <option value="1" selected>Theory</option>
                                            <option value="2">Lab(Computer)</option>
                                            <option value="3">Lab(Electronics)</option>
                                            <option value="4">Lab(Natural Science)</option>
                                            <option value="5">Other</option>
                                        </select>
                                        <label for="update-room-type" id="update-room-type-label" data-error="Error">Type</label>
                                    </div>
                                </div>
                                
                                


                                <div class="row right">
                                    <button class="btn waves-effect waves-light red" type="button" onclick="$('#update-room-modal').closeModal();">Cancel</button>
                                    <button class="btn waves-effect waves-light" type="button" id="update-room-save-button">Save</button>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="delete-room-modal" class="modal">
                    <div class="modal-content">
                        <div class="row">
                            <h5 id="delete-room-header">Delete Room</h5>
                            <span>Are you sure? All information, including class booking information, related to this room will be deleted permanently.</span>
                        </div>
                        <div class="row right">
                                <button class="btn waves-effect waves-light red" type="button" onclick="$('#delete-room-modal').closeModal();">No</button>
                                <button id="room-delete-yes-button" class="btn waves-effect waves-light" type="button">Yes</button>

                        </div>
                    </div>
                </div>

                
                <div id="create-schedule-modal" class="modal">
                    <div class="modal-content">
                        <div class="row">
                            <h5 id="create-schedule-header">Create Schedule</h5>
                            <form id="create-schedule-form">
                                
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="text" id="schedule-course" maxlength="20" placeholder="Maximum 20 alphanumeric character or hyphen or space" required>
                                        <label for="schedule-course" id="schedule-course-label">Course</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <select id="schedule-start" required>
                                            <option value="1" selected>8:00 AM</option>
                                            <option value="2">8:30 AM</option>
                                            <option value="3">9:00 AM</option>
                                            <option value="4">9:30 AM</option>
                                            <option value="5">10:00 AM</option>
                                            <option value="6">10:30 AM</option>
                                            <option value="7">11:00 AM</option>
                                            <option value="8">11:30 AM</option>
                                            <option value="9">12:00 PM</option>
                                            <option value="10">12:30 PM</option>
                                            <option value="11">1:00 PM</option>
                                            <option value="12">1:30 PM</option>
                                            <option value="13">2:00 PM</option>
                                            <option value="14">2:30 PM</option>
                                            <option value="15">3:00 PM</option>
                                            <option value="16">3:30 PM</option>
                                            <option value="17">4:00 PM</option>
                                            <option value="18">4:30 PM</option>
                                            <option value="19">5:00 PM</option>
                                            <option value="20">5:30 PM</option>
                                            <option value="21">6:00 PM</option>
                                            <option value="22">6:30 PM</option>
                                            <option value="23">7:00 PM</option>
                                            <option value="24">7:30 PM</option>
                                            <option value="25">8:00 PM</option>
                                            <option value="26">8:30 PM</option>
                                            <option value="27">9:00 PM</option>
                                            <option value="28">9:30 PM</option>
                                            
                                        </select>
                                        <label for="schedule-start" id="schedule-start-label" data-error="Error">From</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <select id="schedule-end" required>
                                            <option value="2" selected>8:30 AM</option>
                                            <option value="3">9:00 AM</option>
                                            <option value="4">9:30 AM</option>
                                            <option value="5">10:00 AM</option>
                                            <option value="6">10:30 AM</option>
                                            <option value="7">11:00 AM</option>
                                            <option value="8">11:30 AM</option>
                                            <option value="9">12:00 PM</option>
                                            <option value="10">12:30 PM</option>
                                            <option value="11">1:00 PM</option>
                                            <option value="12">1:30 PM</option>
                                            <option value="13">2:00 PM</option>
                                            <option value="14">2:30 PM</option>
                                            <option value="15">3:00 PM</option>
                                            <option value="16">3:30 PM</option>
                                            <option value="17">4:00 PM</option>
                                            <option value="18">4:30 PM</option>
                                            <option value="19">5:00 PM</option>
                                            <option value="20">5:30 PM</option>
                                            <option value="21">6:00 PM</option>
                                            <option value="22">6:30 PM</option>
                                            <option value="23">7:00 PM</option>
                                            <option value="24">7:30 PM</option>
                                            <option value="25">8:00 PM</option>
                                            <option value="26">8:30 PM</option>
                                            <option value="27">9:00 PM</option>
                                            <option value="28">9:30 PM</option>
                                            <option value="29">10:00 PM</option>
                                            
                                        </select>
                                        <label for="schedule-end" id="schedule-end-label" data-error="Error">To</label>
                                    </div>
                                </div>
                                
                                


                                <div class="row right">
                                    <button class="btn waves-effect waves-light red" type="button" onclick="$('#create-schedule-modal').closeModal();">Cancel</button>
                                    <button class="btn waves-effect waves-light" type="button" id="create-schedule-button">Create</button>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="edit-schedule-modal" class="modal">
                    <div class="modal-content">
                        <div class="row">
                            <h5 id="edit-schedule-header">Edit Schedule</h5>
                            <form id="edit-schedule-form">
                                
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="text" id="edit-schedule-course" maxlength="20" placeholder="Maximum 20 alphanumeric character or hyphen or space" required>
                                        <label for="edit-schedule-course" id="edit-schedule-course-label">Course</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <select id="edit-schedule-start" required>
                                            <option value="1" selected>8:00 AM</option>
                                            <option value="2">8:30 AM</option>
                                            <option value="3">9:00 AM</option>
                                            <option value="4">9:30 AM</option>
                                            <option value="5">10:00 AM</option>
                                            <option value="6">10:30 AM</option>
                                            <option value="7">11:00 AM</option>
                                            <option value="8">11:30 AM</option>
                                            <option value="9">12:00 PM</option>
                                            <option value="10">12:30 PM</option>
                                            <option value="11">1:00 PM</option>
                                            <option value="12">1:30 PM</option>
                                            <option value="13">2:00 PM</option>
                                            <option value="14">2:30 PM</option>
                                            <option value="15">3:00 PM</option>
                                            <option value="16">3:30 PM</option>
                                            <option value="17">4:00 PM</option>
                                            <option value="18">4:30 PM</option>
                                            <option value="19">5:00 PM</option>
                                            <option value="20">5:30 PM</option>
                                            <option value="21">6:00 PM</option>
                                            <option value="22">6:30 PM</option>
                                            <option value="23">7:00 PM</option>
                                            <option value="24">7:30 PM</option>
                                            <option value="25">8:00 PM</option>
                                            <option value="26">8:30 PM</option>
                                            <option value="27">9:00 PM</option>
                                            <option value="28">9:30 PM</option>
                                            
                                        </select>
                                        <label for="edit-schedule-start" id="edit-schedule-start-label" data-error="Error">From</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <select id="edit-schedule-end" required>
                                            <option value="2" selected>8:30 AM</option>
                                            <option value="3">9:00 AM</option>
                                            <option value="4">9:30 AM</option>
                                            <option value="5">10:00 AM</option>
                                            <option value="6">10:30 AM</option>
                                            <option value="7">11:00 AM</option>
                                            <option value="8">11:30 AM</option>
                                            <option value="9">12:00 PM</option>
                                            <option value="10">12:30 PM</option>
                                            <option value="11">1:00 PM</option>
                                            <option value="12">1:30 PM</option>
                                            <option value="13">2:00 PM</option>
                                            <option value="14">2:30 PM</option>
                                            <option value="15">3:00 PM</option>
                                            <option value="16">3:30 PM</option>
                                            <option value="17">4:00 PM</option>
                                            <option value="18">4:30 PM</option>
                                            <option value="19">5:00 PM</option>
                                            <option value="20">5:30 PM</option>
                                            <option value="21">6:00 PM</option>
                                            <option value="22">6:30 PM</option>
                                            <option value="23">7:00 PM</option>
                                            <option value="24">7:30 PM</option>
                                            <option value="25">8:00 PM</option>
                                            <option value="26">8:30 PM</option>
                                            <option value="27">9:00 PM</option>
                                            <option value="28">9:30 PM</option>
                                            <option value="29">10:00 PM</option>
                                            
                                        </select>
                                        <label for="edit-schedule-end" id="edit-schedule-end-label" data-error="Error">To</label>
                                    </div>
                                </div>
                                
                                


                                <div class="row right">
                                    <button class="btn waves-effect waves-light red" type="button" onclick="$('#edit-schedule-modal').closeModal();">Cancel</button>
                                    <button class="btn waves-effect waves-light" type="button" id="edit-schedule-button">Save</button>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="delete-schedule-modal" class="modal">
                    <div class="modal-content">
                        <div class="row">
                            <h5 id="delete-schedule-header">Delete Schedule</h5>
                            <span>Are you sure? All information related to this schedule will be deleted permanently.</span>
                        </div>
                        <div class="row right">
                                <button class="btn waves-effect waves-light red" type="button" onclick="$('#delete-schedule-modal').closeModal();">No</button>
                                <button id="delete-schedule-yes-button" class="btn waves-effect waves-light" type="button">Yes</button>

                        </div>
                    </div>
                </div>

                <div id="delete-all-schedule-modal" class="modal">
                    <div class="modal-content">
                        <div class="row">
                            <h5 id="delete-all-schedule-header">Delete All Schedule</h5>
                            <span>Are you sure? All information will be deleted permanently.</span>
                        </div>
                        <div class="row right">
                                <button class="btn waves-effect waves-light red" type="button" onclick="$('#delete-all-schedule-modal').closeModal();">No</button>
                                <button id="delete-all-schedule-yes-button" class="btn waves-effect waves-light" type="button">Yes</button>

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
                var pagination = "<?php echo $this->pagination; ?>";
                pagination = parseInt(pagination);
                
                var currentUserPage, currentRoomPage, currentSchedulePage;
                
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
            </script>

            <script>
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
            </script>
            <script>
                var scheduleRoom, scheduleDay;
                
                function getScheduleContent() {
                    var temp = "<h4>Semester Schedule</h4><hr />" +
                               "<div style=\"height:70vmin; \" class=\"valign-wrapper\">" +
                               "    <div class=\"valign\" style=\"margin: 0 auto;\">" +
                               "        <table>" +
                               "            <tr>" +
                               "                <td><span>Select a room</span></td>" +
                               "                <td><select id=\"schedule-room-select\"></select></td>" +
                               "            </tr>" +
                               "            <tr>" +
                               "                <td><span>Select a day</span></td>" +
                               "                <td><select id=\"schedule-day-select\"></select></td>" +
                               "            </tr>" +
                               "            <tr><td style=\"text-align: right;\" colspan=\"2\"><a id=\"schedule-next-button\" class=\"waves-effect waves-light btn disabled\"><i class=\"material-icons right\">send</i>Next</a></td></tr>" +
                               "        </table>" +
                               "    </div>" +
                               "</div>";
                    
                    content.innerHTML = temp;
                    
                    var dayArray = ["Saturday", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];
                    
                    var roomSelect = document.getElementById("schedule-room-select");
                    var daySelect = document.getElementById("schedule-day-select");
                    var nextButton = document.getElementById("schedule-next-button");
                    
                    for (var i = 0; i < dayArray.length; i++) {
                        var option = document.createElement("option");
                        option.value = dayArray[i];
                        option.text = dayArray[i];
                        daySelect.appendChild(option);
                    }
                    
                    ajaxRequest = getXMLHTTPRequest();
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
                                roomSelect.appendChild(option);
                            }
                            
                            nextButton.className = "waves-effect waves-light btn";
                            $('select').material_select();
                            
                            nextButton.onclick = function() {getRoomScheduleContent(roomSelect.value, daySelect.value);};
                        }
                    }
                            
                }
                
                function getRoomScheduleContent(room, day) {
                    scheduleRoom = room;
                    scheduleDay = day;
                    
                    var temp = "<h4>Semester Schedule of " + room + " on " + day + "s</h4><hr />" +
                               "    <div class=\"col s12\">" + 
                               "        <button data-target=\"create-schedule-modal\" class=\"btn col s12 waves-effect waves-light create-schedule-modal-trigger\">Create Schedule</button>" +
                               "        <button data-target=\"delete-all-schedule-modal\" class=\"btn col s12 waves-effect waves-light delete-all-schedule-modal-trigger\">Delete All Schedule</button>" + 
                               "    </div>" +
                               "    <div class=\"col s12\" >" +
                               "        <table id=\"schedule-list-table\" class=\"responsive-table striped\">" +
                               "            <thead>" +
                               "                <tr><th colspan=\"4\">Schedule List</th></tr>" +
                               "                <tr>" +
                               "                    <th data-field=\"course\">Course</th>" +
                               "                    <th data-field=\"start\">From</th>" +
                               "                    <th data-field=\"end\">To</th>" +
                               "                    <th data-field=\"options\"></th>" +
                               "                </tr>" +
                               "            </thead><tbody id=\"schedule-list-table-body\"></tbody>" +
                               "        </table>" +
                               "    </div>" +
                               "    <div id=\"schedule-pagination-area\"></div>" +
                               "</div>";
                    
                    
                    content.innerHTML = temp;
                    
                    $(".create-schedule-modal-trigger").leanModal({
                        dismissible: true, // Modal can be dismissed by clicking outside of the modal
                        opacity: .5, // Opacity of modal background
                        in_duration: 300, // Transition in duration
                        out_duration: 200, // Transition out duration
                        ready: function() { }, // Callback for Modal open
                        complete: function() { 
                            document.getElementById("create-schedule-form").reset();
                        }
                    });
                    $(".delete-all-schedule-modal-trigger").leanModal({
                        dismissible: true, // Modal can be dismissed by clicking outside of the modal
                        opacity: .5, // Opacity of modal background
                        in_duration: 300, // Transition in duration
                        out_duration: 200, // Transition out duration
                        ready: function() { }, // Callback for Modal open
                        complete: function() { }
                    });
                    
                    document.getElementById("schedule-course").onchange = function() {validateScheduleCourse("schedule-course", "schedule-course-label");};
                    document.getElementById("create-schedule-button").onclick = function() {validateScheduleForm("schedule-course", "schedule-start", "schedule-end");};
                    
                    document.getElementById("delete-all-schedule-yes-button").onclick = function() {
                        var ajaxRequest = getXMLHTTPRequest();
                        ajaxRequest.open("POST", "include/ajaxDeleteSchedule.php", true);
                        ajaxRequest.onreadystatechange = response;
                        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        ajaxRequest.send("all=true&room=" + scheduleRoom + "&day=" + scheduleDay);
                        
                        function response() {
                            if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                                if(ajaxRequest.responseText == "true") {
                                    updateScheduleList(currentSchedulePage, pagination);
                                    $('#delete-all-schedule-modal').closeModal();
                                    Materialize.toast('Deleted all schedule!', 2000);
                                }
                                else {
                                    Materialize.toast('Failed to delete all schedule!', 2000);
                                }
                            }
                        }
                        
                    };
                    
                    updateScheduleList(0, pagination);
                }
                
                function validateScheduleCourse(id, label, old) {
                    var course = document.getElementById(id);
                    var courseLabel = document.getElementById(label);
                    var pattern = /^[a-z\d\-\s]+$/i;
                    var value = course.value;
                    var result = pattern.exec(value);
                    var ajaxRequest = getXMLHTTPRequest();
                    
                    if(value == "") {
                        course.className = "";
                    }
                    else if(old != null && old == value) {
                        course.className = "valid";
                    }
                    else if(result == null) {
                        courseLabel.setAttribute("data-error", "Error");
                        course.className = "invalid";
                    }
                    else {
                        ajaxRequest.open("POST", "include/ajaxCheck.php", true);
                        ajaxRequest.onreadystatechange = response;
                        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        ajaxRequest.send("course=" + value + "&room=" + scheduleRoom + "&day=" + scheduleDay);
                        
                        function response() {
                            if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                                var courseAlreadyAssigned = ajaxRequest.responseXML.getElementsByTagName("schedule")[0].childNodes[0].nodeValue;
                                if(courseAlreadyAssigned == "true") {
                                    courseLabel.setAttribute("data-error", "Exists");
                                    course.className = "invalid";
                                }
                                else {
                                    courseLabel.setAttribute("data-error", "Error");
                                    course.className = "valid";
                                }
                            }
                        }
                        
                    }
                }
                
                function validateScheduleForm(course, start, end) {
                    course = document.getElementById(course);
                    start = document.getElementById(start);
                    end = document.getElementById(end);
                    
                    var ajaxRequest = getXMLHTTPRequest();
                    
                    if(course.className == "valid") {
                        if(parseInt(start.value) < parseInt(end.value)) {
                            var data = {
                                room : scheduleRoom,
                                day : scheduleDay,
                                course : course.value,
                                start : start.value,
                                end : parseInt(end.value) - 1
                            }
                            
                            
                            ajaxRequest.open("POST", "include/ajaxRegisterSchedule.php", true);
                            ajaxRequest.onreadystatechange = response;
                            ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                            ajaxRequest.send("data=" + JSON.stringify(data));

                            function response() {
                                if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                                    if(ajaxRequest.responseText == "clash") {
                                        alert("Selected timing has clash!");
                                    }
                                    else if(ajaxRequest.responseText == "true") {
                                        
                                        document.getElementById("create-schedule-form").reset();
                                        
                                        updateScheduleList(currentSchedulePage, pagination);
                                        
                                        $('#create-schedule-modal').closeModal();
                                        Materialize.toast('Schedule created successfully!', 2000);
                                    }
                                    else if(ajaxRequest.response == "false") {
                                        Materialize.toast('Failed to create schedule!', 2000);
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
                
                var timeBlock = {
                    1 : "8:00 AM",
                    2 : "8:30 AM",
                    3 : "9:00 AM",
                    4 : "9:30 AM",
                    5 : "10:00 AM",
                    6 : "10:30 AM",
                    7 : "11:00 AM",
                    8 : "11:30 AM",
                    9 : "12:00 PM",
                    10 : "12:30 PM",
                    11 : "1:00 PM",
                    12 : "1:30 PM",
                    13 : "2:00 PM",
                    14 : "2:30 PM",
                    15 : "3:00 PM",
                    16 : "3:30 PM",
                    17 : "4:00 PM",
                    18 : "4:30 PM",
                    19 : "5:00 PM",
                    20 : "5:30 PM",
                    21 : "6:00 PM",
                    22 : "6:30 PM",
                    23 : "7:00 PM",
                    24 : "7:30 PM",
                    25 : "8:00 PM",
                    26 : "8:30 PM",
                    27 : "9:00 PM",
                    28 : "9:30 PM",
                    29 : "10:00 PM"
                }
                
                function updateScheduleList(page, schedulePerPage) {
                    var ajaxRequest = getXMLHTTPRequest();
                    ajaxRequest.open("POST", "include/ajaxGetSchedule.php", true);
                    ajaxRequest.onreadystatechange = response;
                    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    ajaxRequest.send("page=" + page + "&schedulePerPage=" + schedulePerPage + "&room=" + scheduleRoom + "&day=" + scheduleDay);
                    
                    
                    var table = document.getElementById("schedule-list-table-body");
                    
                    function response() {
                        if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                            var response = ajaxRequest.responseXML;
                            if(response == null) {table.innerHTML = ""; document.getElementById("schedule-pagination-area").innerHTML = ""; return;}
                            var pageRequired = response.getElementsByTagName("pageRequired")[0].childNodes[0].nodeValue;
                            
                            var schedule = response.getElementsByTagName("schedule");
                            
                            table.innerHTML = "";
                            
                            for(var i = 0; i < schedule.length; i++) {
                                var course = schedule[i].getElementsByTagName("course")[0].childNodes[0].nodeValue;
                                var start = schedule[i].getElementsByTagName("start")[0].childNodes[0].nodeValue;
                                var end = schedule[i].getElementsByTagName("end")[0].childNodes[0].nodeValue;
                                
                                var row = table.insertRow(i);
                                var courseCell = row.insertCell(0);
                                var startCell = row.insertCell(1);
                                var endCell = row.insertCell(2);
                                var optionCell = row.insertCell(3);
                                
                                courseCell.innerHTML = course;
                                startCell.innerHTML = timeBlock[start];
                                endCell.innerHTML = timeBlock[parseInt(end) + 1];
                                
                                optionCell.innerHTML = "<div class=\"right\"><a class=\"waves-effect waves-light btn\" onclick=\"return showEditSchedule('" + course + "', '"+ start +"', '" + (parseInt(end) + 1) + "');\">Edit Schedule</a><a class=\"waves-effect waves-light btn\" onclick=\"return showDeleteSchedule('" + course + "', '"+ start +"', '" + (parseInt(end) + 1) + "');\">Delete Schedule</a></div>";
                            }
                            
                            if(page >= pageRequired) page = pageRequired - 1;
                            else if(page < 0) page = 0;
                            
                            currentSchedulePage = page;
                            
                            var paginationHTML = "<ul class=\"pagination\">";
                            if(page - 1 < 0) paginationHTML = paginationHTML + "<li class=\"disabled\"><a href=\"#\"><i class=\"material-icons\">chevron_left</i></a></li>";
                            else paginationHTML = paginationHTML + "<li onclick=\"updateScheduleList(" + (page - 1) + ", " + pagination + ");\"><a href=\"#\"><i class=\"material-icons\">chevron_left</i></a></li>";
                            
                            for(var i = 0; i < pageRequired; i++) {
                                if(i == page) paginationHTML = paginationHTML + "<li class=\"active\" onclick=\"updateScheduleList(" + i + ", " + pagination + ");\"><a href=\"#\">" + (i + 1) + "</a></li>";
                                else paginationHTML = paginationHTML + "<li onclick=\"updateScheduleList(" + i + ", " + pagination + ");\"><a href=\"#\">" + (i + 1) + "</a></li>";
                            }
                            
                            if(page + 1 >= pageRequired) paginationHTML = paginationHTML + "<li class=\"disabled\"><a href=\"#\"><i class=\"material-icons\">chevron_right</i></a></li>";
                            else paginationHTML = paginationHTML + "<li onclick=\"updateScheduleList(" + (page + 1) + ", " + pagination + ");\"><a href=\"#\"><i class=\"material-icons\">chevron_right</i></a></li>";
                            
                            paginationHTML = paginationHTML + "</ul>";
                            
                            document.getElementById("schedule-pagination-area").innerHTML = "<div class=\"right\">" + paginationHTML + "</div>";
                        }
                    }
                }
                
                function showEditSchedule(courseValue, startValue, endValue) {
                    $('#edit-schedule-modal').openModal();
                    
                    var course = document.getElementById("edit-schedule-course");
                    var start = document.getElementById("edit-schedule-start");
                    var end = document.getElementById("edit-schedule-end");
                    var button = document.getElementById("edit-schedule-button");
                    
                    course.className = "valid";
                    
                    course.value = courseValue;
                    start.value = startValue;
                    end.value = endValue;
                    
                    $('select').material_select();
                    
                    course.onchange = function() {validateScheduleCourse("edit-schedule-course", "edit-schedule-course-label", courseValue);};
                    button.onclick = function() {
                        if(course.className == "valid") {
                            if(parseInt(start.value) < parseInt(end.value)) {
                                var data = {
                                    room : scheduleRoom,
                                    day : scheduleDay,
                                    course : course.value,
                                    start : start.value,
                                    end : parseInt(end.value) - 1
                                }
                                
                                var oldData = {
                                    room : scheduleRoom,
                                    day : scheduleDay,
                                    course : courseValue,
                                    start : startValue,
                                    end : endValue - 1
                                }


                                ajaxRequest.open("POST", "include/ajaxUpdateSchedule.php", true);
                                ajaxRequest.onreadystatechange = response;
                                ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                ajaxRequest.send("data=" + JSON.stringify(data) + "&old=" + JSON.stringify(oldData));

                                function response() {
                                    if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                                        console.log(ajaxRequest.responseText);
                                        if(ajaxRequest.responseText == "clash") {
                                            alert("Selected timing has clash!");
                                        }
                                        else if(ajaxRequest.responseText == "true") {

                                            document.getElementById("edit-schedule-form").reset();

                                            updateScheduleList(currentSchedulePage, pagination);

                                            $('#edit-schedule-modal').closeModal();
                                            Materialize.toast('Schedule edited successfully!', 2000);
                                        }
                                        else if(ajaxRequest.response == "false") {
                                            Materialize.toast('Failed to edit schedule!', 2000);
                                        }
                                    }
                                }
                            }
                            else {
                                alert("Invalid time range selected!");
                            }
                        }
                    };
                }
                
                function showDeleteSchedule(courseValue, startValue, endValue) {
                    $('#delete-schedule-modal').openModal();
                    
                    var button = document.getElementById("delete-schedule-yes-button");
                    
                    button.onclick = function() {
                        var data = {
                            room : scheduleRoom,
                            day : scheduleDay,
                            course : courseValue,
                            start : startValue,
                            end : endValue - 1
                        }
                        
                        var ajaxRequest = getXMLHTTPRequest();
                        ajaxRequest.open("POST", "include/ajaxDeleteSchedule.php", true);
                        ajaxRequest.onreadystatechange = response;
                        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        ajaxRequest.send("data=" + JSON.stringify(data));
                        
                        function response() {
                            if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                                console.log(ajaxRequest.responseText);
                                if(ajaxRequest.responseText == "true") {
                                    updateScheduleList(currentUserPage, pagination);
                                    $('#delete-schedule-modal').closeModal();
                                    Materialize.toast('Deleted schedule!', 2000);
                                }
                                else {
                                    Materialize.toast('Failed to delete schedule!', 2000);
                                }
                            }
                        }
                    };
                }
                
                
            </script>
            <?php
        }
    }

?>