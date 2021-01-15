<!--
 * Project name: CST126 Milestone 3: Blog
 * Programmer: Isaac Tucker
 * Date: 01/14/2021
 * Short synopsis: This is a partial page with the purpose of (1) starting the HTML page, 
 (2) setting the CSS styles, (3) show the app title and (4) show the navigation menu.
 -->
<html>
<head>
	<title>Isaac Blog</title>
	 <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="header">
<?php
if (!isset($_SESSION['USERNAME'])):
?>
<span class="menu-item"><a href="login.html">Login</a></span> | <span class="menu-item"><a href="register.html"> Register </a> </span> 
<?php else: ?>
<span class="menu-item">Welcome <?php echo $_SESSION['USERNAME']; ?>:  <a href="logout.php">Logout</a></span>
<?php endif; ?>

| <span class="menu-item">Blog (<a href="blogPost.php">Post</a> | <a href="blogView.php">View</a>) </span>
</div>
</body>