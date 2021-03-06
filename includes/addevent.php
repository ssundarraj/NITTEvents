<html>
<head>
	<title>NITT Events - Add Event</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="http://code.jquery.com/jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.css" media='screen'>
	<script src="./js/bootstrap.min.js"></script>
	<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyD3XEhUpJAW7vlS7WE6325ZSHijZkLd4BU&sensor=false"></script>
	<script src="./js/addevent_script.js"></script>
	<style>
		body{
			padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
		}
	</style>
</head>
<body>
	 <div class="navbar navbar-inverse navbar-fixed-top">
	  <div class="navbar-inner">
		<div class="container">
		  <a class="brand" href="#">NITT Events</a>
		  <div class="nav-collapse collapse">
			<ul class="nav">
			  <li><a href="./includes/logout.php">Logout</a></li>
			  <li><a href="index.php">Go back</a></li>
			</ul>
		  </div><!--/.nav-collapse -->
		</div>
	  </div>
	</div>
	<div class="container">
	<h1>Add event</h1>
	<?php
		session_start();
		require "dbconfig.ini";
		if(!isset($_SESSION['logged_in'])&&$_SESSION['logged_in']==0){//Checking if logged in
			echo "Please log in.";
			header('Location:  login.php');
			exit();
		}
		else{
			$errormsg="";//Initialiing error messages
			$nameerrmsg="";
			$descerrmsg="";
			$dateerrmsg="";
			$timeerrmsg="";
			$venueerrmsg="";
			$valid=1;
			//Validating parameters:
			if(isset($_POST['name'])){
				if($_POST['name']==""){
					$valid=0;
					$nameerrmsg="Invalid name!";
				}
				if($_POST['desc']==""){
					$valid=0;
					$descerrmsg="Invalid description!";
				}
				date_default_timezone_set('Asia/Calcutta');
				$date1=date("Y-m-d");
				if(!checkdate($_POST['month'],$_POST['day'], $_POST['year'])||strcmp($date1, $_POST['year']."-".$_POST['month']."-".$_POST['day'])>0){
					$valid=0;
					$dateerrmsg="Invalid date!";
				}
				$ex="/^(?:0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/";
				if(!preg_match($ex, $_POST['time'])){
					$valid=0;
					$timeerrmsg="Invalid time!";
				}
				if($_POST['lat']==0||$_POST['lng']==0){
					$valid=0;
					$locnerrmsg="Invalid selection!";
				}
				if($_POST['venue']==''){
					$valid=0;
					$venueerrmsg="Please enter a venue!";
				}
				if($_FILES['pic']['name']==''){
					$isFileValid=0;
				}
				else if($_FILES['pic']['type']='image/jepg'){
					$isFileValid=1;
				}
				else{
					$isFileValid=0;
					$picerrmsg="Invalid format";
					$valid=0;
				}

				if($valid==1){//inserting if valid
					$date=$_POST['year']."-".$_POST['month']."-".$_POST['day'];
					$con=mysqli_connect("localhost", $MYDB_USER, $MYDB_PASS,$MYDB_DB);
					$name=mysql_real_escape_string($_POST['name']);
					$desc=mysql_real_escape_string($_POST['desc']);
					$time=mysql_real_escape_string($_POST['time']);
					$venue=mysql_real_escape_string($_POST['venue']);
					$sql="INSERT INTO events (uid, ename, edesc, edate, etime, lat, lng, evenue) "
						."VALUES ('$_SESSION[userid]', '$name', '$desc', '$date', '$time', '$_POST[lat]', '$_POST[lng]', "
						."'$_POST[venue]')";
					$result=mysqli_query($con, $sql);

					date_default_timezone_set('Asia/Calcutta');
					$curdatetime=date("Y-m-d:H:i:s");
					$updatequery="UPDATE updatetime SET lasttime='$curdatetime'";
					mysqli_query($con, $updatequery);
					
					if($isFileValid){
						$q="SELECT * FROM events WHERE ename='$_POST[name]' and edate='$date' "
							."and etime='$time' and evenue='$_POST[venue]' ORDER BY eid desc";
						$res=mysqli_query($con, $q);
						$row=mysqli_fetch_array($res);

						$piclocn='./pics/events/'.$row['eid'].'.jpeg';
						move_uploaded_file($_FILES['pic']['tmp_name'], $piclocn);
						$q="UPDATE events SET pic='$piclocn' WHERE eid='$row[eid]'";
						$res=mysqli_query($con, $q);
					}
					mysqli_close($con);
					echo "Added";
					header('Location:  index.php');
					exit();
				}
				$dayval=$_POST['day'];
				$monval=$_POST['month'];
				$yearval=$_POST['year'];
			}
		}
	?>
	<form method="post" enctype="multipart/form-data" action="index.php?action=add">
	    <table>
	    <tbody>
	    <tr><td colspan='2'><?php echo $errormsg ?></td></tr>

	    <tr><th><label for="name">Event name</label></th>
	    <td><input type="text" style="height:30px;" decsription="name" name="name" id="name" value=<?php echo $_POST['name']; ?>><?php echo $nameerrmsg; ?></td></tr>

		<tr><th><label for="desc">Description</label></th>
		<td><textarea type="text" rows="4" cols="50" decsription="desc" name="desc" id="desc"><?php echo $_POST['desc']; ?></textarea>
			<?php echo $descerrmsg; ?></td></tr>

		<tr><th><label >Event date</label></th>
		<td>
			<input type="text" style="height:30px;" class='input-mini' decsription="day" name="day" id="day" size='4' placeholder='dd'value=<?php echo $dayval ?>>-
			<input type="text" style="height:30px;" class='input-mini' decsription="month" name="month" id="month" size='2' placeholder='mm' value=<?php echo $monval ?>>-
			<input type="text" style="height:30px;" class='input-mini' decsription="year" name="year" id="year" size='4' placeholder='yyyy' value=<?php echo $yearval ?>>
			<?php echo $dateerrmsg; ?>
		</td></tr>

		<tr><th><label for="time">Event time</label></th>
		<td><input type="text" style="height:30px;" decsription="time" name="time" id="time" size='5' value=<?php echo $_POST['time']; ?>><?php echo $timeerrmsg; ?></td></tr>

		<tr><th><label for="pic">Event pic</label></th>
		<td><input type="file" decsription="pic" name="pic" id="pic" value=<?php echo $_POST['pic']; ?>><?php echo $picerrmsg; ?></td></tr>

		<tr><th><label for="venue">Event venue</label></th>
		<td><input type="text" style="height:30px;" decsription="venue" name="venue" id="venue" value=<?php echo $_POST['venue']; ?>><?php echo $venueerrmsg; ?></td></tr>

		<tr><th><label for="venue">Select the coordinates</label></th></tr>
		</tbody>
		</table>
		<input type="text" decsription="lat" name="lat" id="lat" style="display:none;">
		<input type="text" decsription="lng" name="lng" id="lng" style="display:none;">
		<?php echo $locnerrmsg; ?>
		<div id="googleMap" style="width:500px;height:380px;"></div>

		<td><input class="btn btn-inverse" type='submit' id="Add" name="Add" value='Add'><br />
		Note: 
		<ol>
			<li>Enter the date in the format: (yyyy/mm/dd), and time in 24 hour format.</li>
			<li>Make sure that the venue matches the location on the map. If this is not done it will lead to deletion of the event.</li>
			<li>If no photo has been attached the photo for the account will be used.</li>
			<li>Please make sure that the events adhere to the <a href='terms.php'>terms of use</a>.</li>
			<li>				<?php var_dump($date1)."|||"; echo $_POST['year']."-".$_POST['month']."-".$_POST['day']?></li>
		</ol>
	</form>
</div>
<div id="footer">
	  <div class="container">
		<p class="muted credit">Created by Delta <a href="index.php?action=terms">Terms of use</a></p>
	</div>
</div>
</body>
</html>