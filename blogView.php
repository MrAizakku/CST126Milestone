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
//
require_once 'header.php';
?>
<script>
    function ConfirmDelete()
    {
      return confirm("Are you sure you want to delete?");
    }
</script>
<?php
$userID = getUserId();
$conn = dbConnect();
if($view == 'ALL') {
    $sql_statement = "SELECT blogposts.ID AS blogpostID, USERID, users.FIRSTNAME, TITLE, blogposts.DATE AS BlogPostDate, CONTENT, (SELECT COUNT(COMMENT) FROM `comments` WHERE `BLOGPOSTID` = blogposts.ID) as COMMENTCOUNT, (SELECT COUNT(RATING) FROM `comments` WHERE RATING = 1 AND `BLOGPOSTID` = blogposts.ID) AS GOOD, (SELECT COUNT(RATING) FROM `comments` WHERE RATING = 0 AND `BLOGPOSTID` = blogposts.ID) AS BAD FROM `blogposts` JOIN `users` ON blogposts.USERID = users.ID;";
} 
else if($view == 'MY') {
    $sql_statement = "SELECT blogposts.ID AS blogpostID, USERID, users.FIRSTNAME, TITLE, blogposts.DATE AS BlogPostDate, CONTENT, (SELECT COUNT(COMMENT) FROM `comments` WHERE `BLOGPOSTID` = blogposts.ID) as COMMENTCOUNT, (SELECT COUNT(RATING) FROM `comments` WHERE RATING = 1 AND `BLOGPOSTID` = blogposts.ID) AS GOOD, (SELECT COUNT(RATING) FROM `comments` WHERE RATING = 0 AND `BLOGPOSTID` = blogposts.ID) AS BAD FROM `blogposts` JOIN `users` ON blogposts.USERID = users.ID WHERE `USERID` = '$userID';";   
}
$result = mysqli_query($conn, $sql_statement);

if(mysqli_affected_rows($conn)>0) {
    echo "<div><form><h3>Recent Posts</h3><table class='equalDivide' width='90%'>";
    while ($row = mysqli_fetch_assoc($result)) {
        $blogid = $row["blogpostID"]; //for sending in the get
        $bloguserID = $row["USERID"]; //to determine if the blog pertains to logged in user
        $title = $row["TITLE"];
        //$message = $row["CONTENT"];
        $date = $row["BlogPostDate"];
        $author = $row["FIRSTNAME"];
        $count = $row["COMMENTCOUNT"];
        $good = $row["GOOD"];
        $bad =$row["BAD"];
        $color = 'green';
        if($bad > $good && $bad > 0) {
            $color = 'red';
        } 
        echo "<tr>
                <td style='text-align: left'>&nbsp;&nbsp; Title: <a href=comment.php?blogid=" . $blogid . " style='color: ".$color."'> " . $title . "</a></td>
                <td><p style='font-size: 10px'>" . $date . " by " . $author . "</p></td>
                <td> Comments (" . $count . ") </td>";
        if(getUserId() == $bloguserID || $_SESSION['ROLE'] == 'EXEC') 
        { 
            echo "<td><a href='blogDelete.php?blogid=" . $blogid . "&userid=" . $bloguserID . "' onclick='return ConfirmDelete()' style='color: blue'>Delete</a></td>";
            echo "<td><a href=blogPost.php?blogid=" . $blogid . "&userid=" . $bloguserID . " style='color: blue'>Update</a></td>";
        }
        echo "</tr><tr><td>&nbsp;</td></tr>";
    }
    echo "</table></form></div>";
    include './footer.php';
} else {
    $message = "No posts found.";
    include('result.php');
}

?>