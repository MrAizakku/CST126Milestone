<!--
 * Project name: CST126 Milestone 3: Post to Blog
 * Programmer: Isaac Tucker
 * Date: 01/15/2021
 * Short synopsis: The handler for the register.html form. 
 -->
 <?php
require('myfuncs.php');
/*
 * Project name: CST126 Milestone 1: Registration
 * Programmer: Isaac Tucker
 * Date: 12/18/2020
 * Short synopsis: Here we capture the variables from the form from the form ids and insert them into the database.
 */

//Variables for user model
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$DOB = $_POST["DOB"];
$username = $_POST["username"];
$password = $_POST["password"];

if($firstname != "" && $lastname != "" && $DOB != "" && $username != "" && $password != ""){
    if(UsernameExists($username)) {
        $message = "That username is already taken. <br />";
        include('result.php');
    } else {
        $conn = dbConnect();
        $sql_statement = "INSERT INTO `users` (`ID`, `FIRSTNAME`, `LASTNAME`, `DOB`, `USERNAME`, `PASSWORD`) VALUES (NULL, '$firstname', '$lastname', '$DOB', '$username', '$password')";
        
        if ($conn->query($sql_statement) === TRUE) {
            $message = "Registration successful. You may now log in. <br />";
            include('result.php');
        } else {
            $message = "Error: " . $sql_statement . "<br>" . $conn->error;
            include('result.php');
        }
        $conn->close();
    }
} else {
    $message = "You left one of the fields blank; complete the form completely.";
    include('result.php');
}
?>