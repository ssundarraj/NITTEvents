<?php
	session_start();
	session_destroy();
	echo "You have been logged out. You will now be redirected to the login page";
	header('Location:  login.php');
	exit();
?>