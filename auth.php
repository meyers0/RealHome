<?php
 
// Phpcode
 
//Database Connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_auth";
 
// create the connection
$conn = new mysqli($servername, $username, $password,$dbname);
 
//check connection
if($conn->connect_error){
    die("Connection failed:".$conn->connect_error);
}
 
 
//function that handles the reg part
function register($conn, $username, $password){
 
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?,?)");
    $stmt->bind_param("ss",$username,$hashed_password);
   
    if($stmt->execute()){
        return json_encode(["success" => true, "message" => ("Reg Successful")]);
    }else{
        return json_encode(["success" => false, "message" => ("Reg not Successful")]);
    }
 
}
//function that handles the login part
function login($conn, $username, $password) {
    $stmt = $conn->prepare("SELECT password FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
 
    if($result->num_rows ===1){
        $row = $result->fetch_assoc();
        if(password_verify($password, $row['password'])){
            return json_encode(["success" => true, "message" => ("Login Successful")]);
        }
    }
 
    return json_encode(["success"=> false, "message"=> "Invalid username or password"]);
}
 
//Handle POST requests
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    $action = $_POST['action'] ?? '';
    $username =$_POST['username'] ?? '';
    $password =$_POST['password'] ?? '';
 
    if($action === 'register'){
        echo register($conn,$username,$password);
    }elseif($action === 'login'){
        echo login($conn, $username, $password);
    }
 
}
 
$conn->close();
 
 
?>