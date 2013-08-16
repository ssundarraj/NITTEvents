<html>
<head></head>
<body>
	<h1>Delete event</h1>
	<?php
		session_start();
		require "dbconfig.ini";
		if(!isset($_SESSION['logged_in'])&&$_SESSION['logged_in']==0){
			echo "Please log in.";
			echo "<META HTTP-EQUIV='refresh' content='1; URL=login.php'>";
		}
		else if(!isset($_SESSION['eid'])){
			echo("Select an option!");
			echo "<META HTTP-EQUIV='refresh' content='1; URL=index.php'>";
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
					echo "<META HTTP-EQUIV='refresh' content='1; URL=index.php'>";
				}
				else if($_POST['action']=='No'){
					echo "<META HTTP-EQUIV='refresh' content='1; URL=index.php'>";
				}
			}
		}
	?>
	<a href="logout.php">Logout</a><br />
	<a href="index.php">Go back</a><br />
	<p> Are you sure you want to delete the following event?</p>
	<form method="post" enctype="multipart/form-data" action="delete.php">
	    <input type='submit' id="Yes" name="action" value='Yes'/>
	    <input type='submit' id="No" name="action" value='No'/>
	</form>
</body>
</html>