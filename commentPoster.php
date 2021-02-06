<?php
session_start();
require('myfuncs.php');

if (!isset($_SESSION['USERNAME'])) {
    header('Location: login.html');
    exit;
}
$blogid = $_GET["blogid"];
$commentid = $_GET["commentid"];
$userid = $_GET["userid"];
$mode = $_GET["mode"];
$currUser = getUserId();

if(isset($_POST['submit'])){ //check if form was submitted
    $comment = $_POST["comment"];
    $comment= filterwords($comment);
    $rating = $_POST["rating"];
    echo $rating;
}

require_once 'header.php';
if(is_null($comment) && $mode=="Post") {
    if((is_null($commentid) || is_null($userid)) && isset($blogid)) { //expects only a blog ID so we know where the new comment will go
        echo '
        <div class="form-container">
        <h2>Comment on that post!</h2>
        <form action="" method="post">
        	<label for="comment">Comment (120 Chars)</label><br>
        	<input type="text" id="comment" name="comment" value="'. $comment . '"><br>
        	    
            <input type="radio" id="good" name="rating" value="1">
            <label for="male">Thumbs Up!</label><br>
            <input type="radio" id="bad" name="rating" value="0">
            <label for="female">Thumbs Down!</label><br>
        	    
        	<input type="submit" id="button" name="submit" class="regbtn" value="Post">
        </form>
        </div>';
    } else {
        $message = "Invalid Entries.";
        include('result.php');
    }
} else if(is_null($comment) && $mode=="Update") { //expects userid and commentid so we know what comment to update
    if ($_SESSION['ROLE'] != 'EXEC' && $userid != $currUser) {
        header('Location: index.html');
        exit;
    }
    //grab the comment to load into the forum
    $conn = dbConnect();
    $sql_statement = "SELECT COMMENT, users.FIRSTNAME, comments.DATE FROM `comments` JOIN `users` ON comments.COMMENTAUTHORID = users.ID WHERE comments.COMMENTID = '$commentid';";
    
    $result = mysqli_query($conn, $sql_statement);
    if($result) {
        $row = mysqli_fetch_assoc($result);
        $comment = $row["COMMENT"];
        echo '
        <div class="form-container">
        <h2>Update that comment!</h2>
        <form action="" method="post">
        	<label for="comment">Comment (120 Chars)</label><br>
        	<input type="text" id="comment" name="comment" value="'. $comment . '"><br>
        	<input type="submit" id="button" name="submit" class="regbtn" value="Post">
        </form>
        </div>';
    } else {
        $message = "Error: " . $sql_statement . "<br>" . $conn->error;
        include('result.php');
    }
    $conn->close();
} else if (isset($comment)){ //if form is submitted
    $conn = dbConnect();
    if($mode=="Post") {
        $date = date('Y-m-d H:i:s');
        
        $sql_statement = "INSERT INTO `comments` (`COMMENTID`, `BLOGPOSTID`, `COMMENTAUTHORID`, `COMMENT`, `DATE`, `RATING`) VALUES (NULL, '$blogid', '$currUser', '$comment', '$date', '$rating')";
        
        if ($conn->query($sql_statement) === TRUE) {
            $message = '<h2>Comment Posted successfully: <p> Comment: ' . $comment . '<p> by: ' . getUserName() . ' ' . $date . '</h2>';
            include('result.php');
        } else {
            $message = "Error: " . $sql_statement . "<br>" . $conn->error;
            include('result.php');
        }
    } else if ($mode=="Update") {
        $sql_statement = "UPDATE `comments` SET `COMMENT` = '$comment' WHERE `comments`.`COMMENTID` = '$commentid';";
        
        if ($conn->query($sql_statement) === TRUE) {
            $message = '<h2>Comment Updated successfully: <p> Comment: ' . $comment . '</h2>';
            include('result.php');
        } else {
            $message = "Error: " . $sql_statement . "<br>" . $conn->error;
            include('result.php');
        }
    }
    $conn->close();
}
include './footer.php';
?>