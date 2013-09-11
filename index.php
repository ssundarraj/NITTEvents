<?php
	session_start();
	if(!isset($_SESSION['logged_in'])||!$_SESSION['logged_in']==1){
		include "login.php";
	}
	else{
		if(!isset($_GET['action']))
			include "events.php";
		else{
			if($_GET['action']=='add'){
				include "addevent.php";
			}
			if($_GET['action']=='manage'){
				include "account.php";
			}
			if($_GET['action']=='modify'){
				include "modify.php";
			}
			if($_GET['action']=='delete'){
				include "delete.php";
			}
			if($_GET['action']=='terms'){
				include "terms.php";
			}
		}
	}
?>