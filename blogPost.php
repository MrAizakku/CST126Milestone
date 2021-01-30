<!--
 * Project name: CST126 Milestone 3: Post to Blog
 * Programmer: Isaac Tucker
 * Date: 01/15/2021
 * Short synopsis: This page is the form in which a user will input their blog content and hit post to call the blogPoster.php
 -->
<?php
session_start();
require('myfuncs.php');

if (!isset($_SESSION['USERNAME'])) {
    header('Location: login.html');
    exit;
}
$blogid = $_GET["blogid"];
$userid = $_GET["userid"];
$currUser = getUserId();
require_once 'header.php';

if(is_null($blogid) || is_null($userid) ) {
    echo '
    <div class="form-container">
    <h2>Post to your Blog</h2>
    <p>Fill out all of the fields and submit</p>
    <form action="blogPoster.php" method="post">
    	<label for="blogTitle">Blog Title:</label><br>
    	<input type="text" id="blogTitle" name="blogTitle"><br>
    	<label for="blogContent">Blog Content:</label><br>
    	<textarea style="width: 100%;" rows="5" id="blogContent" name="blogContent"></textarea><br>
    	<input type="submit" id="button" name="button" class="regbtn" value="Post">
    </form>
    </div>';
    
} else {
    if ($_SESSION['ROLE'] != 'EXEC' && $userid != $currUser) {
        header('Location: index.html');
        exit;
    }
    $conn = dbConnect();
    $sql_statement = "SELECT TITLE, CONTENT FROM `blogposts` WHERE `ID` = '$blogid'";
    $result = mysqli_query($conn, $sql_statement);
    if($result) {
    $row = mysqli_fetch_assoc($result);
        $title = $row["TITLE"];
        $message = $row["CONTENT"];
        echo '<div class="form-container">
            <h2>Update your post</h2>
            <p>Fill out all of the fields and submit</p>
            <form action="blogPoster.php?blogid='.$blogid.'" method="post">
            	<label for="blogTitle">Blog Title:</label><br>
            	<input type="text" id="blogTitle" name="blogTitle" value="'. $title . '"><br>
            	<label for="blogContent">Blog Content:</label><br>
            	<textarea style="width: 100%;" rows="5" id="blogContent" name="blogContent">' . $message . '</textarea><br>
            	<input type="submit" id="button" name="button" class="regbtn" value="Update">
            </form>
            </div>'; 
    } else {
        $message = "Error: " . $sql_statement . "<br>" . $conn->error;
        include('result.php');
    }
    $conn->close(); 
}
include './footer.php';
?>