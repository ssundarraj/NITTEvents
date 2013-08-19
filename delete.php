<html>
<?php
	session_start();
	require "dbconfig.ini";
	$con=mysqli_connect("localhost", $MYDB_USER, $MYDB_PASS,$MYDB_DB);
	$sql="SELECT * FROM events "
		."WHERE eid='$_SESSION[eid]'";
	$result=mysqli_query($con, $sql);
	$row=mysqli_fetch_array($result);
	$userid=$row['uid'];//getting the row corresponding to the entry
	mysql_close($con);
?>
<script language="javascript" type="text/javascript">
    var oldlat = Number("<?php echo $row['lat'] ?>");
    var oldlng = Number("<?php echo $row['lng'] ?>");
</script>
<head>
	<title>NITT Events - Delete Event</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyD3XEhUpJAW7vlS7WE6325ZSHijZkLd4BU&sensor=false"></script>
	<script src="deleteevent_script.js"></script>
</head>
<body>
	<h1>Delete event</h1>
	<?php
		require "dbconfig.ini";
		if(!isset($_SESSION['logged_in'])&&$_SESSION['logged_in']==0){//checking if logged in
			echo "Please log in.";
			header('Location:  login.php');
			exit();
		}
		else if(!isset($_SESSION['eid'])){//checking if form is submitted
			echo("Select an option!");
			header('Location:  index.php');
			exit();
		}
		else if($userid!=$_SESSION['userid']){
			header('Location:  index.php');
			exit();
		}
		else{//Deleting
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
	<?php
		//Displaying the data of the entry
		$con=mysqli_connect("localhost", $MYDB_USER, $MYDB_PASS,$MYDB_DB);
		$sql="SELECT * FROM events "
			."WHERE eid='$_SESSION[eid]'";
		$result=mysqli_query($con, $sql);
		$row=mysqli_fetch_array($result);
		echo "<p>".$row['ename']."<br />".$row['edesc']."<br />On: ".$row['edate']." at: ".$row['etime'];
		mysql_close($con);
	?>
	<div id="googleMap" style="width:500px;height:380px;"></div>
	<br />
	<form method="post" enctype="multipart/form-data" action="delete.php">
	    <input type='submit' id="Yes" name="action" value='Yes'/>
	    <input type='submit' id="No" name="action" value='No'/>
	</form>
</body>
</html>