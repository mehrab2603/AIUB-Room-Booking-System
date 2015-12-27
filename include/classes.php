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

    class Booking {
        private $id, $room, $user, $course, $start, $end, $classDate, $type;
        public function __construct($id, $room, $user, $course, $start, $end, $classDate, $type) {
            $this->id = $id;
            $this->room = $room;
            $this->user = $user;
            $this->course = $course;
            $this->start = $start;
            $this->end = $end;
            $this->classDate = $classDate;
            $this->type = $type;
        }
        public function getId() {return $this->id;}
        public function getRoom() {return $this->room;}
        public function getUser() {return $this->user;}
        public function getCourse() {return $this->course;}
        public function getStart() {return $this->start;}
        public function getEnd() {return $this->end;}
        public function getClassDate() {return $this->classDate;}
        public function getType() {return $this->type;}
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



                <div id="create-booking-modal" class="modal">
                    <div class="modal-content">
                        <div class="row">
                            <h5 id="create-booking-header">Create Booking</h5>
                            <form id="create-booking-form">
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <select id="create-booking-room" required>
                                            
                                        </select>
                                        <label for="create-booking-room" id="create-booking-room-label" data-error="Error">Room</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <select id="create-booking-user" required>
                                            
                                        </select>
                                        <label for="create-booking-user" id="create-booking-user-label" data-error="Error">User</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="text" id="create-booking-course" maxlength="20" placeholder="Maximum 20 alphanumeric character or hyphen or space" required>
                                        <label for="create-booking-course" id="create-booking-course-label">Course</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <select id="create-booking-start" required>
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
                                        <label for="create-booking-start" id="create-booking-start-label" data-error="Error">From</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <select id="create-booking-end" required>
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
                                        <label for="create-booking-end" id="create-booking-end-label" data-error="Error">To</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="date" class="datepicker" id="create-booking-date" required>
                                        <label for="create-booking-date" id="create-booking-date-label">Date</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s1">
                                        <span>Type</span>
                                    </div>
                                    <div class="col s5">
                                        <div class="row">
                                            <div class="col s12">
                                                <input class="with-gap" name="create-booking-type" type="radio" id="create-booking-type-makeup" checked="checked"/>
                                                <label for="create-booking-type-makeup">Make Up</label>
                                            </div>
                                            <div class="col s12">
                                                <input class="with-gap" name="create-booking-type" type="radio" id="create-booking-type-advanced-makeup" />
                                                <label for="create-booking-type-advanced-makeup">Advance Make Up</label>
                                            </div>
                                            <div class="col s12">
                                                <input class="with-gap" name="create-booking-type" type="radio" id="create-booking-type-other" />
                                                <label for="create-booking-type-other">Other</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                


                                <div class="row right">
                                    <button class="btn waves-effect waves-light red" type="button" onclick="$('#create-booking-modal').closeModal();">Cancel</button>
                                    <button class="btn waves-effect waves-light disabled" type="button" id="create-booking-button">Create</button>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="edit-booking-modal" class="modal">
                    <div class="modal-content">
                        <div class="row">
                            <h5 id="edit-booking-header">Edit Booking</h5>
                            <form id="edit-booking-form">
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <select id="edit-booking-room" required>
                                            
                                        </select>
                                        <label for="edit-booking-room" id="edit-booking-room-label" data-error="Error">Room</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <select id="edit-booking-user" required>
                                            
                                        </select>
                                        <label for="edit-booking-user" id="edit-booking-user-label" data-error="Error">User</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="text" id="edit-booking-course" maxlength="20" placeholder="Maximum 20 alphanumeric character or hyphen or space" required>
                                        <label for="edit-booking-course" id="edit-booking-course-label">Course</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <select id="edit-booking-start" required>
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
                                        <label for="edit-booking-start" id="edit-booking-start-label" data-error="Error">From</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <select id="edit-booking-end" required>
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
                                        <label for="edit-booking-end" id="edit-booking-end-label" data-error="Error">To</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="date" class="datepicker" id="edit-booking-date" required>
                                        <label for="edit-booking-date" id="edit-booking-date-label">Date</label>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col s1">
                                        <span>Type</span>
                                    </div>
                                    <div class="col s5">
                                        <div class="row">
                                            <div class="col s12">
                                                <input class="with-gap" name="edit-booking-type" type="radio" id="edit-booking-type-makeup" checked="checked"/>
                                                <label for="edit-booking-type-makeup">Make Up</label>
                                            </div>
                                            <div class="col s12">
                                                <input class="with-gap" name="edit-booking-type" type="radio" id="edit-booking-type-advanced-makeup" />
                                                <label for="edit-booking-type-advanced-makeup">Advance Make Up</label>
                                            </div>
                                            <div class="col s12">
                                                <input class="with-gap" name="edit-booking-type" type="radio" id="edit-booking-type-other" />
                                                <label for="edit-booking-type-other">Other</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                


                                <div class="row right">
                                    <button class="btn waves-effect waves-light red" type="button" onclick="$('#edit-booking-modal').closeModal();">Cancel</button>
                                    <button class="btn waves-effect waves-light disabled" type="button" id="edit-booking-button">Save</button>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="delete-booking-modal" class="modal">
                    <div class="modal-content">
                        <div class="row">
                            <h5 id="delete-booking-header">Delete Booking</h5>
                            <span>Are you sure? All information related to this booking will be deleted permanently.</span>
                        </div>
                        <div class="row right">
                                <button class="btn waves-effect waves-light red" type="button" onclick="$('#delete-booking-modal').closeModal();">No</button>
                                <button id="delete-booking-yes-button" class="btn waves-effect waves-light" type="button">Yes</button>

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
                
                var currentUserPage, currentRoomPage, currentSchedulePage, currentBookingPage;
                
                // Initialize Materialize Components
                $(document).ready(function(){
                    $('select').material_select();
                    $(".button-collapse").sideNav();
                    $('.datepicker').pickadate({
                        selectMonths: true, // Creates a dropdown to control month
                        selectYears: 15 // Creates a dropdown of 15 years to control year
                      });
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
                var contentId = <?php echo "\"".$this->contentId."\""; ?>;
                var htmlContent = "html/";
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
                var dayMap = {
                    0 : "Sunday",
                    1 : "Monday",
                    2 : "Tuesday",
                    3 : "Wednesday",
                    4 : "Thursday",
                    5 : "Friday",
                    6 : "Saturday"
                }
                var monthMap = {
                    0 : "January",
                    1 : "February",
                    2 : "March",
                    3 : "April",
                    4 : "May",
                    5 : "June",
                    6 : "July",
                    7 : "August",
                    8 : "September",
                    9 : "October",
                    10 : "November",
                    11 : "December"
                }
            </script>
            
            <script type="text/javascript" src="js/adminPanelRoom.js"></script>
            <script type="text/javascript" src="js/adminPanelUser.js"></script>
            <script type="text/javascript" src="js/adminPanelSchedule.js"></script>
            <script type="text/javascript" src="js/adminPanelBooking.js"></script>

            <?php
        }
    }







    class UserPanelPage {
        private $content, $navBarId, $contentId, $pagination;
        private $logo;
        private $options;
        public function __construct($content) {
            $this->content = $content;
            $this->navBarId = "user-nav";
            $this->contentId = "content-area";
            $this->logo = array("text" => "Logo", "image" => "", "url" => "#");
            $this->options = array(new Option("Profile", "profile", "getProfileContent()"), new Option("Bookings", "bookings", "getBookingsContent()"), new Option("Report", "report", "getReportContent()"),  new Option("Logout", "logout", "getLogoutContent()"));
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
        
        protected function extra() {
            
        }
        
        protected function scripts() {
            ?>
            <!--Import jQuery before materialize.js-->
            <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
            <script type="text/javascript" src="js/materialize.min.js"></script>
            
            <script>
                var pagination = "<?php echo $this->pagination; ?>";
                pagination = parseInt(pagination);
                
                var currentBookingPage;
                
                // Initialize Materialize Components
                $(document).ready(function(){
                    $('select').material_select();
                    $(".button-collapse").sideNav();
                    $('.datepicker').pickadate({
                        selectMonths: true, // Creates a dropdown to control month
                        selectYears: 15 // Creates a dropdown of 15 years to control year
                      });
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
                var contentId = <?php echo "\"".$this->contentId."\""; ?>;
                var htmlContent = "html/";
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
                var dayMap = {
                    0 : "Sunday",
                    1 : "Monday",
                    2 : "Tuesday",
                    3 : "Wednesday",
                    4 : "Thursday",
                    5 : "Friday",
                    6 : "Saturday"
                }
                var monthMap = {
                    0 : "January",
                    1 : "February",
                    2 : "March",
                    3 : "April",
                    4 : "May",
                    5 : "June",
                    6 : "July",
                    7 : "August",
                    8 : "September",
                    9 : "October",
                    10 : "November",
                    11 : "December"
                }
                
                var userInfo = {
                    username : "<?php echo $_SESSION["user"]->getUsername(); ?>",
                    password : "<?php echo $_SESSION["user"]->getPassword(); ?>",
                    fullname : "<?php echo $_SESSION["user"]->getFullname(); ?>",
                    id : "<?php echo $_SESSION["user"]->getId(); ?>",
                    position : "<?php echo $_SESSION["user"]->getPosition(); ?>",
                    department : "<?php echo $_SESSION["user"]->getDepartment(); ?>",
                    phone : "<?php echo $_SESSION["user"]->getPhone(); ?>",
                    email : "<?php echo $_SESSION["user"]->getEmail(); ?>",
                    type : "<?php echo $_SESSION["user"]->getType(); ?>"
                }
            </script>
            <script type="text/javascript" src="js/userPanelProfile.js"></script>
            <script type="text/javascript" src="js/userPanelBooking.js"></script>


            <?php
        }
    }
    
?>