<!--
 * Project name: CST126 Milestone 3: Post to Blog
 * Programmer: Isaac Tucker
 * Date: 01/15/2021
 * Short synopsis: I had a bunch of LoginSuccess, LoginFailure, RegisterSuccess, etc... pages lying around and noticed they were all essentially the same page.
 *                 So i condensed them all into the same page.
 -->
 <?php
session_start();
require_once 'header.php';
?>
<h2><?php echo $message?></h2>

<?php include './footer.php';?>
