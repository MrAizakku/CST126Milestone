<?php
session_start();
require('myfuncs.php');
if (!isset($_SESSION['USERNAME'])) {
    header('Location: login.html');
    exit;
}
require_once 'header.php';
$userID = getUserId();
$uName = getUsername();
$conn = dbConnect();
$sql_statement = "SELECT * FROM `blogposts` WHERE `USERID` = '$userID'";
$result = mysqli_query($conn, $sql_statement);
if(mysqli_affected_rows($conn)>0) {
    echo "<div><form><h3>Recent Posts</h3><table>";
    while ($row = mysqli_fetch_assoc($result)) {
        $title = $row["TITLE"];
        $message = $row["CONTENT"];
        $date = $row["DATE"];
        echo "<th>Title: " . $title . "</th><tr><td>" . $message . "<p>" . $date . " by " . $uName . "</td></tr>";
    }
    echo "</table></form></div>";
    include './footer.php';
} else {
    $message = "No posts found.";
    include('result.php');
}
?>