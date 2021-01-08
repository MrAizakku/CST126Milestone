<?php
/*
 * Project name: CST126 Milestone 2: Login
 * Programmer: Isaac Tucker
 * Date: 01/07/2021
 * Short synopsis: Here we capture the variables from the form from the form ids and check the databse to see if they exist.
 */
//server information
$servername = "localhost";
$dbusername = "root";
$dbpassword = "root";
$database_name = "cst126";

//Variables for user authentication
$pword = $_POST["password"];
$uname = $_POST["username"];
$error = "<br>Error Messages: ";

// Create connection
$conn = mysqli_connect($servername, $dbusername, $dbpassword, $database_name);

//make sure the incoming variables aren't empty/blank
if($uname!="" && $pword!="") {
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    echo "Connection Successful. <br>";
    
    $sql_statement = "SELECT * FROM `users` WHERE `USERNAME` = '$uname' AND `PASSWORD` = '$pword'";
    if ($result = mysqli_query($conn, $sql_statement)) {
        if(mysqli_affected_rows($conn)==1) {
            echo "Login Successful.";
        } else if(mysqli_affected_rows($conn)==0){
            echo "Login Failed.";
        } else if(mysqli_affected_rows($conn)>=2){
            echo "Multiple Users are Registered.";
        }
        while($row = mysqli_fetch_assoc($result)){
            echo "<br>ID: " . $row['ID'] . "<br> First Name: " . $row['FIRSTNAME'] . "<br> Last Name: " . $row['LASTNAME'] . "<br>";
            echo "====================";
        }
        $error .= "None.";
    } else {
        $error .= "Error: " . $sql_statement . "<br>" . mysqli_error($conn);
    }
    $conn->close();
} else {
    $error .= "Invalid inputs for Username or Password";
}

//show any errors
echo $error;
?>