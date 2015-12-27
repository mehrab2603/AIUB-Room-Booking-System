<?php
require "classes.php";

class Database {
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $target;
    private $mysqli;
    
    function __construct()
    {
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "root";
        $this->dbname = "final_project";
        $this->target = "uploads/";
        $this->mysqli = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->mysqli->connect_errno) {
            die("Could not connect: ".$this->mysqli->connect_error);
            exit();
        }
    }
    
    function __destruct()
    {
        $this->mysqli->close();
    }
    
    function isUsernameTaken($username) {
        $username = $this->mysqli->real_escape_string($username);
        $result = $this->mysqli->query("SELECT username FROM login WHERE username='$username'");
        if($result->num_rows > 0) return true;
        return false;
    }
    
    function isIdTaken($id) {
        $id = $this->mysqli->real_escape_string($id);
        $result = $this->mysqli->query("SELECT id FROM user_info WHERE id='$id'");
        if($result->num_rows > 0) return true;
        return false;
    }
    
    function isEmailTaken($email) {
        $email = $this->mysqli->real_escape_string($email);
        $result = $this->mysqli->query("SELECT email FROM user_info WHERE email='$email'");
        if($result->num_rows > 0) return true;
        return false;
    }
    
    function isPhoneTaken($phone) {
        $phone = $this->mysqli->real_escape_string($phone);
        $result = $this->mysqli->query("SELECT phone FROM user_info WHERE phone='$phone'");
        if($result->num_rows > 0) return true;
        return false;
    }
    
    function isRoomIdTaken($id) {
        $id = $this->mysqli->real_escape_string($id);
        $result = $this->mysqli->query("SELECT id FROM room WHERE id='$id'");
        if($result->num_rows > 0) return true;
        return false;
    }
    
    function isScheduleCreated(RoomSchedule $schedule) {
        $room = $schedule->getRoom();
        $day = $schedule->getDay();
        $result = $this->mysqli->query("SELECT room FROM schedule WHERE room='$room' AND day='$day'");
        if($result->num_rows > 0) {$result->free(); return true;}
        else {$result->free(); return false;}
    }
    
    function isScheduleClash(RoomSchedule $schedule) {
        $room = $schedule->getRoom();
        $day = $schedule->getDay();
        $course = $this->mysqli->real_escape_string($schedule->getCourse());
        $start = $schedule->getStart();
        $end = $schedule->getEnd();
        
        $query = "SELECT ";
        for($i = $start; $i < $end; $i++) $query = $query."`".$i."`, ";
        $query = $query."`".$end."` FROM schedule WHERE room='$room' AND day='$day'";
        
        
        $result = $this->mysqli->query($query);
        $row = $result->fetch_assoc();
        
        if(is_array($row)) {
            
            foreach($row as $key => $value) {
                if($value != "") {$result->free(); return true;}
            }

            $result->free();
            return false;
        }
        return false;
    }
    
    function isAlreadyScheduled($room, $day, $course) {
        $ret = $this->getScheduleList($room, $day);
        foreach($ret as $schedule) {
            if($schedule->getCourse() == $course) return true;
        }
        return false;
    }
    
    function isBookingClash(Booking $booking) {
        $id = $booking->getId();
        $room = $booking->getRoom();
        $user = $booking->getUser();
        $course = $this->mysqli->real_escape_string($booking->getCourse());
        $start = $booking->getStart();
        $end = $booking->getEnd();
        $date = $booking->getClassDate();
        $type = $booking->getType();
        
        $result = $this->mysqli->query("SELECT start, end FROM booking WHERE date='$date' AND room='$room' AND id!='$id'");
        
        $arr = array();
        
        while($row = $result->fetch_assoc()) {
            array_push($arr, $row["start"]);
            array_push($arr, $row["end"]);
        }
        
        for($i = $start; $i <= $end; $i++) {
            if(in_array($i, $arr)) {$result->free(); return true;}
        }
        
        $result->free();
        return false;
    }
    
    
    function getUserCount($username) {
        $username = $this->mysqli->real_escape_string($username);
        $result = $this->mysqli->query("SELECT COUNT(*) AS user_count FROM login WHERE username LIKE '%$username%'");
        $ret = $result->fetch_assoc();
        return $ret["user_count"];
    }
    
    function getRoomCount($id) {
        $id = $this->mysqli->real_escape_string($id);
        $result = $this->mysqli->query("SELECT COUNT(*) AS room_count FROM room WHERE id LIKE '%$id%'");
        $ret = $result->fetch_assoc();
        $result->free();
        return $ret["room_count"];
    }
    
    function getBookingCount($user, $room, $like, $date, $expired) {
        $query = "SELECT COUNT(*) as booking_count FROM booking WHERE ";
        if($like) {
            if($user != "" && $room == "") {
                $query = $query."user LIKE '%$user%'";
            }
            else if($user == "" && $room != "") {
                $query = $query."room LIKE '%$room%'";
            }
            else if($user != "" && $room != "") {
                $query = $query."room LIKE '%$room%' AND user LIKE '%$user%'";
            }
            else {
                $query = $query."1";
            }
        }
        else {
            if($user != "" && $room == "") {
                $query = $query."user='$user'";
            }
            else if($user == "" && $room != "") {
                $query = $query."room='$room'";
            }
            else if($user != "" && $room != "") {
                $query = $query."room='$room' AND user='$user'";
            }
            else {
                $query = $query."1";
            }
        }
        if($date != "") {
            if($expired == "true") {
                $query = $query." AND date <= '$date'";
            }
            else if($expired == "false") {
                $query = $query." AND date > '$date'";
            }
            
        }
        $result = $this->mysqli->query($query);
        $ret = $result->fetch_assoc();
        $result->free();
        return $ret["booking_count"];
        
    }
    
    
    function insertUser(User $user) {
        $username = $this->mysqli->real_escape_string($user->getUsername());
        $password = $user->getPassword();
        $fullname = $this->mysqli->real_escape_string($user->getFullname());
        $id = $this->mysqli->real_escape_string($user->getId());
        $department = $this->mysqli->real_escape_string($user->getDepartment());
        $position = $this->mysqli->real_escape_string($user->getPosition());
        $phone = $this->mysqli->real_escape_string($user->getPhone());
        $email = $this->mysqli->real_escape_string($user->getEmail());
        $type = $user->getType();
        
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        $result = $this->mysqli->query("INSERT INTO login(username, hash, type) VALUES ('$username', '$hash', '$type')");
        
        if($result) {
            $result = $this->mysqli->query("INSERT INTO user_info(username, fullname, id, position, department, phone, email) VALUES ('$username', '$fullname', '$id', '$position', '$department', '$phone', '$email')");
            if(!$result) {
                $this->mysqli->query("DELETE FROM login WHERE username='$username'");
            }
        }
        return $result;
    }
    
    function insertRoom(Room $room) {
        $id = $this->mysqli->real_escape_string($room->getId());
        $floor = $this->mysqli->real_escape_string($room->getFloor());
        $campus = $this->mysqli->real_escape_string($room->getCampus());
        $capacity = $this->mysqli->real_escape_string($room->getCapacity());
        $type = $this->mysqli->real_escape_string($room->getType());
        
        
        $result = $this->mysqli->query("INSERT INTO room(id, floor, campus, capacity, type) VALUES ('$id', '$floor', '$campus', '$capacity', '$type')");
        return $result;
    }
    
    function insertSchedule(RoomSchedule $schedule) {
        $room = $schedule->getRoom();
        $day = $schedule->getDay();
        $course = $this->mysqli->real_escape_string($schedule->getCourse());
        $start = $schedule->getStart();
        $end = $schedule->getEnd();
        
        $query = "INSERT INTO schedule(room, day";
        for($i = $start; $i <= $end; $i++) $query = $query.", `".$i."`";
        $query = $query.") VALUES('$room', '$day'";
        for($i = $start; $i <= $end; $i++) $query = $query.", '$course'";
        $query = $query.")";
        
        $result = $this->mysqli->query($query);
        
        return $result;
    }
    
    function insertBooking(Booking $booking) {
        $room = $booking->getRoom();
        $user = $booking->getUser();
        $course = $this->mysqli->real_escape_string($booking->getCourse());
        $start = $booking->getStart();
        $end = $booking->getEnd();
        $date = $booking->getClassDate();
        $type = $booking->getType();
        
        
        $result = $this->mysqli->query("INSERT INTO booking(room, user, course, start, end, date, type) VALUES ('$room', '$user', '$course', '$start', '$end', '$date', '$type')");
        return $result;
    }
    
    function getUser($username) {
        $username = $this->mysqli->real_escape_string($username);
        $result = $this->mysqli->query("SELECT login.*, user_info.fullname, user_info.id, user_info.position, user_info.department, user_info.phone, user_info.email FROM login LEFT JOIN user_info ON login.username = user_info.username WHERE login.username='$username'");
        $row = $result->fetch_assoc();
        $ret = new User($row["username"], $row["hash"], $row["fullname"], $row["id"], $row["position"], $row["department"], $row["phone"], $row["email"], $row["type"]);
        $result->free();
        return $ret;
    }
    
    function getRoom($id) {
        $id = $this->mysqli->real_escape_string($id);
        $result = $this->mysqli->query("SELECT * FROM room WHERE id='$id'");
        $row = $result->fetch_assoc();
        $ret = new Room($row["id"], $row["floor"], $row["campus"], $row["capacity"], $row["type"]);
        $result->free();
        return $ret;
    }
    
    function getUserList($username, $limit, $offset) {
        $username = $this->mysqli->real_escape_string($username);
        $result = $this->mysqli->query("SELECT login.*, user_info.fullname, user_info.id, user_info.position, user_info.department, user_info.phone, user_info.email FROM login LEFT JOIN user_info ON login.username=user_info.username WHERE login.username LIKE '%$username%' LIMIT $offset, $limit");
        
        $ret = array();    
        
        while($row = $result->fetch_assoc()) {
            array_push($ret, new User($row["username"], $row["hash"], $row["fullname"], $row["id"], $row["position"], $row["department"], $row["phone"], $row["email"], $row["type"]));
        }
        $result->free();
        return $ret;
    }
    
    function getRoomList($id, $limit, $offset) {
        $id = $this->mysqli->real_escape_string($id);
        $result = $this->mysqli->query("SELECT * FROM room WHERE id LIKE '%$id%' LIMIT $offset, $limit");
        
        $ret = array();    
        
        while($row = $result->fetch_assoc()) {
            array_push($ret, new Room($row["id"], $row["floor"], $row["campus"], $row["capacity"], $row["type"]));
        }
        $result->free();
        return $ret;
    }
    
    function getBookingList($user, $room, $like, $limit, $offset, $date, $expired) {
        $query = "SELECT * FROM booking WHERE ";
        if($like) {
            if($user != "" && $room == "") {
                $query = $query."user LIKE '%$user%'";
            }
            else if($user == "" && $room != "") {
                $query = $query."room LIKE '%$room%'";
            }
            else if($user != "" && $room != "") {
                $query = $query."room LIKE '%$room%' AND user LIKE '%$user%'";
            }
            else {
                $query = $query."1";
            }
        }
        else {
            if($user != "" && $room == "") {
                $query = $query."user='$user'";
            }
            else if($user == "" && $room != "") {
                $query = $query."room='$room'";
            }
            else if($user != "" && $room != "") {
                $query = $query."room='$room' AND user='$user'";
            }
            else {
                $query = $query."1";
            }
        }
        if($date != "") {
            if($expired == "true") {
                $query = $query." AND date <= '$date'";
            }
            else if($expired == "false") {
                $query = $query." AND date > '$date'";
            }
            
        }
        $query = $query." LIMIT $offset, $limit";
        $result = $this->mysqli->query($query);
        $ret = array();
        while($row = $result->fetch_assoc()) {
            array_push($ret, new Booking($row["id"], $row["room"], $row["user"], $row["course"], $row["start"], $row["end"], $row["date"], $row["type"]));
        }
        $result->free();
        return $ret;
        
    }
    
    function getScheduleList($room, $day) {
        
        $result = $this->mysqli->query("SELECT `1`,`2`,`3`,`4`,`5`,`6`,`7`,`8`,`9`,`10`,`11`,`12`,`13`,`14`,`15`,`16`,`17`,`18`,`19`,`20`,`21`,`22`,`23`,`24`,`25`,`26`,`27`,`28`,`29` FROM schedule WHERE room='$room' AND day='$day'");
        
        if($result) {
           
            $row = $result->fetch_assoc();

            $courses = array();

            foreach($row as $key => $value) {
                array_push($courses, $value);
            }
            $courses = array_unique($courses);

            reset($row);

            $ret = array();

            foreach($courses as $course) {
                if($course == "") continue;
                $keys = array_keys($row, $course);

                $temp = 0;
                $keyCount = count($keys);
                
                for($i = 1; $i < $keyCount; $i++) {
                    if($keys[$i] - $keys[$i - 1] > 1) {
                        array_push($ret, new RoomSchedule($room, $day, $course, $keys[$temp], $keys[$i - 1]));
                        $temp = $i;
                    }
                }
                if($temp != $keyCount) array_push($ret, new RoomSchedule($room, $day, $course, $keys[$temp], $keys[$keyCount - 1]));
            }
            $result->free();
            return $ret;
        }
        else return null;
    }
    
    function updateUser(User $user) {
        $username = $this->mysqli->real_escape_string($user->getUsername());
        $password = $user->getPassword();
        $fullname = $this->mysqli->real_escape_string($user->getFullname());
        $id = $this->mysqli->real_escape_string($user->getId());
        $department = $this->mysqli->real_escape_string($user->getDepartment());
        $position = $this->mysqli->real_escape_string($user->getPosition());
        $phone = $this->mysqli->real_escape_string($user->getPhone());
        $email = $this->mysqli->real_escape_string($user->getEmail());
        $type = $user->getType();
        
        $result = false;
        
        if($password != "") {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $result = $this->mysqli->query("UPDATE login SET hash='$hash', type='$type' WHERE username='$username'");
        }
        else {
            $result = $this->mysqli->query("UPDATE login SET type='$type' WHERE username='$username'");
        }
        if($result) {
            $result = $this->mysqli->query("UPDATE user_info SET fullname='$fullname', id='$id', position='$position', department='$department', phone='$phone', email='$email' WHERE username='$username'");
        }
        return $result;
    }
                       
    function updateRoom(Room $room, $old) {
        $id = $this->mysqli->real_escape_string($room->getId());
        $floor = $this->mysqli->real_escape_string($room->getFloor());
        $campus = $this->mysqli->real_escape_string($room->getCampus());
        $capacity = $this->mysqli->real_escape_string($room->getCapacity());
        $type = $this->mysqli->real_escape_string($room->getType());
        $old = $this->mysqli->real_escape_string($old);
        
        
        $result = $this->mysqli->query("UPDATE room SET id='$id', floor='$floor', campus='$campus', capacity='$capacity', type='$type' WHERE id='$old'");
        
        
        return $result;
    }
    
    function updateSchedule(RoomSchedule $schedule) {
        $room = $schedule->getRoom();
        $day = $schedule->getDay();
        $course = $this->mysqli->real_escape_string($schedule->getCourse());
        $start = $schedule->getStart();
        $end = $schedule->getEnd();
        
        $query = "UPDATE schedule SET ";
        for($i = $start; $i <= $end; $i++) $query = $query."`".$i."`='$course', ";
        $query = $query."`".$end."`='$course' WHERE room='$room' AND day='$day'";
        
        $result = $this->mysqli->query($query);
        
        return $result;
    }
    
    function updateBooking(Booking $booking) {
        $id = $booking->getId();
        $room = $booking->getRoom();
        $user = $booking->getUser();
        $course = $this->mysqli->real_escape_string($booking->getCourse());
        $start = $booking->getStart();
        $end = $booking->getEnd();
        $date = $booking->getClassDate();
        $type = $booking->getType();
        
        $result = $this->mysqli->query("UPDATE booking SET room='$room', user='$user', course='$course', start='$start', end='$end', date='$date', type='$type' WHERE id='$id'");
        
        return $result;
    }
    
    function deleteUser($username) {
        $result = $this->mysqli->query("DELETE FROM login WHERE username='$username'");
        return $result;
    }
    
    function deleteRoom($id) {
        $result = $this->mysqli->query("DELETE FROM room WHERE id='$id'");
        return $result;
    }
    
    function deleteBooking($id) {
        $result = $this->mysqli->query("DELETE FROM booking WHERE id='$id'");
        return $result;
    }
    
    function deleteAllRoomDaySchedule($room, $day) {
        $result = $this->mysqli->query("DELETE FROM schedule WHERE room='$room' AND day='$day'");
        return $result;
    }
}

?>