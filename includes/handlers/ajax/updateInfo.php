<?php
include("../../config.php");

// if(!isset($_POST['username'])){
// 	echo "ERROR: User not logged in.";
// 	exit();
// }
if(isset($_POST['input']) && $_POST['input'] != ""){
	
	// $username = $_POST['username'];
	$input = $_POST['input'];
	$userID = $_SESSION['id'];
	$id = $_POST['id'];
	$updateQuery = mysqli_query($con, "UPDATE resumeinfo SET $id = '$input' WHERE userID='$userID'");

}


?>