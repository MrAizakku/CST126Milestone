<!--
 * Project name: CST126 Milestone 3: Post to Blog
 * Programmer: Isaac Tucker
 * Date: 01/15/2021
 * Short synopsis: This is the blogPost handler that takes the input data and saves it to the DB. The profanity filter is also called on the inputs before saving.
 -->
 <?php
session_start();
require('myfuncs.php');

$btitle = $_POST["blogTitle"];
$bcontent = $_POST["blogContent"];
$blogid = $_GET["blogid"];
$mode = $_POST["button"];

$btitle = filterwords($btitle);
$bcontent = filterwords($bcontent);


//is_null($BlogTitle) || empty($BlogTitle))
if(!is_null($btitle) && !is_null($bcontent) && $btitle != "" && $bcontent != "") {
    $conn = dbConnect();
    
    if($mode == "Post") {
        $date = date('Y-m-d H:i:s');
        $uname = getUserId();
        
        $sql_statement = "INSERT INTO `blogposts` (`ID`, `USERID`, `TITLE`, `DATE`, `CONTENT`) VALUES (NULL, '$uname', '$btitle', '$date', '$bcontent')";
        
        if ($conn->query($sql_statement) === TRUE) {
            $message = '<h2>Blog Posted successfully: <p> Title: ' . $btitle . '<p> Content: ' . $bcontent . '<p> by: ' . getUserName() . ' ' . $date . '</h2>';
            include('result.php');
        } else {
            $message = "Error: " . $sql_statement . "<br>" . $conn->error;
            include('result.php');
        }
    } else if($mode == "Update") {
        $sql_statement = "UPDATE `blogposts` SET `TITLE` = '$btitle', `CONTENT` = '$bcontent' WHERE `blogposts`.`ID` = '$blogid';";
        if ($conn->query($sql_statement) === TRUE) {
            $message = '<h2>Blog Updated successfully!';
            include('result.php');
        } else {
            $message = "Error: " . $sql_statement . "<br>" . $conn->error;
            include('result.php');
        }
    }
    $conn->close();
} else {
    $message = "Blog post failed." . $sql_statement;
    include('result.php');
}
?>