<?php
	session_start();
	if(!isset($_SESSION['logged_in'])||!$_SESSION['logged_in']==1){
		include "./includes/login.php";
	}
	else{
		if(!isset($_GET['action']))
			include "./includes/events.php";
		else{
			if($_GET['action']=='add'){
				include "./includes/addevent.php";
			}
			if($_GET['action']=='manage'){
				include "./includes/account.php";
			}
			if($_GET['action']=='modify'){
				include "./includes/modify.php";
			}
			if($_GET['action']=='delete'){
				include "./includes/delete.php";
			}
			if($_GET['action']=='terms'){
				include "./includes/terms.php";
			}
		}
	}
?>