<?php
session_start();
require('myfuncs.php');

if ($_SESSION['ROLE'] != 'EXEC') {
    header('Location: index.html');
    exit;
}

require_once 'header.php';

$conn = dbConnect();

$sql_statement = "SELECT * FROM `users`";
$result = mysqli_query($conn, $sql_statement);
if(mysqli_affected_rows($conn)>0) {
    echo "<div><form><h3>All Users</h3><table>";
    echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Username</th><th>Password</th><th>Role</th><th>Delete</th><th>Role</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row["ID"];
        $firstname = $row["FIRSTNAME"];
        $lastname = $row["LASTNAME"];
        $username = $row["USERNAME"];
        $password = "*****";
        $role = $row["ROLE"];
        echo "<tr><td>" . $id . "</td><td>" . $firstname . "</td><td>" . $lastname . "</td><td>" . $username . "</td><td>" . $password . "</td><td>" . $role . "</td><td><a href=userHandler.php?id=" . $id . "&mode=Delete style='color: blue'>Del</a></td><td><a href=userHandler.php?id=" . $id . "&mode=Update&role=".$role." style='color: blue'>Change Role</a></td></tr>";
    }
    echo "</table></form></div>";
    include './footer.php';
} else {
    $message = "No users found.";
    include('result.php');
}
?>