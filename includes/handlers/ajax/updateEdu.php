<?php
include("../../config.php");

// if(!isset($_POST['username'])){
// 	echo "ERROR: User not logged in.";
// 	exit();
// }
if(isset($_POST['input']) && $_POST['input'] != ""){
	
	// $username = $_POST['username'];
	$input = $_POST['input'];
	$id = $_POST['id'];
	$tag = $_POST['tag'];

	$updateQuery = mysqli_query($con, "UPDATE education SET $tag = '$input' WHERE id=$id");

}


?>