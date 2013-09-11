<html>
<head>
	<title>NITTEvents - Account Management</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="http://code.jquery.com/jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.css" media='screen'>
	<script src="./js/bootstrap.min.js"></script>
	<style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    img{
      	height: 60px;
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
	<p><?php echo $successmsg; ?></p>
	<h2>Change password:</h2>
	<form method="post" enctype="multipart/form-data" action="index.php?action=account">
		<table>
		<tbody>
		<tr><?php echo $errormsg ?></tr>
		<tr><th><label for="password">Old password</label></th>
		<td><input type="password" id="password" name="password"></td></tr>

		<tr><th><label for="newpassword">New password</label></th>
		<td><input type="password" id="newpassword" name="newpassword"></td></tr>

		<tr><th><label for="newpasswordrpt">Repeat password</label></th>
		<td><input type="password" id="newpasswordrpt" name="newpasswordrpt"></td></tr>

		<tr><th><label for="Change password"></label></th><td><button class="btn btn-inverse" id="Change" name="Change">Change</button></td></tr>
		</tbody>
		</table>
	</form>

	<h2>Change picture:</h2>
	<form method="post" enctype="multipart/form-data" action="index.php?action=account">
	<table>
	<tbody>
	<tr><th><label for="pic">User picture</label></th>
		<td><input type="file" decsription="pic" name="pic" id="pic" value=><?php echo $picerrmsg; ?>
			Existing picture:<img src='<?php echo './pics/users/'.$_SESSION['userid'].'.jpeg'; ?>' height=60px /></td></tr>

	<tr><th><label for="Change"></label></th><td><button class="btn btn-inverse" id="Change" name="Change">Change</button></td></tr>
	</tbody>
	</table>
	</form>
</div>
	<div id="footer">
	  <div class="container">
		<p class="muted credit">Created by Delta <a href="index.php?action=terms">Terms of use</a></p>
	  </div>
	 </div>
</body>
</html>