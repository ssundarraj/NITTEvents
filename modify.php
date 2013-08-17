<html>
<head></head>
<body>
	<h1>Modify event</h1>
	<?php
		session_start();
		$con=mysqli_connect("localhost", $MYDB_USER, $MYDB_PASS,$MYDB_DB);
		$sql="SELECT * FROM events "
			."WHERE eid='$_SESSION[eid]'";
		$result=mysqli_query($con, $sql);
		$row=mysqli_fetch_array($result);
		$userid=$row['uid'];
		mysql_close($con);
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
		else if($userid!=$_SESSION['userid']){
			header('Location:  index.php');
			exit();
		}
		else{
			$eid=$_SESSION['eid'];
			unset($_SESSION['eid']);
			$errormsg="";
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

				if($valid==1){
					$date=$_POST['day']."-".$_POST['month']."-".$_POST['year'];
					$con=mysqli_connect("localhost", $MYDB_USER, $MYDB_PASS,$MYDB_DB);
					$name=mysql_real_escape_string($_POST['name']);
					$desc=mysql_real_escape_string($_POST['desc']);
					$time=mysql_real_escape_string($_POST['time']);
					$venue=mysql_real_escape_string($_POST['venue']);			
					$sql="UPDATE events SET ename='$name', edesc='$desc', "
						."edate='$date', etime='$time', evenue='$venue' "
						."WHERE eid='$eid'";
					$result=mysqli_query($con, $sql);
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
	    <td><input type="text" decsription="name" name="name" id="name"><?php echo $nameerrmsg; ?></td></tr>

		<tr><th><label for="desc">Description</label></th>
		<td><input type="text" rows="4" cols="50" decsription="desc" name="desc" id="desc"><?php echo $descerrmsg; ?></td></tr>

		<tr><th><label >Event date</label></th>
		<td>
			<input type="text" decsription="day" name="day" id="day" size='2' value="dd" onclick="this.value='';">-
			<input type="text" decsription="month" name="month" id="month" size='2' value="mm" onclick="this.value='';">-
			<input type="text" decsription="year" name="year" id="year" size='2' value="yyyy" onclick="this.value='';">
			<?php echo $dateerrmsg; ?>
		</td></tr>

		<tr><th><label for="time">Event time</label></th>
		<td><input type="text" decsription="time" name="time" id="time" size='5'><?php echo $timeerrmsg; ?></td></tr>

		<tr><th><label for="venue">Event venue</label></th>
		<td><select type="venue" decsription="venue" name="venue" id="venue">
			<option value="Octagon">Octagon</option>
			<option value="EEE Audi">EEE Audi</option>
			<option value="A12 Hall">A12 Hall</option>
			<option value="A3 Hall">A3 Hall</option>
		</select>
		<?php echo $venueerrmsg; ?>
		</td></tr>
		<tr><th></th><td><button id="Modify" name="Modify">Modify</button></td></tr>
		</tbody>
		</table>
		Note: Enter the date in the format: (dd/mm/yyyy), and time in 24 hour format.
	</form>
</body>
</html>