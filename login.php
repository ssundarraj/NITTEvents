<html>
<head></head>
<body>
	<h1>Please Login</h1>
	<?php
		session_start();
		require "dbconfig.ini";
		if(isset($_SESSION['logged_in'])&&$_SESSION['logged_in']==1){
			echo "Already logged in";
			echo "<META HTTP-EQUIV='refresh' content='1; URL=index.php'>";
		}
		else{
			if(isset($_POST['username'])&&isset($_POST['password'])){
				//echo $_POST['username'];
				//echo $_POST['password'];
				$valid=0; $found=0;
				$con=mysqli_connect("localhost", $MYDB_USER, $MYDB_PASS,"eventnotif");
				$sql="SELECT * FROM users";
				$result=mysqli_query($con, $sql);
				while($row=mysqli_fetch_array($result)){
					if($row['username']==$_POST['username']){
						//$found=1;
						if($row['password']==$_POST['password']){
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
					echo "<META HTTP-EQUIV='refresh' content='1; URL=index.php'>";
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