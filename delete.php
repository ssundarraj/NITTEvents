<html>
<head></head>
<body>
	<h1>Delete event</h1>
	<?php
		session_start();
		require "dbconfig.ini";
		if(!isset($_SESSION['logged_in'])&&$_SESSION['logged_in']==0){
			echo "Please log in.";
			header('Location:  login.php');
			exit();
		}
		else if(!isset($_SESSION['eid'])){
			echo("Select an option!");
			header('Location:  index.php');
			exit();
		}
		else{
			$eid=$_SESSION['eid'];
			if(isset($_POST['action'])){
				if($_POST['action']=='Yes'){
					$con=mysqli_connect("localhost", $MYDB_USER, $MYDB_PASS,$MYDB_DB);
					$sql="DELETE FROM events "
						."WHERE eid='$eid'";
					$result=mysqli_query($con, $sql);
					mysql_close($con);
					echo "Deleted";
					header('Location:  index.php');
					exit();
				}
				else if($_POST['action']=='No'){
					header('Location:  index.php');
					exit();
				}
			}
		}
	?>
	<a href="logout.php">Logout</a>
	<a href="index.php">Go back</a><br />
	<p> Are you sure you want to delete the following event?</p>
	<form method="post" enctype="multipart/form-data" action="delete.php">
	    <input type='submit' id="Yes" name="action" value='Yes'/>
	    <input type='submit' id="No" name="action" value='No'/>
	</form>
</body>
</html>