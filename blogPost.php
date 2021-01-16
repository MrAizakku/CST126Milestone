<!--
 * Project name: CST126 Milestone 3: Post to Blog
 * Programmer: Isaac Tucker
 * Date: 01/15/2021
 * Short synopsis: This page is the form in which a user will input their blog content and hit post to call the blogPoster.php
 -->
<?php
session_start();

if (!isset($_SESSION['USERNAME'])) {
    header('Location: login.html');
    exit;
}

require_once 'header.php';
?>
<div class="form-container">
<h2>Post to your Blog</h2>
<p>Fill out all of the fields and submit</p>
<form action="blogPoster.php" method="post">
	<label for="blogTitle">Blog Title:</label><br>
	<input type="text" id="blogTitle" name="blogTitle"><br>
	<label for="blogContent">Blog Content:</label><br>
	<textarea style="width: 100%;" rows="5" id="blogContent" name="blogContent"></textarea><br>
	<input type="submit" class="regbtn" value="Post">
</form>
</div>

<?php include './footer.php';?>