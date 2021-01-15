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