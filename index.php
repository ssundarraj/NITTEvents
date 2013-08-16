<html>
<head></head>
<body>
	<h1>Event management</h1>
	<?php
		session_start();
		require "dbconfig.ini";
		if(!isset($_SESSION['logged_in'])&&$_SESSION['logged_in']==0){
			echo "Please log in.";
			echo "<META HTTP-EQUIV='refresh' content='1; URL=login.php'>";
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
						echo "<META HTTP-EQUIV='refresh' content='1; URL=modify.php'>";
					else if($_POST['action']='Delete')
						echo "<META HTTP-EQUIV='refresh' content='1; URL=delete.php'>";
				}
			}
		}
	?>
	<a href="logout.php">Logout</a><br />
	<form method="post" enctype="multipart/form-data" action="index.php">
	<table border="2">
	<tbody>
		<tr><?php echo $errormsg ?></tr>
		<tr>
		<?php
			$con=mysqli_connect("localhost", $MYDB_USER, $MYDB_PASS,$MYDB_DB);
			$sql="SELECT * FROM events ORDER BY eid DESC";
			$result=mysqli_query($con, $sql);
			$counter=0; $linebreak=2;
			while($row=mysqli_fetch_array($result)){
				if($counter===0||$counter % $linebreak===0){
					echo "</tr><tr>";								
				}
				echo "<td><input type='radio' name='event' value='".$row['uid']."'>".$row['ename']."<p>".$row['edesc']."</p></td>";
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