<?php
session_start();
require('myfuncs.php');

if ($_SESSION['ROLE'] != 'EXEC') {
    header('Location: index.html');
    exit;
}

$id = $_GET["id"];
$mode = $_GET["mode"];
$role = $_GET["role"];
$currUser = getUserId();

if($id != $currUser) {
    if($mode=="Delete") {
        $conn = dbConnect();
        
        $sql_statement = "DELETE FROM `users` WHERE `ID` = '$id'";
        if ($conn->query($sql_statement) === TRUE) {
            $message = "User deleted successfully. <br />";
            include('result.php');
        } else {
            $message = "Error: " . $sql_statement . "<br>" . $conn->error;
            include('result.php');
        }
        $conn->close();
    } else if ($mode=="Update") {
        $conn = dbConnect();
        if($role=="USER") {
            $sql_statement = "UPDATE `users` SET `ROLE` = 'EXEC' WHERE `ID` = '$id'";
        } else if ($role=="EXEC") {
            $sql_statement = "UPDATE `users` SET `ROLE` = 'USER' WHERE `ID` = '$id'";
        }
        if ($conn->query($sql_statement) === TRUE) {
            $message = "User role updated successfully. <br />";
            include('result.php');
        } else {
            $message = "Error: " . $sql_statement . "<br>" . $conn->error;
            include('result.php');
        }
        $conn->close();
    }
} else {
    $message = "You cannot make changes to yourself <br />";
    include('result.php');
} ?>