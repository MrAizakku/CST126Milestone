<!--
 * Project name: CST126 Milestone 3: Post to Blog
 * Programmer: Isaac Tucker
 * Date: 01/15/2021
 * Short synopsis: List of functions to use in the application. 
 --> 
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
function filterwords($content){
    $badWords = array("shit","fuck","fucked","fucking","fucker","ass","cunt","god","damn","retard");
    $badwordsCount = sizeof($badWords);
    for ($i = 0; $i < $badwordsCount; $i++) {
        $content = preg_replace_callback('/\b' . $badWords[$i] . '\b/i', function($matches){return str_repeat('*', strlen($matches[0]));}, $content);
    }
    return $content;
}
?>