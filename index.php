<?php 
	session_start();
	$isValid = $_SESSION['userid'];
	if ($isValid) {
		header("Location: /home");
	}else{
		header("Location: /login");
	}
?>