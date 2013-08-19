<html>
<head>
	<title>NITT Events - Modify Event</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyD3XEhUpJAW7vlS7WE6325ZSHijZkLd4BU&sensor=false"></script>
	<script src="modifyevent_script.js"></script>
</head>
<body>
	<h1>Modify event</h1>
	<?php
		session_start();
		require "dbconfig.ini";
		//getting the row corresponding to the entry
		$con=mysqli_connect("localhost", $MYDB_USER, $MYDB_PASS,$MYDB_DB);
		$sql="SELECT * FROM events "
			."WHERE eid='$_SESSION[eid]'";
		$result=mysqli_query($con, $sql);
		$row=mysqli_fetch_array($result);
		$userid=$row['uid'];
		mysql_close($con);
		if(!isset($_SESSION['logged_in'])&&$_SESSION['logged_in']==0){//checking if logged in
			echo "Please log in.";
			header('Location:  login.php');
			exit();
		}
		else if(!isset($_SESSION['eid'])){
			echo("Select an option!");
			header('Location:  index.php');
			exit();
		}
		else if($userid!=$_SESSION['userid']){//checking if the entry belongs to the user
			header('Location:  index.php');
			exit();
		}
		else{
			$eid=$_SESSION['eid'];
			$errormsg="";//initializing error messages
			$nameerrmsg="";
			$descerrmsg="";
			$dateerrmsg="";
			$timeerrmsg="";
			$venueerrmsg="";
			$valid=1;
			if(isset($_POST['name'])){
				if($_POST['name']==""){
					$valid=0;
					$nameerrmsg="Invalid name!";
				}
				if($_POST['desc']==""){
					$valid=0;
					$descerrmsg="Invalid description!";
				}
				if(!checkdate($_POST['month'],$_POST['day'], $_POST['year'])){
					$valid=0;
					$dateerrmsg="Invalid date!";
				}
				$ex="/^(?:0[1-9]|1[0-2]):[0-5][0-9]$/";
				if(!preg_match($ex, $_POST['time'])){
					$valid=0;
					$timeerrmsg="Invalid time!";
				}
				if($_POST['lat']==0&&$_POST['lng']==0){
					$valid=0;
					$venueerrmsg="Invalid selection!";
					echo "WTF";	
				}

				if($valid==1){
					//Changing the data if needed:
					$date=$_POST['day']."-".$_POST['month']."-".$_POST['year'];
					$con=mysqli_connect("localhost", $MYDB_USER, $MYDB_PASS,$MYDB_DB);
					$name=mysql_real_escape_string($_POST['name']);
					$desc=mysql_real_escape_string($_POST['desc']);
					$time=mysql_real_escape_string($_POST['time']);
					$venue=mysql_real_escape_string($_POST['venue']);			
					$sql="UPDATE events SET ename='$name', edesc='$desc', "
						."edate='$date', etime='$time', lat='$_POST[lat]', lng='$_POST[lng]' "
						."WHERE eid='$eid'";
					$result=mysqli_query($con, $sql);
					echo $sql;
					mysql_close($con);
					echo "Modified";
					header('Location:  index.php');
					exit();
				}
			}
		}
	?>
	<a href="logout.php">Logout</a>
	<a href="index.php">Go back</a><br />
	<form method="post" enctype="multipart/form-data" action="modify.php">
	    <table>
	    <tbody>
	    <tr><td colspan='2'><?php echo $errormsg ?></td></tr>

	    <tr><th><label for="name">Event name</label></th>
	    <td><input type="text" decsription="name" name="name" id="name" value=<?php echo $row['ename'] ?>>
	    	<?php echo $nameerrmsg; ?></td></tr>

		<tr><th><label for="desc">Description</label></th>
		<td><textarea type="text" rows="4" cols="50" decsription="desc" name="desc" id="desc"><?php echo $row['edesc'] ?></textarea>
			<?php echo $descerrmsg; ?></td></tr>

		<tr><th><label >Event date</label></th>
		<td>
			<input type="text" decsription="day" name="day" id="day" size='2' value=<?php echo substr($row['edate'], 0,2) ?>>-
			<input type="text" decsription="month" name="month" id="month" size='2' value=<?php echo substr($row['edate'], 3,2) ?>>-
			<input type="text" decsription="year" name="year" id="year" size='2' value=<?php echo substr($row['edate'], 6, 4) ?>>
			<?php echo $dateerrmsg; ?>
		</td></tr>

		<tr><th><label for="time">Event time</label></th>
		<td><input type="text" decsription="time" name="time" id="time" size='5' value=<?php echo $row['etime'] ?>>
			<?php echo $timeerrmsg; ?></td></tr>

		</tbody>
		</table>
		<input type="text" decsription="lat" name="lat" id="lat" hidden='hidden' value=<?php echo $row['lat'] ?>>
		<input type="text" decsription="lng" name="lng" id="lng" hidden='hidden' value=<?php echo $row['lng'] ?>>
		Select event venue
		<?php echo $venueerrmsg; ?>
		<div id="googleMap" style="width:500px;height:380px;"></div>
		<button id="Modify" name="Modify">Modify</button><br />
		Note: Enter the date in the format: (dd/mm/yyyy), and time in 24 hour format.
	</form>
</body>
</html>