<!--
 * Project name: CST126 Milestone 3: Post to Blog
 * Programmer: Isaac Tucker
 * Date: 01/15/2021
 * Short synopsis: This page calls the blog data from the DB and displays all posts associated with the current user.
 -->
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
        echo "<th style='text-align: left'>Title: " . $title . "</th><tr><td>" . $message . "<p style='font-size: 8px'>" . $date . " by " . $uName . "</td></tr><tr><td>&nbsp;</td></tr>";
    }
    echo "</table></form></div>";
    include './footer.php';
} else {
    $message = "No posts found.";
    include('result.php');
}
?>