<html>
<head>
	<title>NITT Events - Event Management</title>
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.css">
</head>
<body>
	<div class="col-md-2">
	</div>
	<div class="col-md-10">
		<h1>Event management</h1>
		<a href="logout.php">Logout</a>
		<a href="account.php">Manage Account</a><br />
		<a href="addevent.php">Add event</a>
		<?php
			session_start();
			require "dbconfig.ini";
			if(!isset($_SESSION['logged_in'])&&$_SESSION['logged_in']==0){//checking if logged in
				echo "Please log in.";
				header('Location:  login.php');
				exit();
			}
			else{
				$errormsg="";
				if(isset($_POST['action'])){//checking if form has been submitted
					if(!isset($_POST['event'])){
						$errormsg='Please select a valid option.';
					}
					else{
						$_SESSION['eid']=$_POST['event'];
						if($_POST['action']=='Modify')
							header('Location:  modify.php');
						else if($_POST['action']='Delete')
							header('Location:  delete.php');
						exit();	
					}
				}
			}
		?>
		
		
		<form method="post" enctype="multipart/form-data" action="index.php">
		<table border="2">
		<tbody>
			<th></th><th>Name</th><th>Description</th><th>Image</th><th>Time</th><th>Venue</th><th>Location</th>
			<tr><?php echo $errormsg ?></tr>
			<tr>
			<?php
				$con=mysqli_connect("localhost", $MYDB_USER, $MYDB_PASS,$MYDB_DB);
				$sql="SELECT * FROM events WHERE UID=$_SESSION[userid] ORDER BY eid DESC";
				$result=mysqli_query($con, $sql);
				$counter=0; $linebreak=2;
				//Displaying events in a table:
				while($row=mysqli_fetch_array($result)){
					echo "</tr><tr>";
					echo "<td><input type='radio' name='event' value='".$row['eid']
						."'></td><td>".$row['ename']."</td><td>".$row['edesc']."</td><td>"
						."<img src='".$row['pic']."' height=60px/>"."</td><td>"
						.$row['etime']."</td><td>".$row['evenue']."</td><td>".$row['lat'].", ".$row['lng']."</td>";
					$counter++;
				}
				mysqli_close($con);
			?>
			</tr>
		</tbody>
		</table>
			<input type='submit' id="Modify" name="action" value='Modify'/>
			<input type='submit' id="Delete" name="action" value='Delete'/>
		</form>
		
	</div>
</body>
</html>