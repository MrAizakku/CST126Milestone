<!--
 * Project name: CST126 Milestone 3: Blog
 * Programmer: Isaac Tucker
 * Date: 01/14/2021
 * Short synopsis: This is a partial page HEader with the purpose of (1) starting the HTML page, 
 (2) setting the CSS styles, (3) showing the app title and (4) show the navigation menu.
 -->
<html>
<head>
	<title>Isaac Blog</title>
	 <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="header">
<?php if (!isset($_SESSION['USERNAME'])): ?>
<a href="index.php">Home</a> | <a href="login.html">Login</a> | <a href="register.html"> Register </a>
<?php else: ?>
Welcome 
<?php echo $_SESSION['USERNAME']; ?>:  <a href="index.php">Home</a> | <a href="logout.php">Logout</a>
<?php endif; ?> | Blog (<a href="blogPost.php">Post</a> | <a href="blogView.php?MODE=ALL">All Posts</a> | <a href="blogView.php?MODE=MY">My Posts</a>)
<?php if ($_SESSION['ROLE']=='EXEC'): ?>
| <a href="users.php">View Users</a>
<?php endif; ?>
</div>
</body>