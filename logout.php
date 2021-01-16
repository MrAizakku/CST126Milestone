<!--
 * Project name: CST126 Milestone 3: Post to Blog
 * Programmer: Isaac Tucker
 * Date: 01/15/2021
 * Short synopsis: Remove the user data from the session to logout of the application.
 -->
 <?php
session_start();
$_SESSION = array();
session_destroy();
header('Location: index.php');
?>