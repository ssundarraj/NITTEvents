<html>
<head></head>
<body>
	<h1>Account management</h1>
	<?php
		session_start();
		$errormsg=""; $successmsg="";
		require "dbconfig.ini";
		if(!isset($_SESSION['logged_in'])&&$_SESSION['logged_in']==0){
			echo "Please log in.";
			header('Location:  login.php');
			exit();
		}
		else{
			if(isset($_POST['password'])&&isset($_POST['newpassword'])&&isset($_POST['newpasswordrpt'])){
				$found=0; $valid=0;
				$con=mysqli_connect("localhost", $MYDB_USER, $MYDB_PASS,$MYDB_DB);
				$sql="SELECT * FROM users";
				$result=mysqli_query($con, $sql);
				while($row=mysqli_fetch_array($result)){
					if($row['uid']==$_SESSION['userid']){
						if($row['password']==$_POST['password'])
							$found=1;
						else $errormsg="Incorrect password. ";
					}
				}
				mysql_close($con);
				if($_POST['newpassword']==$_POST['newpasswordrpt'])
					$valid=1;
				else
					$errormsg=$errormsg."Passwords do not match.";
				if($found==1&&$valid==1){//not changing here for some reason
					$con=mysqli_connect("localhost", $MYDB_USER, $MYDB_PASS, $MYDB_DB);
					$sql="UPDATE users SET password= '".$_POST['newpassword']."' WHERE uid=$_SESSION[userid]";
					$result=mysqli_query($con, $sql);
					mysql_close();
					$successmsg="Password changed!";
					header("Location: index.php");
					exit();
				}
			}
		}
	?>
	<a href="logout.php">Logout</a>
	<a href="index.php">Go back</a><br />
	<p><?php echo $successmsg; ?></p>
	<h2>Change password:</h2>
	<form method="post" enctype="multipart/form-data" action="account.php">
		<table>
		<tbody>
		<tr><?php echo $errormsg ?></tr>
		<tr><th><label for="password">Old password</label></th>
		<td><input type="password" id="password" name="password"></td></tr>

		<tr><th><label for="newpassword">New password</label></th>
		<td><input type="password" id="newpassword" name="newpassword"></td></tr>

		<tr><th><label for="newpasswordrpt">Repeat password</label></th>
		<td><input type="password" id="newpasswordrpt" name="newpasswordrpt"></td></tr>

		<tr><th><label for="Change"></label></th><td><button id="Change" name="Change">Change</button></td></tr>
		</tbody>
		</table>
	</form>
</body>
</html>