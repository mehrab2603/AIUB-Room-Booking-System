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
    
    function getUserCount() {
        $result = $this->mysqli->query("SELECT COUNT(*) AS user_count FROM login WHERE type='user'");
        $ret = $result->fetch_assoc();
        return $ret["user_count"];
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
    
    function getUser($username) {
        $loginResult = $this->mysqli->query("SELECT * FROM login WHERE username='$username'");
        while($loginRow = $loginResult->fetch_assoc()) {
            $infoResult = $this->mysqli->query("SELECT * FROM user_info WHERE username='$username'");
            while($infoRow = $infoResult->fetch_assoc()) {
                return new User($loginRow["username"], $loginRow["hash"], $infoRow["fullname"], $infoRow["id"], $infoRow["position"], $infoRow["department"], $infoRow["phone"], $infoRow["email"], $loginRow["type"]);
            }
        }
    }

    
    
}

/*

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function check_username($username) {
    global $conn;
    $result = mysqli_query($conn, "SELECT username FROM Login WHERE username='".$username."'");
    if(mysqli_num_rows($result) > 0) return false;
    return true;
}

function check_username_with_password($username, $password) {
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM Login WHERE username='".$username."' AND password='".$password."'");
    return mysqli_fetch_assoc($result);
}

function get_user_info($username) {
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM Info WHERE username='".$username."'");
    while($row = mysqli_fetch_assoc($result)) {
        $info = array("username"=>$row["username"], "full_name"=>$row["full_name"], "address"=>$row["address"], "phone"=>$row["phone"], "email"=>$row["email"], "pp"=>$row["pp"]);
        return $info;
    }
}

function get_stories($username, $limit, $offset) {
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM Story WHERE username='$username' LIMIT $offset, $limit");
    $ret = array();
    if($result == false) return;
    while($row = mysqli_fetch_assoc($result)) {
        array_push($ret, $row);
    }
    return $ret;
}

function get_stories_all($limit, $offset) {
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM Story LIMIT $limit OFFSET $offset");
    $ret = array();
    if($result == false) return;
    while($row = mysqli_fetch_assoc($result)) {
        array_push($ret, $row);
    }
    return $ret;
}

function get_story($path) {
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM Story WHERE path='$path'");
    return mysqli_fetch_assoc($result);
    
}

function get_like($username, $path) {
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM Likes WHERE username='$username' AND story='$path'");
    if($result == false) return false;
    if(mysqli_num_rows($result) > 0) return true;
    return false;
}

function get_like_count($path) {
    global $conn;
    $result = mysqli_query($conn, "SELECT COUNT(*) AS like_count FROM Likes WHERE story='$path'");
    return mysqli_fetch_assoc($result)["like_count"];
}

function get_view_count($username) {
    global $conn;
    $result = mysqli_query($conn, "SELECT SUM(views) AS sum FROM Story WHERE username='$username'");
    return mysqli_fetch_assoc($result)["sum"];
    
}

function get_story_count($username) {
    global $conn;
    $result = mysqli_query($conn, "SELECT COUNT(*) AS story_count FROM Story WHERE username='".$username."'");
    $row = mysqli_fetch_assoc($result);
    return $row["story_count"];
}

function get_story_count_all() {
    global $conn;
    $result = mysqli_query($conn, "SELECT COUNT(*) AS story_count FROM Story");
    $row = mysqli_fetch_assoc($result);
    return $row["story_count"];
}

function check_photo($file) {
    if($file["type"][0] == 'i' && $file["type"][1] == 'm' && $file["type"][2] == 'a' && $file["type"][3] == 'g' && $file["type"][4] == 'e') {
        if($file["size"] <= 200000) {
            return "";
        }
        else {
            return "Photo Size Error. Max 200KB allowed.";
        }
    }
    else {
        return "Uploaded file not an image file.";
    }
}

function move_photo($file, $username) {
    global $target;
    $previous_photo = glob($username.".*");
    if(count($previous_photo) > 0) array_map('unlink', $previous_photo);
    $file["name"] = $username.".".pathinfo($file["name"], PATHINFO_EXTENSION);
    $uri = $target.basename($file["name"]);
    if(move_uploaded_file($file["tmp_name"], $uri)) return $uri;
    else return false;
}

function insert_user_login($username, $password) {
    global $conn;
    $result = mysqli_query($conn, "INSERT INTO Login(username, password, type) VALUES ('$username', '$password', 'user')");
    return $result;
}

function insert_user_info($username, $full_name, $address, $phone, $email, $pp) {
    global $conn;
    $result = mysqli_query($conn, "INSERT INTO Info(username, full_name, address, phone, email, pp) VALUES ('$username', '$full_name', '$address', '$phone', '$email', '$pp')");
    return $result;
}

function insert_story($username, $title, $body) {
    global $conn, $target;
    $story_count = get_story_count($username);
    if($story_count >= 10000) return "You have reached the maximum number of stories allowed. Please delete some stories to continue";
    $filename = $target.$username."_story".strval($story_count + 1);
    $date = date("Y-m-d H:i:s");
    $result = mysqli_query($conn, "INSERT INTO Story(username, title, path, views, likes, date) VALUES('$username', '$title', '$filename', '0', '0', '$date')");
    if($result) {
        $file = fopen($filename, "w");
        fwrite($file, $body);
        fclose($file);
    }
    else return "Could not upload story";
    return $result;
}

function insert_like($username, $path) {
    global $conn;
    $result = mysqli_query($conn, "INSERT INTO Likes(username, story) VALUES('$username', '$path')");
    if($result == false) return "Could not update like";
    $likes = get_like_count($path);
    update_like_story($path, $likes);
    return $result;
}

function update_story($title, $body, $path) {
    global $conn;
    $result = mysqli_query($conn, "UPDATE Story SET title='$title' WHERE path='$path'");
    if($result) {
        $file = fopen($path, "w");
        fwrite($file, $body);
        fclose($file);
    }
    else return "Could not upload story";
    return $result;
}

function update_user_info($username, $full_name, $address, $phone, $email, $pp) {
    global $conn;
    $result = mysqli_query($conn, "UPDATE Info SET full_name='$full_name', address='$address', phone='$phone', email='$email', pp='$pp' WHERE username='$username'");
    return $result;
}

function update_login_info($username, $password) {
    global $conn;
    $result = mysqli_query($conn, "UPDATE Login SET password='$password' WHERE username='$username'");
    return $result;
}

function update_view($path, $view) {
    global $conn;
    $result = mysqli_query($conn, "UPDATE Story SET views='$view' WHERE path='$path'");
    return $result;
}

function update_like_story($path, $likes) {
    global $conn;
    $result = mysqli_query($conn, "UPDATE Story SET likes='$likes' WHERE path='$path'");
    return $result;
}

function delete_story($path) {
    global $conn;
    $result = mysqli_query($conn, "DELETE FROM Story WHERE path='$path'");
    unlink($path);
}

function delete_like($username, $path) {
    global $conn;
    $result = mysqli_query($conn, "DELETE FROM Likes WHERE username='$username' AND story='$path'");
    $likes = get_like_count($path);
    update_like_story($path, $likes);
    return $result;
}

*/

?>