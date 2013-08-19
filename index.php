<html>
<head>
	<title>NITT Events - Event Management</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
	<h1>Event management</h1>
	<?php
		session_start();
		require "dbconfig.ini";
		if(!isset($_SESSION['logged_in'])&&$_SESSION['logged_in']==0){
			echo "Please log in.";
			header('Location:  login.php');
			exit();
		}
		else{
			$errormsg="";
			if(isset($_POST['action'])){
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
	<a href="logout.php">Logout</a>
	<a href="account.php">Manage Account</a><br />
	<a href="addevent.php">Add event</a>
	<form method="post" enctype="multipart/form-data" action="index.php">
	<table border="2">
	<tbody>
		<tr><?php echo $errormsg ?></tr>
		<tr>
		<?php
			$con=mysqli_connect("localhost", $MYDB_USER, $MYDB_PASS,$MYDB_DB);
			$sql="SELECT * FROM events WHERE UID=$_SESSION[userid] ORDER BY eid DESC";
			$result=mysqli_query($con, $sql);
			$counter=0; $linebreak=2;
			while($row=mysqli_fetch_array($result)){
				if($counter===0||$counter % $linebreak===0){
					echo "</tr><tr>";								
				}
				echo "<td><input type='radio' name='event' value='".$row['eid']."'>".$row['ename']."<p>".$row['edesc']."</p></td>";
				$counter++;
			}
		?>
		</tr>
		<tr>
			<td><input type='submit' id="Modify" name="action" value='Modify'/></td>
			<td><input type='submit' id="Delete" name="action" value='Delete'/></td>
		</tr>
	</tbody>
	</table>
	</form>
</body>
</html>