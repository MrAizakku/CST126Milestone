<!--
 * Project name: CST126 Milestone 7: Search Blog Module
 * Programmer: Isaac Tucker
 * Date: 02/04/2021
 * Short synopsis: This is the search module needed to search for specific blog data. Here users can input specific titles, content, author names, dates and yield results that correspond with the inputted information. INdividual peices may be entered or peices in combination can be entered to refind results. 
 -->

<?php
session_start();
require('myfuncs.php');

if (!isset($_SESSION['USERNAME'])) {
    header('Location: login.html');
    exit;
}
if(isset($_POST['submit'])){ //check if form was submitted
    $title = $_POST["title"];
    $content = $_POST["content"];
    $author = $_POST["author"];
    $date = $_POST["date"];
}
require_once 'header.php';
?>
<div>
	<form action="" method="post">
		<div class="container">
			<h1>Search Form:</h1>
			<hr>
			<label for="username">Title:</label>
			<input type="text" id="title" name="title" value="<?php echo $title; ?>">
			<label for="username">Content:</label>
			<input type="text" id="content" name="content" value="<?php echo $content; ?>">
			<label for="username">Author:</label>
			<input type="text" id="author" name="author" value="<?php echo $author; ?>">
			<label for="username">Date:</label>
			<input type="date" id="date" name="date" value="<?php echo $date; ?>">
			<input type="submit" class="regbtn" value="Submit" name="submit">
		</div>
	</form>
</div>
<?php 
if(empty($title) && empty($content) && empty($author) && empty($date)) {
    $message = "No results.";
    include('result.php');
} else {
    $conn = dbConnect();
    $sql_statement = "SELECT blogposts.ID AS blogpostID, USERID, users.FIRSTNAME, TITLE, blogposts.DATE AS BlogPostDate, CONTENT, (SELECT COUNT(COMMENT) FROM `comments` WHERE `BLOGPOSTID` = blogposts.ID) as COMMENTCOUNT FROM `blogposts` JOIN `users` ON blogposts.USERID = users.ID WHERE ";
    
    $present = 0;
    $additions = 0;
    if(!empty($title)) { $sql_statement = $sql_statement . "`TITLE` LIKE '%" . $title . "%'"; $additions++; }
    if(!empty($content)) { 
        if($present < $additions) {
            $sql_statement  = $sql_statement . " AND ";
            $present = $additions;
        }
        $sql_statement  = $sql_statement . "`CONTENT` LIKE '%" . $content . "%'"; 
        $additions++; 
    }
    if(!empty($author)) { 
        if($present < $additions) {
            $sql_statement  = $sql_statement . " AND ";
            $present = $additions;
        }
        $sql_statement  = $sql_statement . "`FIRSTNAME` LIKE '%" . $author . "%'"; 
        $additions++; 
    }
    if(!empty($date)) {
        if($present < $additions) {
            $sql_statement  = $sql_statement . " AND ";
            $present = $additions;
        }
        $sql_statement  = $sql_statement . "`DATE` LIKE '" . $date . "%'"; 
    }
    //echo $sql_statement; //for testing purposes.

    $result = mysqli_query($conn, $sql_statement);
    if(mysqli_affected_rows($conn)>0) {
        echo "<div><form><h3>Results: </h3><table>";
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
}
?>