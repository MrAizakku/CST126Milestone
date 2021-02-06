<?php
session_start();
require('myfuncs.php');
if (!isset($_SESSION['USERNAME'])) {
    header('Location: login.html');
    exit;
}
require_once 'header.php';

$blogid = $_GET["blogid"];

$userID = getUserId();
$conn = dbConnect();

$sql_statement = "SELECT blogposts.ID AS blogpostID, USERID, TITLE, DATE, CONTENT, users.FIRSTNAME FROM `blogposts` JOIN `users` ON blogposts.USERID = users.ID WHERE blogposts.ID = '$blogid';";
                
$result = mysqli_query($conn, $sql_statement);
if(mysqli_affected_rows($conn)>0) {
    echo "<div><form><h3>Comment Page:</h3><table>";
    $row = mysqli_fetch_assoc($result);
    $blogpostid = $row["blogpostID"]; //for sending in the get
    $bloguserID = $row["USERID"]; //to determine if the blog pertains to logged in user
    $title = $row["TITLE"];
    $message = $row["CONTENT"];
    $date = $row["DATE"];
    $author = $row["FIRSTNAME"];
    echo "<th style='text-align: left'>Title: " . $title . "</th><tr><td>" . $message . "<p style='font-size: 8px'>" . $date . " by " . $author . "</td></tr>";
    if(getUserId() == $bloguserID || $_SESSION['ROLE'] == 'EXEC')
    {
        echo "<tr><td><a href=blogDelete.php?blogid=" . $blogid . "&userid=" . $bloguserID . " style='color: blue'>Delete</a></td>";
        echo "<td><a href=blogPost.php?blogid=" . $blogid . "&userid=" . $bloguserID . "&mode=Update style='color: blue'>Update</a></td></tr>";
    }
    echo "<tr><td>&nbsp&nbsp&nbsp&nbsp<a href=commentPoster.php?blogid=" . $blogid . "&mode=Post style='color: blue; font-size: 10px;'>Post Comment</a></td></tr>";
    echo "</table></form></div><hr>";
    
    $sql_statement = "SELECT COMMENTID, COMMENTAUTHORID, COMMENT, users.FIRSTNAME, comments.DATE FROM `comments` JOIN `users` ON comments.COMMENTAUTHORID = users.ID WHERE comments.BLOGPOSTID = '$blogid';";
    
    $result = mysqli_query($conn, $sql_statement);
    if(mysqli_affected_rows($conn)>0) {
        echo "<div><form><h3>Comments:</h3><table>";
        while ($row = mysqli_fetch_assoc($result)) {
            $commentid = $row["COMMENTID"]; //for sending in the get
            $commentauthorid = $row["COMMENTAUTHORID"];
            $comment = $row["COMMENT"];
            $commentauthor = $row["FIRSTNAME"];
            $commentdate = $row["DATE"];
            echo "<tr><td>" . $comment . "<p style='font-size: 8px'>" . $commentdate . " by " . $commentauthor . "</td></tr>";
            if(getUserId() == $commentauthorid || $_SESSION['ROLE'] == 'EXEC')
            {
                echo "<tr><td><a href=blogDelete.php?commentid=" . $commentid . "&userid=" . $commentauthorid . " style='color: blue'>Delete</a></td>";
                echo "<td><a href=commentPoster.php?commentid=" . $commentid . "&userid=" . $commentauthorid . "&mode=Update style='color: blue'>Update</a></td></tr>";
            }
            echo "<tr><td>&nbsp;</td></tr>";
        }
        echo "</table></form></div>";
        include './footer.php';
    } else {
        $message = "No comments found.";
        include('result.php');
    }
    
} else {
    $message = "No posts found with that ID.";
    include('result.php');
}
?>