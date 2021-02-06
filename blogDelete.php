<?php
session_start();
require('myfuncs.php');

$blogid = $_GET["blogid"];
$commentid= $_GET["commentid"];
if(isset($commentid)) {
    $userid = getCommentUserID($commentid);
} else {
    $userid = getBlogUserID($blogid);
}

$currUser = getUserId();

if ($_SESSION['ROLE'] != 'EXEC' && $userid != $currUser) {
    header('Location: index.html');
    exit;
}

if (!isset($_SESSION['USERNAME'])) {
    header('Location: login.html');
    exit;
}

if(isset($blogid) && isset($userid) && empty($commentid)) {
    if($_SESSION['ROLE'] == 'EXEC' || $userid == $currUser) {
        $conn = dbConnect();
        $sql_statement = "DELETE FROM `blogposts` WHERE `ID` = '$blogid'";
        if ($conn->query($sql_statement) === TRUE) {
            $message = "Blog post deleted successfully. <br />";
            include('result.php');
        } else {
            $message = "Error: " . $sql_statement . "<br>" . $conn->error;
            include('result.php');
        }
        $conn->close();
    } else {
        $message = "You do not have access. <br />";
        include('result.php');
    }
} else if(isset($commentid) && isset($userid) && empty($blogid)) {
    if($_SESSION['ROLE'] == 'EXEC' || $userid == $currUser) {
        $conn = dbConnect();
        
        $sql_statement = "DELETE FROM `comments` WHERE `COMMENTID` = '$commentid'";
        if ($conn->query($sql_statement) === TRUE) {
            $message = "Comment deleted successfully. <br />";
            include('result.php');
        } else {
            $message = "Error: " . $sql_statement . "<br>" . $conn->error;
            include('result.php');
        }
        $conn->close();
    } else {
        $message = "You do not have access. <br />";
        include('result.php');
    }
}
?>