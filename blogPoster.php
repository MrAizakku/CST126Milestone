<?php
session_start();
require('myfuncs.php');

$btitle = $_POST["blogTitle"];
$bcontent = $_POST["blogContent"];

//is_null($BlogTitle) || empty($BlogTitle))
if($btitle!="" && $bcontent!="") {
    $date = date('Y-m-d H:i:s');
    $uname = getUserId();
    
    $conn = dbConnect();
    $sql_statement = "INSERT INTO `blogposts` (`ID`, `USERID`, `TITLE`, `DATE`, `CONTENT`) VALUES (NULL, '$uname', '$btitle', '$date', '$bcontent')";
    
    if ($conn->query($sql_statement) === TRUE) {
        $message = '<h2>Blog Posted successfully: <p> Title: ' . $btitle . '<p> Content: ' . $bcontent . '<p> by: ' . getUserName() . ' ' . $date . '</h2>';
        include('result.php');
    } else {
        $message = "Error: " . $sql_statement . "<br>" . $conn->error;
        include('result.php');
    }
    $conn->close();
} else {
    $message = "Blog post failed." . $sql_statement;
    include('result.php');
}
?>