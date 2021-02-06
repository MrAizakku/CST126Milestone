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
$view = $_GET["MODE"];

require_once 'header.php';
$userID = getUserId();
$conn = dbConnect();
if($view == 'ALL') {
    $sql_statement = "SELECT blogposts.ID AS blogpostID, USERID, users.FIRSTNAME, TITLE, blogposts.DATE AS BlogPostDate, CONTENT, (SELECT COUNT(COMMENT) FROM `comments` WHERE `BLOGPOSTID` = blogposts.ID) as COMMENTCOUNT FROM `blogposts` JOIN `users` ON blogposts.USERID = users.ID;";
} 
else if($view == 'MY') {
    $sql_statement = "SELECT blogposts.ID AS blogpostID, USERID, users.FIRSTNAME, TITLE, blogposts.DATE AS BlogPostDate, CONTENT, (SELECT COUNT(COMMENT) FROM `comments` WHERE `BLOGPOSTID` = blogposts.ID) as COMMENTCOUNT FROM `blogposts` JOIN `users` ON blogposts.USERID = users.ID WHERE `USERID` = '$userID';";   
}
$result = mysqli_query($conn, $sql_statement);
if(mysqli_affected_rows($conn)>0) {
    echo "<div><form><h3>Recent Posts</h3><table>";
    while ($row = mysqli_fetch_assoc($result)) {
        $blogid = $row["blogpostID"]; //for sending in the get
        $bloguserID = $row["USERID"]; //to determine if the blog pertains to logged in user
        $title = $row["TITLE"];
        $message = $row["CONTENT"];
        $date = $row["DATE"];
        $author = $row["FIRSTNAME"];
        $count = $row["COMMENTCOUNT"];
        echo "<th style='text-align: left'>Title: " . $title . "</th><tr><td>" . $message . "<p style='font-size: 8px'>" . $date . " by " . $author . "</td></tr>";
        echo "<tr><td><a href=comment.php?blogid=" . $blogid . " style='color: blue'>Comments (" . $count . ")</a></td>";
        if(getUserId() == $bloguserID || $_SESSION['ROLE'] == 'EXEC') 
        { 
            echo "<tr><td><a href=blogDelete.php?blogid=" . $blogid . "&userid=" . $bloguserID . " style='color: blue'>Delete</a></td>";
            echo "<td><a href=blogPost.php?blogid=" . $blogid . "&userid=" . $bloguserID . " style='color: blue'>Update</a></td></tr>";
        }
        echo "<tr><td>&nbsp;</td></tr>";
    }
    echo "</table></form></div>";
    include './footer.php';
} else {
    $message = "No posts found.";
    include('result.php');
}

?>