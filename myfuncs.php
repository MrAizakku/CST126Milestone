<?php
function dbConnect() {
    $conn = mysqli_connect("localhost", "root", "root", "cst126");
    if (!$conn) {
        die("ERROR: Connection failed:" . mysqli_connect_error());
    }
    return $conn;
}
function saveUserId($id)
{
    session_start();
    $_SESSION["USER_ID"] = $id;
}
function getUserId()
{
    session_start();
    return $_SESSION["USER_ID"];
}
function saveUsername($Username) {
    session_start();
    $_SESSION["USERNAME"] = $Username;
}
function getUserName() {
    session_start();
    return $_SESSION["USERNAME"];
}
?>