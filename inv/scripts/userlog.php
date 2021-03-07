<?php
session_start();
include_once('db_conx.php');
// Files that inculde this file at the very top would NOT require connection to database or session_start(), be careful.
// Initialize some vars
$user_ok = false;
$log_id = "";
$log_username = "";
$log_password = "";
$user_level = "";
// User Verify function
function evalLoggedUser($conx,$id,$u,$p,$ul){
	$sql = "SELECT * FROM user_option WHERE id ='$id' AND username ='$u' AND password='$p' AND user_level = '$ul' AND blocked = '0' LIMIT 1";
    $query = mysqli_query($conx, $sql);
    $numrows = mysqli_num_rows($query);
	if($numrows > 0){
		return true;
		//echo $numrows;exit();
	}
}
if(isset($_SESSION["userid"]) && isset($_SESSION["user"]) && isset($_SESSION["pass"]) && isset($_SESSION["ul"])) {
	$log_id = preg_replace('#[^0-9]#', '', $_SESSION['userid']);
	$log_username = preg_replace('#[^a-z0-9]#i', '', $_SESSION['user']);
	$log_password = preg_replace('#[^a-z0-9$/]#i', '', $_SESSION['pass']);
	$user_level = preg_replace('#[^a-z]#', '', $_SESSION['ul']);
	// Verify the user
	$user_ok = evalLoggedUser($conx,$log_id,$log_username,$log_password,$user_level);
}
?>