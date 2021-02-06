<!--
 * Project name: CST126 Milestone 3: Post to Blog
 * Programmer: Isaac Tucker
 * Date: 01/15/2021
 * Short synopsis: List of functions to use in the application. 
 --> 
 <?php
function dbConnect() {
    //$conn = mysqli_connect("127.0.0.1:54019", "azure", "6#vWHD_$", "cst126");
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
function saveUserRole($role)
{
    session_start();
    $_SESSION["ROLE"] = $role;
}
function getUserRole()
{
    session_start();
    return $_SESSION["ROLE"];
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
    $badWords = array("shit","fuck","fucked","fucking","fucker","ass","cunt","god","damn","retard","bitch");
    $badwordsCount = sizeof($badWords);
    for ($i = 0; $i < $badwordsCount; $i++) {
        $content = preg_replace_callback('/\b' . $badWords[$i] . '\b/i', function($matches){return str_repeat('*', strlen($matches[0]));}, $content);
    }
    return $content;
}
function getUsersByFirstName($searchpattern) {
    $conn = dbConnect();
    $sql_statement = "SELECT * FROM `users` where FIRSTNAME LIKE '%" . $searchpattern . "%';";
    $results = array();
    if ($result = mysqli_query($conn, $sql_statement)) {  
       if(mysqli_affected_rows($conn)>0){
            $index = 0;
            while($row = mysqli_fetch_assoc($result)){
                $results[$index] = array(
                    $row["ID"], $row["FIRSTNAME"], $row["LASTNAME"]
                );
                $index++;
            }
           $conn->close();
           return $results;
        }else {
            $message = " No results found.";
            include('result.php');
        }
        
    } else {
        $message .= "Error: " . $sql_statement . "<br>" . mysqli_error($conn);
        include('result.php');
    }
}
function getAllUsers()
{
    $conn = dbConnect();
    $sql_statement = "SELECT * FROM `users`";
    $users = array();
    
    if ($result = mysqli_query($conn, $sql_statement)) {
        $index = 0;
        while($row = mysqli_fetch_assoc($result)){
            $users[$index] = array(
                $row["ID"], $row["FIRSTNAME"], $row["LASTNAME"]
            );
            $index++;
        }
    } else {
        $message .= "Error: " . $sql_statement . "<br>" . mysqli_error($conn);
        include('result.php');
        
    }
    $conn->close();
    return $users;
}
function getBlogUserID($blogid)
{
    $conn = dbConnect();
    $sql_statement = "SELECT USERID FROM `blogposts` WHERE `ID` = '$blogid';";
    
    if ($result = mysqli_query($conn, $sql_statement)) {
        if(mysqli_affected_rows($conn)>0){
            $row = mysqli_fetch_assoc($result);
            $bloguserID = $row["USERID"];
            $conn->close();
            return $bloguserID;
        }else {
            $message = "Access restricted.";
            include('result.php');
        }
    } else {
        $message .= "Error: " . $sql_statement . "<br>" . mysqli_error($conn);
        include('result.php');
    }
}
function getCommentUserID($commentid)
{
    $conn = dbConnect();
    $sql_statement = "SELECT COMMENTAUTHORID FROM `comments` WHERE `COMMENTID` = '$commentid';";
    
    if ($result = mysqli_query($conn, $sql_statement)) {
        if(mysqli_affected_rows($conn)>0){
            $row = mysqli_fetch_assoc($result);
            $commentuserID = $row["COMMENTAUTHORID"];
            $conn->close();
            return $commentuserID;
        }else {
            $message = "Access restricted.";
            include('result.php');
        }
    } else {
        $message .= "Error: " . $sql_statement . "<br>" . mysqli_error($conn);
        include('result.php');
    }
}
?>