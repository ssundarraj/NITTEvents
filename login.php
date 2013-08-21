<html>
<head>
	<title>NITTEvents - Login</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
	<h1>Please Login</h1>
	<?php
		session_start();
		require "dbconfig.ini";
		if(isset($_SESSION['logged_in'])&&$_SESSION['logged_in']==1){//Checking if already logged in
			echo "Already logged in";
			header('Location:  index.php');
			exit();
		}
		else{
			if(isset($_POST['username'])&&isset($_POST['password'])){//checking credentials
				$valid=0;
				$con=mysqli_connect("localhost", $MYDB_USER, $MYDB_PASS,$MYDB_DB);
				$sql="SELECT * FROM users";
				$result=mysqli_query($con, $sql);
				while($row=mysqli_fetch_array($result)){
					if($row['username']==$_POST['username']){
						if($row['password']==md5($_POST['password'])){
							$valid=1;
							$uid=$row['uid'];
						}
					}

				}
				mysql_close();
				if($valid==1){
					$_SESSION['logged_in']=1;
					$_SESSION['userid']=$uid;
					echo "Valid credentials";
					header('Location:  index.php');
					exit();	
				}
				else{
					$errormsg="Please enter valid login parameters";
				}
			}
		}
	?>
	<form method="post" enctype="multipart/form-data" action="login.php">
		<table>
		<tbody>
		<tr><?php echo $errormsg ?></tr>
		<tr><th><label for="username">Username</label></th><td>
		<input type="text" decsription="Username" name="username" id="username"></td></tr>
		<tr><th><label for="password">Password</label></th><td><input type="password" id="password" name="password"></td></tr>
		<tr><th><label for="Login"></label></th><td><button id="Login" name="Login">Login</button></td></tr>
		</tbody>
		</table>
	</form>
</body>
</html>