<?php
/*
 * Project name: CST126 Milestone 1: Registration
 * Programmer: Isaac Tucker
 * Date: 12/18/2020
 * Short synopsis: Here we capture the variables from the form from the form ids and insert them into the database.
 */
//server information
$servername = "localhost";
$dbusername = "root";
$dbpassword = "root";
$database_name = "cst126";

//Variables for user model
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$DOB = $_POST["DOB"];
$username = $_POST["username"];
$password = $_POST["password"];

echo "Thank you. " . $firstname . "<br />";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $database_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connection gooood.";
$sql_statement = "INSERT INTO `users` (`ID`, `FIRSTNAME`, `LASTNAME`, `DOB`, `USERNAME`, `PASSWORD`) VALUES (NULL, '$firstname', '$lastname', '$DOB', '$username', '$password')";
;
if ($conn->query($sql_statement) === TRUE) {
    echo "New record created successfully. <br />";
    echo "Your identity has now been stolen. <br />";
} else {
    echo "Error: " . $sql_statement . "<br>" . $conn->error;
}
$conn->close();
?>