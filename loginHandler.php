<!--
 * Project name: CST126 Milestone 3: Post to Blog
 * Programmer: Isaac Tucker
 * Date: 01/15/2021
 * Short synopsis: The login handler has been updated to use the function dbConnect() and to pass a message to a result page instead of custom result pages.
 -->
<?php
session_start();
require('myfuncs.php');
/*
 * Project name: CST126 Milestone 2: Login
 * Programmer: Isaac Tucker
 * Date: 01/07/2021
 * Short synopsis: Here we capture the variables from the form from the form ids and check the databse to see if they exist.
 */

//Variables for user authentication
$password = $_POST["password"];
$uname = $_POST["username"];

//make sure the incoming variables aren't empty/blank
if($uname!="" && $password!="") {
    // Check/establish connection
    $conn = dbConnect();
    
    $sql_statement = "SELECT * FROM `users` WHERE `USERNAME` = '$uname' AND `PASSWORD` = '$password'";
    if ($result = mysqli_query($conn, $sql_statement)) {
        if(mysqli_affected_rows($conn)==1) {
            $row = $result->fetch_assoc();	// Read the Row from the Query
            saveUserId($row['ID']);		// Save User ID in the Session
            saveUserRole($row['ROLE']);		// Save User role in the Session
            saveUsername($row['USERNAME']);		// Save User ID in the Session
            $message = '<h2>Login was successful! Welcome back, ' . $uname . '</h2>';
            include('result.php');
        } else if(mysqli_affected_rows($conn)==0){
            $message = "Login Failed.";
            include('result.php');
        } else if(mysqli_affected_rows($conn)>=2){
            $message = "Multiple Users are Registered.";
            include('result.php');
        }
//         while($row = mysqli_fetch_assoc($result)){
//             echo "<br>ID: " . $row['ID'] . "<br> First Name: " . $row['FIRSTNAME'] . "<br> Last Name: " . $row['LASTNAME'] . "<br>";
//             echo "====================";
//         }
    } else {
        $message = "Error: " . $sql_statement . "<br>" . mysqli_error($conn);
        include('result.php');
    }
    $conn->close();
} else {
    $message = "Invalid inputs for Username or Password";
    include('result.php');
}
?>