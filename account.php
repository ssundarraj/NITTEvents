<html>
<head>
	<title>NITTEvents - Account Management</title>
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.css">
	<script src="./js/bootstrap.js"></script>
</head>
<body>
	<h1>Account management</h1>
	<?php
		session_start();
		$errormsg=""; $successmsg="";
		require "dbconfig.ini";
		if(!isset($_SESSION['logged_in'])&&$_SESSION['logged_in']==0){//Checking if logged in
			echo "Please log in.";
			header('Location:  login.php');
			exit();
		}
		else{
			if(isset($_POST['password'])&&isset($_POST['newpassword'])&&isset($_POST['newpasswordrpt'])){//checking if form has been submitted
				$found=0; $valid=0;
				$con=mysqli_connect("localhost", $MYDB_USER, $MYDB_PASS,$MYDB_DB);
				$sql="SELECT * FROM users";
				$result=mysqli_query($con, $sql);
				while($row=mysqli_fetch_array($result)){
					if($row['uid']==$_SESSION['userid']){//checking if old password is correct
						if($row['password']==md5($_POST['password']))
							$found=1;
						else $errormsg="Incorrect password. ";
					}
				}
				mysql_close($con);
				if($_POST['newpassword']==$_POST['newpasswordrpt'])//checking if the new passwords match
					$valid=1;
				else
					$errormsg=$errormsg."Passwords do not match.";
				if($found==1&&$valid==1){//changing password
					$con=mysqli_connect("localhost", $MYDB_USER, $MYDB_PASS, $MYDB_DB);
					$newpassword=mysql_real_escape_string($_POST['newpassword']);
					$sql="UPDATE users SET password= '".md5($newpassword)."' WHERE uid=$_SESSION[userid]";
					$result=mysqli_query($con, $sql);
					mysqli_close();
					$successmsg="Password changed!";
					header("Location: index.php");
					exit();
				}
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
			if($isFileValid){
				$con=mysqli_connect("localhost", $MYDB_USER, $MYDB_PASS,$MYDB_DB);
				$piclocn='./pics/users/'.$_SESSION['userid'].'.jpeg';
				unlink($piclocn);
				move_uploaded_file($_FILES['pic']['tmp_name'], $piclocn);
				$q="UPDATE users SET pic='$piclocn' WHERE uid='$_SESSION[uid]'";
				$res=mysqli_query($con, $q);
				mysqli_close($con);
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

		<tr><th><label for="Change password"></label></th><td><button id="Change" name="Change">Change</button></td></tr>
		</tbody>
		</table>
	</form>

	<h2>Change picture:</h2>
	<form method="post" enctype="multipart/form-data" action="account.php">
	<table>
	<tbody>
	<tr><th><label for="pic">User picture</label></th>
		<td><input type="file" decsription="pic" name="pic" id="pic" value=><?php echo $picerrmsg; ?>
			Existing picture:<img src='<?php echo './pics/users/'.$_SESSION['userid'].'.jpeg'; ?>' height=60px /></td></tr>

	<tr><th><label for="Change password"></label></th><td><button id="Change" name="Change">Change</button></td></tr>
	</tbody>
	</table>
	</form>

</body>
</html>